<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php

/**
 * Class N2AssetsManager
 *
 */
class N2AssetsManager
{

    /**
     * @var N2AssetsCss
     */
    public static $css;

    private static $cssStack = array();

    /**
     * @var N2AssetsLess
     */
    public static $less;

    private static $lessStack = array();

    /**
     * @var N2AssetsJs
     */
    public static $js;

    private static $jsStack = array();

    /**
     * @var N2AssetsGoogleFonts
     */
    public static $googleFonts;

    private static $googleFontsStack = array();

    public static $cacheAll = true;

    public static $cachedGroups = array();

    public static function getInstance() {
        static $instance = null;
        if (null === $instance) {
            $instance = new N2AssetsManager();
            self::createStack();
        }

        return $instance;
    }

    public static function createStack() {

        self::$css = new N2AssetsCss();
        array_unshift(self::$cssStack, self::$css);

        self::$less = new N2AssetsLess();
        array_unshift(self::$lessStack, self::$less);

        self::$js = new N2AssetsJs();
        array_unshift(self::$jsStack, self::$js);

        self::$googleFonts = new N2AssetsGoogleFonts();
        array_unshift(self::$googleFontsStack, self::$googleFonts);
    }

    public static function removeStack() {
        if (count(self::$cssStack) > 0) {
            /**
             * @var $previousCSS          N2AssetsCss
             * @var $previousLESS         N2AssetsLess
             * @var $previousJS           N2AssetsJs
             * @var $previousGoogleFons   N2AssetsGoogleFonts
             */
            $previousCSS = array_shift(self::$cssStack);
            self::$css   = self::$cssStack[0];

            $previousLESS = array_shift(self::$lessStack);
            self::$less   = self::$lessStack[0];

            $previousJS = array_shift(self::$jsStack);
            self::$js   = self::$jsStack[0];

            $previousGoogleFons = array_shift(self::$googleFontsStack);
            self::$googleFonts  = self::$googleFontsStack[0];

            return array(
                'css'         => $previousCSS->serialize(),
                'less'        => $previousLESS->serialize(),
                'js'          => $previousJS->serialize(),
                'googleFonts' => $previousGoogleFons->serialize()
            );
        } else {
            echo "Too much remove stack on the asset manager...";
            n2_exit(true);
        }
    }

    public static function enableCacheAll() {
        self::$cacheAll = true;
    }

    public static function disableCacheAll() {
        self::$cacheAll = false;
    }

    public static function addCachedGroup($group) {
        if (!in_array($group, self::$cachedGroups)) {
            self::$cachedGroups[] = $group;
        }
    }

    public static function loadFromArray($array) {

        self::$css->unSerialize($array['css']);
        self::$less->unSerialize($array['less']);
        self::$js->unSerialize($array['js']);
        self::$googleFonts->unSerialize($array['googleFonts']);
    }

    public static function getCSS($path = false) {
        if (self::$css) {
            if ($path) {
                return self::$css->get();
            }
            return self::$css->getOutput();
        }
        return '';
    }

    public static function getJs($path = false) {
        if (self::$js) {
            if ($path) {
                return self::$js->get();
            }
            return self::$js->getOutput();
        }
        return '';
    }

    public static function generateAjaxCSS() {
        /*
        $data                  = N2Post::getVar('loadedCSS');
        $alreadyLoadedCSSFiles = array();
        if ($data) {
            $alreadyLoadedCSSFiles = (array)json_decode(base64_decode($data));
        }
        self::$css->removeFiles($alreadyLoadedCSSFiles);
        */

        return N2Html::style(self::$css->getAjaxOutput());
    }


    public static function generateAjaxJS() {
        /*
        $data                 = N2Post::getVar('loadedJSS');
        $alreadyLoadedJSFiles = array();
        if (!empty($data)) {
            $alreadyLoadedJSFiles = (array)json_decode(base64_decode($data));
        }

        self::$js->removeFiles($alreadyLoadedJSFiles);
        */

        return self::$js->getAjaxOutput();
    }

}