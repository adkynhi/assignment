<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php
echo N2Html::openTag('ul', array('class' => 'n2-list n2-h4 n2-list-orderable'));
if (count($ul)) {
    foreach ($ul as $li) {

        //begin li
        $htmlOptions = array();
        if (isset($li["htmlOptions"])) {
            $htmlOptions = $li["htmlOptions"];
        } elseif (isset($li["class"])) {
            $htmlOptions = array(
                "class" => $li["class"]
            );
        }
        if (isset($li["id"]) && strlen($li["id"]) > 1) $htmlOptions["id"] = $li["id"];

        echo N2Html::openTag('li', $htmlOptions);

        echo $li['contents'];

        if (!empty($li['actions'])) {
            echo N2Html::tag('span', array('class' => 'n2-actions'), $li['actions']);
        }

        echo N2Html::closeTag('li');
        //end li

    }
}

echo N2Html::closeTag('ul');

?>