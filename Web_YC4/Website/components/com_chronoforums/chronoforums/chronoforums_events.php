<?php
/**
* ChronoCMS version 1.0
* Copyright (c) 2012 ChronoCMS.com, All rights reserved.
* Author: (ChronoCMS.com Team)
* license: Please read LICENSE.txt
* Visit http://www.ChronoCMS.com for regular updates and information.
**/
namespace GCore\Extensions\Chronoforums;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class ChronoforumsEvents {
	static $fparams;
	
	public static function on_before_dispatch(&$app){
		if(!empty($_POST['Extension']['chronoforums']['settings'])){
			self::$fparams = $chronoforums_params = new \GCore\Libs\Parameter($_POST['Extension']['chronoforums']['settings']);
			if($chronoforums_params->get('board_display', 'default') == 'discussions' AND $app->extension == 'chronoforums' AND $app->controller == '' AND ($app->action == '' OR $app->action == 'index')){
				$app->controller = 'forums';
				$app->action = '';
			}
		}
	}
	
	public static function on_set_page_title($title = ''){
		if(!empty($title)){
			if(\GCore\C::get('GSITE_PLATFORM') == 'joomla'){
				$doc = \JFactory::getDocument();
				$doc->setTitle($title);
			}else{
				$doc = \GCore\Libs\Document::getInstance();
				$doc->setTitle($title);
			}
		}
	}
	
	public static function on_set_meta_info($text = ''){
		if(!empty($text)){
			if(\GCore\C::get('GSITE_PLATFORM') == 'joomla'){
				$doc = \JFactory::getDocument();
				$doc->setDescription($text);
			}else{
				$doc = \GCore\Libs\Document::getInstance();
				//$doc->setTitle($text);
			}
		}
	}
	
	public static function on_permissions_error($url = ''){
		if(!empty($url) AND self::$fparams->get('auto_login_redirect', 0)){
			$redirect = r_('index.php?option=com_users&view=login');
			$redirect .= '&return='.urlencode(base64_encode($url));
			\GCore\Libs\Env::redirect($redirect);
		}
	}
}
?>