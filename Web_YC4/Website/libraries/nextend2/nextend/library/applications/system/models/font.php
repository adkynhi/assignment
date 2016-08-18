<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php

N2Loader::import(array(
    'libraries.fonts.storage'
));

class N2SystemFontModel extends N2SystemVisualModel
{

    public $type = 'font';

    public function renderForm() {
        $form = new N2Form();
        $form->loadXMLFile(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'forms' . DIRECTORY_SEPARATOR . 'font' . DIRECTORY_SEPARATOR . 'form.xml');
        $form->render('n2-font-editor');
    }

    public function renderFormExtra() {
        $form = new N2Form();
        $form->loadXMLFile(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'forms' . DIRECTORY_SEPARATOR . 'font' . DIRECTORY_SEPARATOR . 'extra.xml');
        $form->render('n2-font-editor');
    }
}