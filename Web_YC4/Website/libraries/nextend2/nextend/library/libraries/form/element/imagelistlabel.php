<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php
N2Loader::import('libraries.form.element.radio');

class N2ElementImageListLabel extends N2ElementRadio
{

    function fetchElement() {
        $html = N2Html::openTag("div", array(
            'class' => 'n2-imagelist n2-imagelistlabel',
            'style' => N2XmlHelper::getAttribute($this->_xml, 'style')
        ));

        $html .= parent::fetchElement();
        $html .= N2Html::closeTag('div');

        return $html;
    }

    function generateOptions(&$xml) {
        $this->values = array();
        $html         = '';
        foreach ($xml->option AS $option) {
            $value = N2XmlHelper::getAttribute($option, 'value');

            $selected = $this->isSelected($value);

            $this->values[] = $value;
            $html .= N2Html::tag("div", array(
                "class" => "n2-radio-option n2-imagelist-option" . ($selected ? ' n2-active' : ''),
                "style" => "background-image:url(" . N2ImageHelper::fixed(N2XmlHelper::getAttribute($option, 'image')) . ");"
            ), N2Html::tag('span', array(), (string)$option));
        }

        return $html;
    }

    function isSelected($value) {
        if (basename($value) == basename($this->getValue())) {
            return true;
        }
        return false;
    }
}
