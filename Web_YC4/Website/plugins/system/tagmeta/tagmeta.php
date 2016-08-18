<?php
/**
 * Tag Meta Community plugin for Joomla
 *
 * @author selfget.com (info@selfget.com)
 * @package TagMeta
 * @copyright Copyright 2009 - 2015
 * @license GNU Public License
 * @link http://www.selfget.com
 * @version 1.7.6
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');
jimport('joomla.html.parameter');

defined("WORD_COUNT_MASK") or define("WORD_COUNT_MASK", "/\p{L}[\p{L}\p{N}\p{Mn}\p{Pd}'\x{2019}]*/u");
defined("PLACEHOLDERS_MATCH_MASK") or define("PLACEHOLDERS_MATCH_MASK", '/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*/');
defined("PLACEHOLDERS_MATCH_ALL_MASK") or define("PLACEHOLDERS_MATCH_ALL_MASK", '/\$\{([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\}/U');

class plgSystemTagMeta extends JPlugin
{
  /**
  *
  * @var boolean
  * @access  private
  */
  private $_clean_generator = false;

  /**
  *
  * @var string
  * @access  private
  */
  private $_custom_header = '';

  /**
  *
  * @var string
  * @access  private
  */
  private $_eol = "\12";

  /**
  *
  * @var array
  * @access  private
  */
  private $_applied_rules = array();

  public function __construct(& $subject, $config)
  {
    parent::__construct($subject, $config);
    $this->loadLanguage();
  }

  /**
   *
   * Build and return the (called) prefix (e.g. http://www.youdomain.com) from the current server variables
   *
   * We say 'called' 'cause we use HTTP_HOST (taken from client header) and not SERVER_NAME (taken from server config)
   *
   */
  private static function getPrefix()
  {
    if (isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) != 'off')) {
      $https = 's://';
    } else {
      $https = '://';
    }
    return 'http' . $https . $_SERVER['HTTP_HOST'];
  }

  /**
   *
   * Build and return the (called) base path for site (e.g. http://www.youdomain.com/path/to/site)
   *
   * @param  boolean  If true returns only the path part (e.g. /path/to/site)
   *
   */
  private static function getBase($pathonly = false)
  {
    if (strpos(php_sapi_name(), 'cgi') !== false && !ini_get('cgi.fix_pathinfo') && !empty($_SERVER['REQUEST_URI'])) {
      // PHP-CGI on Apache with "cgi.fix_pathinfo = 0"

      // We use PHP_SELF
      if (!empty($_SERVER["PATH_INFO"])) {
        $p = strrpos($_SERVER["PHP_SELF"], $_SERVER["PATH_INFO"]);
        if ($p !== false) { $s = substr($_SERVER["PHP_SELF"], 0, $p); }
      } else {
        $p = $_SERVER["PHP_SELF"];
      }
      $base_path =  rtrim(dirname(str_replace(array('"', '<', '>', "'"), '', $p)), '/\\');
      // Check if base path was correctly detected, or use another method
      /*
         On some Apache servers (mainly using cgi-fcgi) it happens that the base path is not correctly detected.
         For URLs like http://www.site.com/index.php/content/view/123/5 the server returns a wrong PHP_SELF variable.

         WRONG:
         [REQUEST_URI] => /index.php/content/view/123/5
         [PHP_SELF] => /content/view/123/5

         CORRECT:
         [REQUEST_URI] => /index.php/content/view/123/5
         [PHP_SELF] => /index.php/content/view/123/5

         And this lead to a wrong result for JUri::base function.

         WRONG:
         JUri::base(true) => /content/view/123
         JUri::base(false) => http://www.site.com/content/view/123/

         CORRECT:
         getBase(true) =>
         getBase(false):http://www.site.com/
      */
      if (strlen($base_path) > 0) {
        if (strpos($_SERVER['REQUEST_URI'], $base_path) !== 0) {
          $base_path = trim(rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\'));
        }
      }
    } else {
      // We use SCRIPT_NAME
      $base_path = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    }

    return $pathonly === false ? self::getPrefix() . $base_path . '/' : $base_path;
  }

  /**
   *
   * Build and return the REQUEST_URI (e.g. /site/index.php?id=1&page=3)
   *
   */
  private static function getRequestURI($redirect_mode = 0)
  {
    if ( ($redirect_mode === 1) && ( (isset($_SERVER['REDIRECT_URL'])) || (isset($_SERVER['HTTP_X_REWRITE_URL'])) ) ) {
      $uri = (isset($_SERVER['HTTP_X_REWRITE_URL'])) ? $_SERVER['HTTP_X_REWRITE_URL'] : $_SERVER['REDIRECT_URL'];
    } else {
      $uri = $_SERVER['REQUEST_URI'];
    }
    return $uri;
  }

  /**
   *
   * Build and return the (called) {siteurl} macro value
   *
   */
  private static function getSiteURL()
  {
    $siteurl = str_replace( 'https://', '', self::getBase() );
    return rtrim(str_replace('http://', '', $siteurl), '/');
  }

  /**
   *
   * Build and return the (called) full URL (e.g. http://www.youdomain.com/site/index.php?id=12) from the current server variables
   *
   */
  private static function getURL($redirect_mode = 0)
  {
    return self::getPrefix() . self::getRequestURI($redirect_mode);
  }

  /**
   *
   * Return the host name from the given address
   *
   * Reference http://www.php.net/manual/en/function.parse-url.php#93983
   *
   */
  private static function getHost($address)
  {
    $parsedUrl = parse_url(trim($address));
    return @trim($parsedUrl['host'] ? $parsedUrl['host'] : array_shift(explode('/', $parsedUrl['path'], 2)));
  }

  /**
   *
   * Build list of keys in the form "key1|key2|...|keyN" for using into REGEXP
   *
   */
  private static function buildMatchKeywords($keywords)
  {
    // Current key should be cleaned escaping chars with preg_quote for REGEXP
    return implode("|", array_filter(array_map('preg_quote', array_map('trim', explode(",", $keywords)))));
  }

  /**
   *
   * Rebuild an URL from the parsed array
   *
   * @param  array   $parsed_url  Array of URL parts
   *
   * @return  string  The result URL
   *
   */
  private static function unparse_url($parsed_url)
  {
    $scheme   = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : '';
    $host     = isset($parsed_url['host']) ? $parsed_url['host'] : '';
    $port     = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : '';
    $user     = isset($parsed_url['user']) ? $parsed_url['user'] : '';
    $pass     = isset($parsed_url['pass']) ? ':' . $parsed_url['pass']  : '';
    $pass     = ($user || $pass) ? "$pass@" : '';
    $path     = isset($parsed_url['path']) ? $parsed_url['path'] : '';
    $query    = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';
    $fragment = isset($parsed_url['fragment']) ? '#' . $parsed_url['fragment'] : '';
    return "$scheme$user$pass$host$port$path$query$fragment";
  }

  /**
   *
   * Remove specified vars from URL query
   *
   * @param  string  $url   The URL
   * @param  array   $vars  List of variables to drop
   *
   * @return  string  The result URL
   *
   */
  private static function drop_query_vars($url, $vars)
  {
    $parsed = parse_url($url);
    if (isset($parsed['query']))
    {
      parse_str($parsed['query'], $query_vars);
      $query_vars = array_diff_key($query_vars, $vars);
      $parsed['query'] = http_build_query($query_vars, '', '&');
      if (strlen($parsed['query']) == 0) { unset($parsed['query']);}
      return self::unparse_url($parsed);
    }
    return $url;
  }

  /**
   *
   * Return the routed (relative) URL
   *
   * @param  string  $url   Visited full URL
   * @param  array   $vars  List of variables to use (if empty use all current variables)
   *
   * @return  string  The routed (relative) URL
   *
   */
  private static function route_url($url, $vars)
  {
    static $routed_urls = array();

    $checksum = @md5(json_encode($vars));
    if (isset($routed_urls[$url][$checksum]))
    {
      return $routed_urls[$url][$checksum];
    }

    JUri::reset();
    $uri_visited_full_url = JUri::getInstance($url);
    $router = JSite::getRouter();
    $parsed = $router->parse($uri_visited_full_url);
    $suffix = isset($parsed['format']) ? $parsed['format'] : '';
    $drop_vars = array();
    if (@count($vars)) // True if $vars is an array and with at least one element
    {
      // First drop unwanted vars
      foreach ($vars as $k => $v)
      {
        if (preg_match('/^!(.*)/', $k, $m) === 1)
        {
          $drop_vars[$m[1]] = $v;
          if (isset($parsed[$m[1]])) { unset($parsed[$m[1]]); }
          unset($vars[$k]);
        }
      }
      if (@count($vars)) // True if there is still at least one element
      {
        foreach ($vars as $k => $v)
        {
          if ($v === null)
          {
            if (isset($parsed[$k]))
            {
              $vars[$k] = $parsed[$k];
            } else {
              unset($vars[$k]);
            }
          }
        }
        $p = $vars;
      } else {
        $p = $parsed;
      }
    } else {
      // Variables to use/not use are not specified
      foreach ($parsed as $k => $v)
      {
        if ($v === null)
        {
          unset($parsed[$k]);
        }
      }
      $p = $parsed;
    }
    // Now $p contains the variable to use for routing
    if (isset($p['option']))
    {
      // For components search for a menu item
      $q = $p;
      unset($q['Itemid']);
      unset($q['format']);
      foreach ($q as $k => $v)
      {
        // Remove the slug part if present
        $parts = explode(":", $v);
        $q[$k] = $parts[0];
      }
      // Build the URL to route
      $link = 'index.php';
      foreach ($q as $k => $v)
      {
        $link .= (($link === 'index.php') ? '?' : '&') . $k . '=' . $v;
      }
      $routed_link = JRoute::_($link, false);
      $app = JFactory::getApplication();
      $menu = $app->getMenu();
      $items = $menu->getItems('component', $q['option']);
      $found = false;
      $menu_route = '';
      foreach ($items as $k => $v)
      {
        $current_link = (JRoute::_($v->link, false));
        if ($current_link == $routed_link)
        {
          $found = true;
          $menu_route = $v->route;
          break;
        }
      }
      if ($found)
      {
        $sef_prefix = ($app->getCfg('sef_rewrite')) ? '' : 'index.php/';
        $routed = '/' . $sef_prefix . trim($menu_route, '/') . ((strlen($suffix) > 0) ? '.' . $suffix : '');
        $routed_urls[$url][$checksum] = $routed;
        return $routed;
      }
    }
    // Build the URL to route
    $build = 'index.php';
    foreach ($p as $pk => $pv)
    {
      $build .= (($build === 'index.php') ? '?' : '&') . $pk . '=' . $pv;
    }
    $routed = self::drop_query_vars(JRoute::_($build, false), $drop_vars);
    $routed_urls[$url][$checksum] = $routed;
    return $routed;
  }

  /**
   *
   * Manage params for supported macros (e.g. used as callback function to replace macros with parameters)
   *
   * $macro[0] contains the complete match (when used with preg_replace_callback)
   * $macro[1] contains the 'action'
   * $macro[2] ... $macro[N] contain the additional params
   *
   */
  private static function manageMacroParams($macro)
  {
    static $siteurl = '';             // The (called) {siteurl} (e.g. www.youdomain.com/site) from the current server variables
    static $url = '';                 // The (called) full URL (e.g. http://www.youdomain.com/site/index.php?id=12) from the current server variables
    static $urlparts = array();       // Array of JUri parts for the (called) full URL
    static $urlvars = array();        // Array of all query variables (e.g. array([task] => view, [id] => 32) )
    static $urlpaths = array();       // Array of paths (e.g. array([baseonly] => /path/to/Joomla, [path] => /path/to/Joomla/section/cat/index.php, [pathfrombase] => /section/cat/index.php) )
    static $globalinfo = array();     // Array of global info
    static $placeholders = array();   // Array of evaluated placeholders
    static $documentinfo = array();   // Array of document info

    $macro = (array)$macro;
    if (!isset($macro[1])) return '';
    if (!isset($macro[2])) $macro[2] = '';

    $value = '';
    switch ($macro[1])
    {
      // set methods
      case 'setsiteurl':
        $siteurl = $macro[2];
        break;
      case 'seturl':
        $url = $macro[2];
        break;
      case 'seturlparts':
        $urlparts = $macro[2];
        break;
      case 'seturlvars':
        $urlvars = $macro[2];
        break;
      case 'seturlpaths':
        $urlpaths = $macro[2];
        break;
      case 'setglobalinfo':
        $globalinfo = $macro[2];
        break;
      case 'setplaceholder':
        // $macro[2] = placeholder name
        // $macro[3] = placeholder value
        if (isset($macro[2]))
        {
          if (isset($macro[3]))
          {
            $placeholders[$macro[2]] = $macro[3];
          } else {
            unset($placeholders[$macro[2]]);
          }
        }
        break;
      case 'setdocumentinfo':
        $documentinfo = $macro[2];
        break;
      // get methods
      case 'getsiteurl':
        $value = $siteurl;
        break;
      case 'geturl':
        $value = $url;
        break;
      case 'geturlparts':
        $value = $urlparts;
        break;
      case 'geturlvars':
        $value = $urlvars;
        break;
      case 'geturlpaths':
        $value = $urlpaths;
        break;
      case 'getglobalinfo':
        $value = $globalinfo;
        break;
      case 'getplaceholder':
        // $macro[2] = placeholder name
        if (isset($placeholders[$macro[2]])) $value = $placeholders[$macro[2]];
        break;
      case 'getdocumentinfo':
        $value = $documentinfo;
        break;
      // macro methods
      case 'querybuild':
      case 'querybuildfull':
      case 'querybuildappend':
        $build_vars = explode(',', $macro[2]);
        foreach ($build_vars as $k => $v)
        {
          $p = strpos($v, "=");
          if ($p === false)
          {
            // Only parameter name
            if (isset($urlvars[$v])) // Need to check only not-null values
            {
              $value .= (($value === '') ? '' : '&') . $v . '=' . $urlvars[$v];
            }
          } else {
            // New parameter or overrides existing
            $pn = substr($v, 0, $p);
            $pv = substr($v, $p + 1, strlen($v) - $p - 1);
            if ((strlen($pn) > 0) && (strlen($pv) > 0)) // Need to take only not-null names and values
            {
              $value .= (($value === '') ? '' : '&') . $pn . '=' . $pv;
            }
          }
        }
        if (strlen($value) > 0)
        {
          if ($macro[1] === 'querybuildfull') { $value = '?' . $value; }
          if ($macro[1] === 'querybuildappend') { $value = '&' . $value; }
        }
        break;
      case 'queryvar':
        // $macro[2] = variable name
        // $macro[3] = default value if variable is not set (optional)
        if (array_key_exists($macro[2], $urlvars)) {
          $value = $urlvars[$macro[2]];
        } else {
          if (isset($macro[3])) $value = $macro[3];
        }
        break;
      case 'requestvar':
        // $macro[2] = variable name
        // $macro[3] = default value if variable is not set (optional)
        if (isset($macro[3]))
        {
          $value = JFactory::getApplication()->input->get($macro[2], $macro[3], 'RAW');
        } else {
          $value = JFactory::getApplication()->input->get($macro[2], null, 'RAW');
        }
        break;
      case 'pathltrim':
        $value = $urlpaths['path'];
        if (strpos($value, $macro[2]) === 0)
        {
          $value = substr($value, strlen($macro[2]), strlen($value) - strlen($macro[2]));
        }
        break;
      case 'pathrtrim':
        $value = $urlpaths['path'];
        if (strpos($value, $macro[2]) === (strlen($value) - strlen($macro[2])))
        {
          $value = substr($value, 0, strlen($value) - strlen($macro[2]));
        }
        break;
      case 'routeurl':
        $vars = array();
        if (isset($macro[2]))
        {
          $build_vars = explode(',', $macro[2]);
          foreach ($build_vars as $k => $v)
          {
            $p = strpos($v, "=");
            if ($p === false)
            {
              // Only parameter name
              $vars[$v] = null;
            } else {
              // New parameter or overrides existing
              $pn = substr($v, 0, $p);
              $pv = substr($v, $p + 1, strlen($v) - $p - 1);
              if ((strlen($pn) > 0) && (strlen($pv) > 0)) // Need to take only not-null names and values
              {
                $vars[$pn] = $pv;
              }
            }
          }
        }
        $value = self::route_url($url, $vars);
        break;
      case 'username':
        $user = JFactory::getUser();
        $value = ($user->get('guest') == 1) ? $macro[2] : $user->get('username');
        break;
      case 'userid':
        $user = JFactory::getUser();
        $value = ($user->get('guest') == 1) ? $macro[2] : $user->get('id');
        break;
      case 'tableselect':
        // $macro[2] = table,column,key
        // $macro[3] = value
        // table: table name to query (support #__ notation)
        // column: field name to return
        // key: field name to use as selector in where condition
        // value: value to use for comparison in the where condition (WHERE key = value)
        $arg = explode(",", trim($macro[2]));
        if (count($arg) == 3)
        {
          $arg = array_map("trim", $arg);
          $value = $macro[3];
          if ($value != '')
          {
            // Perform a DB query
            $db = JFactory::getDBO();
            $db->setQuery("SELECT `" . $arg[1] . "` FROM `" . $arg[0] . "` WHERE `" . $arg[2] . "`=" . $db->quote($value));
            $result = $db->loadResult();
            if (isset($result)) { $value = $result; }
          }
        }
        break;
      case 'substr':
        // $macro[2] = start,length
        // $macro[3] = input string
        // start: start index for the portion string (0 based)
        // length: lenght of the portion string
        if (isset($macro[3]))
        {
          $value = $macro[3];
          $arg = array_map("trim", explode(",", $macro[2]));
          $cnt_arg = count($arg);
          if (($cnt_arg == 1) || ($cnt_arg == 2))
          {
            $value = ($cnt_arg == 1) ? substr($value, (int)$arg[0]) : substr($value, (int)$arg[0], (int)$arg[1]);
          }
        }
        break;
      case 'strip_tags':
        $value = strip_tags($macro[2]);
        break;
      case 'extract':
        $rows = preg_split("/[\r\n]+/iU" , $macro[3]);
        $index = (int)$macro[2] - 1;
        if (isset($rows[$index])) { $value = strip_tags($rows[$index]); }
        break;
      case 'extractp':
        preg_match_all("/<p>(.*)<\/p>/iU" , $macro[3], $rows);
        $index = (int)$macro[2] - 1;
        if (isset($rows[1][$index])) { $value = strip_tags($rows[1][$index]); }
        break;
      case 'extractdiv':
        preg_match_all("/<div>(.*)<\/div>/iU" , $macro[3], $rows);
        $index = (int)$macro[2] - 1;
        if (isset($rows[1][$index])) { $value = strip_tags($rows[1][$index]); }
        break;
      case 'preg_placeholder':
        // $macro[2] = N,placeholder
        // $macro[3] = pattern
        // N: regexp pattern to return
        // placeholder: placeholder name
        preg_match("/^([^\,]+)\,(.*)$/iU", trim($macro[2]), $arg);
        if (count($arg) == 3)
        {
          $arg[1] = (int)$arg[1]; // Default to 0 if not numeric
          $arg[2] = trim($arg[2]);
          if (isset($placeholders[$arg[2]]))
          {
            if (@preg_match($macro[3], $placeholders[$arg[2]], $matches) !== false)
            {
              if (array_key_exists($arg[1], $matches)) { $value = $matches[$arg[1]]; }
            }
          }
        }
        break;
      case 'lowercase':
        $value = strtolower($macro[2]);
        break;
      case 'uppercase':
        $value = strtoupper($macro[2]);
        break;
      case 'urldecode':
        $value = urldecode($macro[2]);
        break;
      case 'urlencode':
        $value = urlencode($macro[2]);
        break;
      case 'rawurldecode':
        $value = rawurldecode($macro[2]);
        break;
      case 'rawurlencode':
        $value = rawurlencode($macro[2]);
        break;
      case 'str_replace':
        // $macro[2] = 'search','replace'
        // $macro[3] = input string
        if (isset($macro[3]))
        {
          $value = $macro[3];
          $r = preg_match("/^'(.*)','(.*)'$/suU", $macro[2], $arg);
          if ($r == 1)
          {
            $value = str_replace($arg[1], $arg[2], $value);
          }
        }
        break;
    }
    return $value;
  }

  /**
   *
   * Replace supported macros from the content provided
   *
   */
  private static function replaceMacros($content)
  {
    /*
      http://fredbloggs:itsasecret@www.example.com:8080/path/to/Joomla/section/cat/index.php?task=view&id=32#anchorthis
      \__/   \________/ \________/ \_____________/ \__/\___________________________________/ \_____________/ \________/
       |          |         |              |        |                   |                           |             |
     scheme     user       pass          host      port                path                       query       fragment

    Supported URL macros:
       {siteurl}                                                    www.example.com/path/to/Joomla
       {scheme}                                                     http
       {host}                                                       www.example.com
       {port}                                                       8080
       {user}                                                       fredbloggs
       {pass}                                                       itsasecret
       {path}                                                       /path/to/Joomla/section/cat/index.php
       {query}                                                      task=view&id=32
       {queryfull}                                                  ?task=view&id=32
       {queryappend}                                                &task=view&id=32
       {querybuild id,task}                                         id=32&task=view
       {querybuild id,task=edit}                                    id=32&task=edit
       {querybuild id,task=view,ItemId=12}                          id=32&task=view&ItemId=12
       {querybuildfull id,task}                                     ?id=32&task=view
       {querybuildfull id,task=save}                                ?id=32&task=save
       {querybuildfull id,task,action=close}                        ?id=32&task=view&action=close
       {querybuildappend id,task}                                   &id=32&task=view
       {querybuildappend id,task=save}                              &id=32&task=save
       {querybuildappend id,task,action=close}                      &id=32&task=view&action=close
       {querydrop task}                                             id=32
       {querydrop id,task=edit}                                     task=edit
       {querydrop id,task=save,action=close}                        task=save&action=close
       {querydropfull task}                                         ?id=32
       {querydropfull id,task=save}                                 ?task=save
       {querydropfull id,task=edit,action=close}                    ?task=edit&action=close
       {querydropappend task}                                       &id=32
       {querydropappend id,task=save}                               &task=save
       {querydropappend id,task=edit,action=close}                  &task=edit&action=close
       {queryvar varname,default}                                   Returns the current value for the variable 'varname' of the URL, or the value 'default' if 'varname' is not defined (where default = '' when not specified)
       {queryvar task}                                              view
       {queryvar id}                                                32
       {queryvar maxsize,234}                                       234
       {requestvar varname,default}                                 Returns the current value for the variable 'varname' of the request, no matter about method (GET, POST, ...), or the value 'default' if 'varname' is not defined (where default = '' when not specified)
       {requestvar id}                                              32
       {requestvar limit,100}                                       100
       {authority}                                                  fredbloggs:itsasecret@www.example.com:8080
       {baseonly}                                                   /path/to/Joomla (empty when installed on root, i.e. it will never contains a trailing slash)
       {pathfrombase}                                               /section/cat/index.php
       {pathltrim /path/to}                                         /Joomla/section/cat/index.php
       {pathrtrim /index.php}                                       /path/to/Joomla/section/cat
       {pathfrombaseltrim /section}                                 /cat/index.php
       {pathfrombasertrim index.php}                                /section/cat/
       {preg_match N}pattern{/preg_match}                           (return the N-th matched pattern on the full source url, where N = 0 when not specified)
       {preg_match}/([^\/]+)(\.php|\.html|\.htm)/i{/preg_match}     index.php
       {preg_match 2}/([^\/]+)(\.php|\.html|\.htm)/i{/preg_match}   .php
       {preg_select table,column,key,N}pattern{/preg_select}        (uses the N-th matched result to execute a SQL query (SELECT column FROM table WHERE key = matchN). Support #__ notation for table name)
       {routeurl}                                                   Returns the routed (relative) URL using all current variables
       {routeurl var1,var2,var3=myvalue,..,varN}                    Returns the routed (relative) URL for specified variables (index.php?var1=value1&var2=value2&var3=myvalue&..&varN=valueN)
       {pathfolder N}                                               Returns the N-th folder of the URL path (e.g. with /path/to/Joomla/section/cat/index.php N=4 returns section)
       {pathfolder last-N}                                          Returns the (last-N)-th folder of the URL path, where N = 0 when not specified (e.g. with /path/to/Joomla/section/cat/index.php last-1 returns cat)
    */

    static $patterns;
    static $replacements;
    static $patterns_callback;

    if (!isset($patterns)) {
      // Supported static macros patterns
      $patterns = array();
      // URL macros
      $patterns[0] = "/\{siteurl\}/";
      $patterns[1] = "/\{scheme\}/";
      $patterns[2] = "/\{host\}/";
      $patterns[3] = "/\{port\}/";
      $patterns[4] = "/\{user\}/";
      $patterns[5] = "/\{pass\}/";
      $patterns[6] = "/\{path\}/";
      $patterns[7] = "/\{query\}/";
      $patterns[8] = "/\{queryfull\}/";
      $patterns[9] = "/\{queryappend\}/";
      $patterns[10] = "/\{authority\}/";
      $patterns[11] = "/\{baseonly\}/";
      $patterns[12] = "/\{pathfrombase\}/";
      // Site macros
      $patterns[13] = "/\{sitename\}/";
      $patterns[14] = "/\{globaldescription\}/";
      $patterns[15] = "/\{globalkeywords\}/";
      $patterns[16] = "/\{currenttitle\}/";
      $patterns[17] = "/\{currentdescription\}/";
      $patterns[18] = "/\{currentkeywords\}/";
      $patterns[19] = "/\{currentauthor\}/";
      $patterns[20] = "/\{currentgenerator\}/";
    }

    if (!isset($replacements))
    {
      // Get data needed for macros replacements
      $visited_siteurl = self::manageMacroParams(array(1 => 'getsiteurl'));
      $uri_visited_full_url_parts = self::manageMacroParams(array(1 => 'geturlparts'));
      $uri_visited_full_url_paths = self::manageMacroParams(array(1 => 'geturlpaths'));
      $global_info = self::manageMacroParams(array(1 => 'getglobalinfo'));
      $document_info = self::manageMacroParams(array(1 => 'getdocumentinfo'));

      // Supported static macros replacements
      $replacements = array();
      // URL macros
      $replacements[0] = $visited_siteurl;
      $replacements[1] = $uri_visited_full_url_parts['scheme'];
      $replacements[2] = $uri_visited_full_url_parts['host'];
      $replacements[3] = $uri_visited_full_url_parts['port'];
      $replacements[4] = $uri_visited_full_url_parts['user'];
      $replacements[5] = $uri_visited_full_url_parts['pass'];
      $replacements[6] = $uri_visited_full_url_parts['path'];
      $replacements[7] = $uri_visited_full_url_parts['query'];
      $replacements[8] = (strlen($uri_visited_full_url_parts['query']) > 0) ? '?' . $uri_visited_full_url_parts['query'] : '';
      $replacements[9] = (strlen($uri_visited_full_url_parts['query']) > 0) ? '&' . $uri_visited_full_url_parts['query'] : '';
      $replacements[10] = $uri_visited_full_url_parts['authority'];
      $replacements[11] = $uri_visited_full_url_paths['baseonly'];
      $replacements[12] = $uri_visited_full_url_paths['pathfrombase'];
      // Site macros
      $replacements[13] = $global_info['sitename'];
      $replacements[14] = $global_info['MetaDesc'];
      $replacements[15] = $global_info['MetaKeys'];
      $replacements[16] = $document_info['title'];
      $replacements[17] = $document_info['description'];
      $replacements[18] = $document_info['keywords'];
      $replacements[19] = $document_info['author'];
      $replacements[20] = $document_info['generator'];
    }

    if (!isset($patterns_callback))
    {
      // Supported dynamic macros patterns
      $patterns_callback = array();
      // URL macros
      $patterns_callback[0] = "/\{(querybuild) ([^\}]+)\}/suU";
      $patterns_callback[1] = "/\{(querybuildfull) ([^\}]+)\}/suU";
      $patterns_callback[2] = "/\{(querybuildappend) ([^\}]+)\}/suU";
      $patterns_callback[6] = "/\{(queryvar) ([^\}\,]+)\}/suU";
      $patterns_callback[7] = "/\{(queryvar) ([^\}]+),([^\}]+)\}/suU";
      $patterns_callback[8] = "/\{(requestvar) ([^\}\,]+),?\}/suU";
      $patterns_callback[9] = "/\{(requestvar) ([^\}]+),([^\}]+)\}/suU";
      $patterns_callback[10] = "/\{(pathltrim) ([^\}]+)\}/suU";
      $patterns_callback[11] = "/\{(pathrtrim) ([^\}]+)\}/suU";
      $patterns_callback[16] = "/\{(routeurl)\}/";
      $patterns_callback[17] = "/\{(routeurl) ([^\}]+)\}/suU";
      // Site macros
      $patterns_callback[19] = "/\{(username)\}/";
      $patterns_callback[20] = "/\{(username) ([^\}]+)\}/suU";
      $patterns_callback[21] = "/\{(userid)\}/";
      $patterns_callback[22] = "/\{(userid) ([^\}]+)\}/suU";
      // Database macros
      $patterns_callback[23] = "/\{(tableselect) ([^\}]+)\}(.*)\{\/tableselect\}/suU";
      // String macros
      $patterns_callback[26] = "/\{(substr) ([^\}]+)\}(.*)\{\/substr\}/suU";
      $patterns_callback[27] = "/\{(strip_tags)\}(.*)\{\/strip_tags\}/suU";
      $patterns_callback[28] = "/\{(extract) ([^\}]+)\}(.*)\{\/extract\}/suU";
      $patterns_callback[29] = "/\{(extractp) ([^\}]+)\}(.*)\{\/extractp\}/suU";
      $patterns_callback[30] = "/\{(extractdiv) ([^\}]+)\}(.*)\{\/extractdiv\}/suU";
      $patterns_callback[33] = "/\{(lowercase)\}(.*)\{\/lowercase\}/suU";
      $patterns_callback[34] = "/\{(uppercase)\}(.*)\{\/uppercase\}/suU";
      $patterns_callback[35] = "/\{(urldecode)\}(.*)\{\/urldecode\}/suU";
      $patterns_callback[36] = "/\{(urlencode)\}(.*)\{\/urlencode\}/suU";
      $patterns_callback[37] = "/\{(rawurldecode)\}(.*)\{\/rawurldecode\}/suU";
      $patterns_callback[38] = "/\{(rawurlencode)\}(.*)\{\/rawurlencode\}/suU";
      $patterns_callback[39] = "/\{(str_replace) ([^\}]+)\}(.*)\{\/str_replace\}/suU";
      // Content macros
    }

    $content = preg_replace($patterns, $replacements, $content);
    $content = preg_replace_callback($patterns_callback, 'plgSystemTagMeta::manageMacroParams', $content);
    return $content;
  }

  /**
   *
   * Evaluate and return placeholders defined in the list
   *
   */
  private static function evaluatePlaceholders($list)
  {
    $placeholders = array();
    $placeholders_count = 0;
    $rows = preg_split("/[\r\n]+/", $list);
    foreach ($rows as $row_key => $row_value)
    {
      $row_value = trim($row_value);
      if (strlen($row_value) > 0)
      {
        $parts = array_map('trim', explode("=", $row_value, 2));
        $parts_key = @$parts[0];
        /* Placeholder names follow the same rules as other labels and variables in PHP. A valid placeholder name starts with a letter or underscore, followed by any number of letters, numbers, or underscores. As a regular expression, it would be expressed thus: '[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*' */
        if ((strlen($parts_key) > 0) && (preg_match(PLACEHOLDERS_MATCH_MASK, $parts_key) === 1))
        {
            $parts_value = @$parts[1];
            if (strlen($parts_value) > 0)
            {
                $placeholders[$parts_key] = $parts_value;
                // Replace already defined placeholders in the new placeholder
                preg_match_all(PLACEHOLDERS_MATCH_ALL_MASK, $placeholders[$parts_key], $matches);
                foreach ($matches[1] as $current)
                {
                  if (array_key_exists($current, $placeholders))
                  {
                    $placeholders[$parts_key] = str_replace('${' . $current . '}', $placeholders[$current], $placeholders[$parts_key]);
                  }
                }

                // Replace macros
                $placeholders[$parts_key] = self::replaceMacros($placeholders[$parts_key]);

                // Load placeholder
                $ph = array(1 => 'setplaceholder', 2 => $parts_key, 3 => $placeholders[$parts_key]);
                self::manageMacroParams($ph);

                $placeholders_count++;
            } else {
                // Unset placeholder
                unset($placeholders[$parts_key]);

                // Unload placeholder
                $ph = array(1 => 'setplaceholder', 2 => $parts_key);
                self::manageMacroParams($ph);
            }
        }
      }
    }
    return $placeholders;
  }

  /**
   *
   * Replace and return defined array of placeholders from the input string
   *
   */
  private static function replacePlaceholders($placeholders, $string)
  {
    $value = $string;
    preg_match_all(PLACEHOLDERS_MATCH_ALL_MASK, $value, $matches);
    foreach ($matches[1] as $current)
    {
      if (array_key_exists($current, $placeholders))
      {
        $value = str_replace('${' . $current . '}', $placeholders[$current], $value);
      }
    }
    return $value;
  }

  public function onAfterDispatch()
  {
    $document = JFactory::getDocument();
    $docType = $document->getType();
    $this->_eol = $document->_getLineEnd();

    // Get the application object
    $app = JFactory::getApplication();

    // Make sure we are not in the administrator
    if ( $app->isAdmin() ) return;

    // Only site pages that are html docs
    if ( JFactory::getDocument()->getType() !== 'html' ) return;

    // Set sitename
    $sitename = $app->getCfg('sitename');

    $currenturi_encoded = self::getRequestURI( $this->params->get('redirect', 0) ); // Raw (encoded): with %## chars
    // Remove the base path
    $basepath = trim($this->params->def('basepath', ''), ' /'); // Decoded: without %## chars (now you can see spaces, cyrillics, ...)
    $basepath = urlencode($basepath); // Raw (encoded): with %## chars
    $basepath = str_replace('%2F', '/', $basepath);
    $basepath = str_replace('%3A', ':', $basepath);
    if ($basepath != '')
    {
      if (strpos($currenturi_encoded, '/'.$basepath.'/') === 0)
      {
        $currenturi_encoded = substr($currenturi_encoded, strlen($basepath) + 1); // Raw (encoded): with %## chars
      }
    }
    $currenturi = urldecode($currenturi_encoded); // Decoded: without %## chars (now you can see spaces, cyrillics, ...)
    $currentfullurl_encoded = self::getPrefix() . $currenturi_encoded; // Raw (encoded): with %## chars
    $currentfullurl = urldecode($currentfullurl_encoded); // Decoded: without %## chars (now you can see spaces, cyrillics, ...)

    $preserve_title = false;

    $db = JFactory::getDBO();
    $db->setQuery('SELECT * FROM #__tagmeta_rules '
    . 'WHERE ( '
    . '( (' . $db->quote($currenturi) . ' REGEXP BINARY url)>0 AND (case_sensitive<>0) AND (decode_url<>0) AND (request_only<>0) ) '
    . 'OR ( (' . $db->quote($currenturi_encoded) . ' REGEXP BINARY url)>0 AND (case_sensitive<>0) AND (decode_url=0) AND (request_only<>0) ) '
    . 'OR ( (' . $db->quote($currentfullurl) . ' REGEXP BINARY url)>0 AND (case_sensitive<>0) AND (decode_url<>0) AND (request_only=0) ) '
    . 'OR ( (' . $db->quote($currentfullurl_encoded) . ' REGEXP BINARY url)>0 AND (case_sensitive<>0) AND (decode_url=0) AND (request_only=0) ) '
    . 'OR ( (' . $db->quote($currenturi) . ' REGEXP url)>0 AND (case_sensitive=0) AND (decode_url<>0) AND (request_only<>0) ) '
    . 'OR ( (' . $db->quote($currenturi_encoded) . ' REGEXP url)>0 AND (case_sensitive=0) AND (decode_url=0) AND (request_only<>0) ) '
    . 'OR ( (' . $db->quote($currentfullurl) . ' REGEXP url)>0 AND (case_sensitive=0) AND (decode_url<>0) AND (request_only=0) ) '
    . 'OR ( (' . $db->quote($currentfullurl_encoded) . ' REGEXP url)>0 AND (case_sensitive=0) AND (decode_url=0) AND (request_only=0) ) '
    . ') '
    . 'AND published=1 '
    . 'ORDER BY ordering');
    $items = $db->loadObjectList();
    $itemsfound = count($items);
    if ($itemsfound > 0)
    {
        // Initialize URL related variables
        $visited_siteurl = self::getSiteURL();

        $visited_full_url = self::getURL();

        JUri::reset();
        $uri_visited_full_url = JUri::getInstance($visited_full_url);
        $uri_visited_full_url_parts['scheme'] = $uri_visited_full_url->getScheme();
        $uri_visited_full_url_parts['host'] = $uri_visited_full_url->getHost();
        $uri_visited_full_url_parts['port'] = $uri_visited_full_url->getPort();
        $uri_visited_full_url_parts['user'] = $uri_visited_full_url->getUser();
        $uri_visited_full_url_parts['pass'] = $uri_visited_full_url->getPass();
        $uri_visited_full_url_parts['path'] = $uri_visited_full_url->getPath();
        $uri_visited_full_url_parts['query'] = $uri_visited_full_url->getQuery();
        $uri_visited_full_url_parts['authority'] = (isset($uri_visited_full_url_parts['port'])) ? $uri_visited_full_url_parts['host'] . ':' . $uri_visited_full_url_parts['port'] : $uri_visited_full_url_parts['host'];
        $uri_visited_full_url_parts['authority'] = (isset($uri_visited_full_url_parts['user'])) ? $uri_visited_full_url_parts['user'] . ':' . $uri_visited_full_url_parts['pass'] . '@' . $uri_visited_full_url_parts['authority'] : $uri_visited_full_url_parts['authority'];

        $uri_visited_full_url_vars = $uri_visited_full_url->getQuery(true);

        $baseonly = self::getBase(true);
        $pathfrombase = (strlen($baseonly) > 0) ? substr($uri_visited_full_url_parts['path'], strlen($baseonly), strlen($uri_visited_full_url_parts['path']) - strlen($baseonly)) : $uri_visited_full_url_parts['path'];
        $uri_visited_full_url_paths['baseonly'] = $baseonly;
        $uri_visited_full_url_paths['path'] = $uri_visited_full_url_parts['path'];
        $uri_visited_full_url_paths['pathfrombase'] = $pathfrombase;

        // Set URL related variables in callback function
        self::manageMacroParams(array(1 => 'setsiteurl', 2 => $visited_siteurl));
        self::manageMacroParams(array(1 => 'seturl', 2 => $visited_full_url));
        self::manageMacroParams(array(1 => 'seturlparts', 2 => $uri_visited_full_url_parts));
        self::manageMacroParams(array(1 => 'seturlvars', 2 => $uri_visited_full_url_vars));
        self::manageMacroParams(array(1 => 'seturlpaths', 2 => $uri_visited_full_url_paths));

        // Set global info in callback function
        $global_info['sitename'] = $app->getCfg('sitename');
        $global_info['MetaDesc'] = $app->getCfg('MetaDesc');
        $global_info['MetaKeys'] = $app->getCfg('MetaKeys');
        self::manageMacroParams(array(1 => 'setglobalinfo', 2 => $global_info));

        // Set document info in callback function
        $document_info['title'] = $document->getTitle();
        $document_info['description'] = $document->getDescription();
        $document_info['keywords'] = $document->getMetaData('keywords');
        $document_info['author'] = $document->getMetaData('author');
        $document_info['generator'] = $document->getGenerator();
        self::manageMacroParams(array(1 => 'setdocumentinfo', 2 => $document_info));

        $currentitem = 0;
        $continue = true;
        while ($continue)
        {
            // Trace applied rule
            $this->_applied_rules[] = $items[$currentitem]->id;

            // Update hits
            $last_visit = date("Y-m-d H:i:s");
            $db->setQuery("UPDATE #__tagmeta_rules SET hits = hits + 1, last_visit = " . $db->quote( $last_visit ) . " WHERE id = " . $db->quote( $items[$currentitem]->id ));
            $res = @$db->query();

            // Evaluate placeholders
            $placeholders = self::evaluatePlaceholders($items[$currentitem]->placeholders);

            // Replace placeholders
            $items[$currentitem]->title = self::replacePlaceholders($placeholders, $items[$currentitem]->title);
            $items[$currentitem]->description = self::replacePlaceholders($placeholders, $items[$currentitem]->description);
            $items[$currentitem]->author = self::replacePlaceholders($placeholders, $items[$currentitem]->author);
            $items[$currentitem]->keywords = self::replacePlaceholders($placeholders, $items[$currentitem]->keywords);
            $items[$currentitem]->rights = self::replacePlaceholders($placeholders, $items[$currentitem]->rights);
            $items[$currentitem]->xreference = self::replacePlaceholders($placeholders, $items[$currentitem]->xreference);
            $items[$currentitem]->canonical = self::replacePlaceholders($placeholders, $items[$currentitem]->canonical);
            $items[$currentitem]->custom_header = self::replacePlaceholders($placeholders, $items[$currentitem]->custom_header);

            // Replace macros
            $items[$currentitem]->title = self::replaceMacros($items[$currentitem]->title);
            $items[$currentitem]->description = self::replaceMacros($items[$currentitem]->description);
            $items[$currentitem]->author = self::replaceMacros($items[$currentitem]->author);
            $items[$currentitem]->keywords = self::replaceMacros($items[$currentitem]->keywords);
            $items[$currentitem]->rights = self::replaceMacros($items[$currentitem]->rights);
            $items[$currentitem]->xreference = self::replaceMacros($items[$currentitem]->xreference);
            $items[$currentitem]->canonical = self::replaceMacros($items[$currentitem]->canonical);
            $items[$currentitem]->custom_header = self::replaceMacros($items[$currentitem]->custom_header);

            // Check for synonyms
            if (($items[$currentitem]->synonyms != 0) && ($items[$currentitem]->synonmax > 0)) {
              $binarymatch = ($items[$currentitem]->synonyms == 1) ? '' : 'BINARY'; // Add "BINARY" to "REGEXP" for case sensitive match
              $orderingmatch = ($items[$currentitem]->synonweight) ? 'weight DESC' : 'ordering ASC';
              $keywordsmatch = $this->buildMatchKeywords($items[$currentitem]->keywords);

              $db->setQuery("SELECT * FROM #__tagmeta_synonyms WHERE keywords REGEXP " . $binarymatch . " '(" . $keywordsmatch . ")' and published='1' ORDER BY " . $orderingmatch);
              $synonymsitems = $db->loadObjectList();
              if ( count($synonymsitems) > 0 ) {
                $keywords_list = $items[$currentitem]->keywords;
                if ($items[$currentitem]->synonyms == 1) { $keywords_list = JString::strtolower($keywords_list); }
                $keywords_array = array_count_values(explode(",", $keywords_list)); // Not case sensitive: all to lowercase
                $keywordsmatch = '';
                $addedmatch = 0;
                $usedidmatch = array();
                foreach ($synonymsitems as $synonymskey => $synonymsvalue) {
                  if ($items[$currentitem]->synonyms == 1) { $synonymsvalue->synonyms = JString::strtolower($synonymsvalue->synonyms); } // Not case sensitive: all to lowercase
                  $current_synonyms_list = array_count_values(array_map('trim', explode(",", $synonymsvalue->synonyms)));
                  foreach ($current_synonyms_list  as $current_synonyms_key => $current_synonyms_value) {
                    if ( ($current_synonyms_key != '') && (!isset($keywords_array[$current_synonyms_key])) ) {
                      // Add current keyword
                      $keywordsmatch .= $current_synonyms_key . ",";
                      $keywords_array[$current_synonyms_key] = isset($keywords_array[$current_synonyms_key]) ? $keywords_array[$current_synonyms_key] + 1 : 1;
                      $addedmatch++;
                      $usedidmatch[$synonymsvalue->id] = isset($usedidmatch[$synonymsvalue->id]) ? $usedidmatch[$synonymsvalue->id] + 1 : 1;
                      if ($addedmatch >= $items[$currentitem]->synonmax) { break; }
                    }
                  }
                  if ($addedmatch >= $items[$currentitem]->synonmax) { break; }
                }
                $keywordsmatch = rtrim($keywordsmatch, ','); // Drop last char if is a comma
                // Update keywords list
                $items[$currentitem]->keywords .= "," . $keywordsmatch;
                $items[$currentitem]->keywords = ltrim($items[$currentitem]->keywords, ','); // Drop first char if is a comma
                // Update hits on used synonyms items
                if ($addedmatch > 0) {
                  $usedidlist = '';
                  foreach ($usedidmatch as $usedidkey => $usedidvalue) {
                    $usedidlist .= $usedidkey . ",";
                  }
                  $usedidlist = rtrim($usedidlist, ','); // Drop last char if is a comma
                  $db->setQuery("UPDATE #__tagmeta_synonyms SET hits = hits + 1, last_visit = " . $db->quote( $last_visit ) . " WHERE id IN (" . $usedidlist . ")");
                  $res = @$db->query();
                }
              }
            }

            if ( !empty($items[$currentitem]->title) ) { $document->setTitle($items[$currentitem]->title); }
            if ( !empty($items[$currentitem]->description) ) { $document->setDescription(str_replace('"', '&quot;', $items[$currentitem]->description)); }
            if ( !empty($items[$currentitem]->author) ) { $document->setMetaData('author', $items[$currentitem]->author); }
            if ( !empty($items[$currentitem]->keywords) ) { $document->setMetaData('keywords', str_replace('"', '&quot;', $items[$currentitem]->keywords)); }
            if ( !empty($items[$currentitem]->rights) ) { $document->setMetaData('rights', str_replace('"', '&quot;', $items[$currentitem]->rights)); }
            if ( !empty($items[$currentitem]->xreference) ) { $document->setMetaData('xreference', str_replace('"', '&quot;', $items[$currentitem]->xreference)); }
            if ( !empty($items[$currentitem]->canonical) ) { $document->addHeadLink($items[$currentitem]->canonical, 'canonical', 'rel'); }
            if ( !empty($items[$currentitem]->custom_header) ) { $this->_custom_header = $items[$currentitem]->custom_header; }

            // Robots meta options: 0=No,1=Yes,2=Skip
            $robots = '';
            if ($items[$currentitem]->rindex != 2) { $robots .= ($items[$currentitem]->rindex) ? 'index,' : 'noindex,'; }
            if ($items[$currentitem]->rfollow != 2) { $robots .= ($items[$currentitem]->rfollow) ? 'follow,' : 'nofollow,'; }
            if ($items[$currentitem]->rsnippet != 2) { $robots .= ($items[$currentitem]->rsnippet) ? 'snippet,' : 'nosnippet,'; }
            if ($items[$currentitem]->rarchive != 2) { $robots .= ($items[$currentitem]->rarchive) ? 'archive,' : 'noarchive,'; }
            if ($items[$currentitem]->rodp != 2) { $robots .= ($items[$currentitem]->rodp) ? 'odp,' : 'noodp,'; }
            if ($items[$currentitem]->rydir != 2) { $robots .= ($items[$currentitem]->rydir) ? 'ydir,' : 'noydir,'; }
            if ($items[$currentitem]->rimageindex != 2) { $robots .= ($items[$currentitem]->rimageindex) ? 'imageindex,' : 'noimageindex,'; }
            $robots = rtrim($robots, ','); // Drop last char if is a comma
            if ( !empty($robots) ) { $document->setMetaData('robots', $robots); }

            $preserve_title = $items[$currentitem]->preserve_title;
            $last_rule = ($items[$currentitem]->last_rule);
            $currentitem++;
            $continue = ( (!$last_rule) && ($currentitem < $itemsfound) );
        }
    }

    $replacegenerator = $this->params->get('replacegenerator', 0);
    if ($replacegenerator != 0) {
      if ($replacegenerator == 3) {
        if ($document->getMetaData('generator')) {
          $document->setGenerator('');
          $this->_clean_generator = true; // Clean if exists
        }
      } else {
        $customgenerator = $this->params->get('customgenerator', '');
        if ( (($document->getMetaData('generator')) && ($replacegenerator == 1)) || ($replacegenerator == 2) ) {
          $document->setGenerator(str_replace('"', '&quot;', $customgenerator)); // Replace existing or force
        }
      }
    }

    $addsitename = $this->params->get('addsitename', 0);
    if (($addsitename != 0) && (!$preserve_title)) {
      // Add site name before or after the page title
      $separator = str_replace( '\b', ' ', $this->params->get('separator', '\b-\b') );
      $currenttitle = $document->getTitle();
      if ( $addsitename == 1 ) {
        $newtitle = $sitename . $separator . $currenttitle; // Before
      } else {
        $newtitle = $currenttitle . $separator . $sitename; // After
      }
      $document->setTitle( htmlspecialchars_decode($newtitle) );
    }

    if ( $this->params->get('cleandefaultpage') == 1 ) {
      // Check if this is the default page (home page)
      $menu = JFactory::getApplication()->getMenu();
      if ( $menu->getActive() == $menu->getDefault() ) {
        $document->setTitle($sitename);
      }
    }

    $metatitle = $this->params->get('metatitle', 1);
    if ( $metatitle ) {
          $tagvalue = $document->getTitle();
          if ( empty($tagvalue) ) {
                // Tag title is empty
                $metavalue = $document->getMetaData('title');
                if ( ( !empty($metavalue) ) && ($metatitle == 2) ) {
                  $document->setTitle($metavalue);
                }
          } else {
                // Tag title is not empty
                $metavalue = $document->getMetaData('title');
                if ( ( !empty($metavalue) ) || ($metatitle == 2) ) {
                  $document->setMetaData('title', str_replace('"', '&quot;', $tagvalue));
                }
          }
    }

    $customauthor = $this->params->get('customauthor', '');
    $addauthor = $this->params->get('addauthor', 0);
    if ( ( $customauthor ) && ($addauthor != 0) ) {
          $currentauthor = $document->getMetaData('author');
          if ( ($addauthor == 1) || ( empty($currentauthor) ) ) {
                $document->setMetaData('author', str_replace('"', '&quot;', $customauthor));
          }
    }

    $customcopyright = $this->params->get('customcopyright', '');
    $addcopyright = $this->params->get('addcopyright', 0);
    if ( ( $customcopyright ) && ($addcopyright != 0) ) {
          $currentcopyright = $document->getMetaData('copyright');
          if ( ($addcopyright == 1) || ( empty($currentcopyright) ) ) {
                $document->setMetaData('copyright', str_replace('"', '&quot;', $customcopyright));
          }
    }

  }

  public function onAfterRender()
  {
    // Get the application object
    $app = JFactory::getApplication();

    // Make sure we are not in the administrator
    if ( $app->isAdmin() ) return;

    // Only site pages that are html docs
    if ( JFactory::getDocument()->getType() !== 'html' ) return;

    $content = JResponse::getBody();
    $changed = false;

    // Clean meta tag generator
    if ($this->_clean_generator) {
      $content = preg_replace('/<meta.*name=[\",\']generator[\",\'].*\/?>/i', '', $content);
      $changed = true;
    }

    // Add custom header
    if (!empty($this->_custom_header)) {
      $content = preg_replace('/<\/head>/i', $this->_custom_header . $this->_eol . '</head>', $content);
      $changed = true;
    }

    // Add trace information
    $addtrace = $this->params->get('addtrace', 1);
    if ( $addtrace ) {
      $trace = '<script type="text/javascript">';
      // Trace parsed URL
      JUri::reset();
      $uri_url = JUri::getInstance();
      $router = $app->getRouter();
      $parsed = $router->parse($uri_url);
      $trace .= "console.log('Parsed URL: " . json_encode($parsed) . "');";
      // Trace applied rules
      $trace .= "console.log('Applied rules: " . implode($this->_applied_rules) . "');";
      $trace .= '</script>';
      $content = preg_replace('/<\/body>/i', $trace . $this->_eol . '</body>', $content);
      $changed = true;
    }

    if ($changed) { JResponse::setBody($content); }
  }

}
