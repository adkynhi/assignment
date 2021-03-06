<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php


class N2SmartsliderInstallModel extends N2Model
{

    private static $sql = array(
        "CREATE TABLE IF NOT EXISTS `#__nextend2_smartslider3_generators` (
  `id`     INT(11)      NOT NULL AUTO_INCREMENT,
  `group`  VARCHAR(254) NOT NULL,
  `type`   VARCHAR(254) NOT NULL,
  `params` TEXT         NOT NULL,
  PRIMARY KEY (`id`)
)
  DEFAULT CHARSET = utf8;",
        "CREATE TABLE IF NOT EXISTS `#__nextend2_smartslider3_sliders` (
  `id`     INT(11)      NOT NULL AUTO_INCREMENT,
  `title`  VARCHAR(100) NOT NULL,
  `type`   VARCHAR(30)  NOT NULL,
  `params` MEDIUMTEXT   NOT NULL,
  `time`   DATETIME     NOT NULL,
  PRIMARY KEY (`id`)
)
  DEFAULT CHARSET = utf8;",
        "CREATE TABLE IF NOT EXISTS `#__nextend2_smartslider3_slides` (
  `id`           INT(11)      NOT NULL AUTO_INCREMENT,
  `title`        VARCHAR(200) NOT NULL,
  `slider`       INT(11)      NOT NULL,
  `publish_up`   DATETIME     NOT NULL,
  `publish_down` DATETIME     NOT NULL,
  `published`    TINYINT(1)   NOT NULL,
  `first`        INT(11)      NOT NULL,
  `slide`        LONGTEXT,
  `description`  TEXT         NOT NULL,
  `thumbnail`    VARCHAR(255) NOT NULL,
  `params`       TEXT         NOT NULL,
  `ordering`     INT(11)      NOT NULL,
  `generator_id` INT(11)      NOT NULL,
  PRIMARY KEY (`id`)
)
  DEFAULT CHARSET = utf8;",

        "UPDATE `#__nextend2_section_storage` SET `value` = 1 WHERE `application` LIKE 'smartslider' AND `section` LIKE 'sliderChanged';"

    );

    private static $sampleSlider = array(
        'INSERT INTO `#__nextend2_smartslider3_sliders` (`id`, `title`, `type`, `params`, `time`) VALUES (1, \'Sample Slider\', \'simple\', \'{"widget-bullet-position-mode":"simple","widget-bullet-position-area":"12","widget-bullet-position-offset":"10","widget-bullet-action":"click","widget-bullet-style":"eyJuYW1lIjoiU3RhdGljIiwiZGF0YSI6W3siYmFja2dyb3VuZGNvbG9yIjoiMDAwMDAwYWIiLCJwYWRkaW5nIjoiNXwqfDV8Knw1fCp8NXwqfHB4IiwiYm94c2hhZG93IjoiMHwqfDB8KnwwfCp8MHwqfDAwMDAwMGZmIiwiYm9yZGVyIjoiMHwqfHNvbGlkfCp8MDAwMDAwZmYiLCJib3JkZXJyYWRpdXMiOiI1MCIsImV4dHJhIjoibWFyZ2luOiA0cHg7In0seyJleHRyYSI6IiIsImJhY2tncm91bmRjb2xvciI6IjA5YjQ3NGZmIn1dfQ==","widget-bullet-bar":"","widget-bullet-align":"center","widget-bullet-orientation":"auto","widget-bullet-bar-full-size":0,"widget-bullet-overlay":0,"widget-bullet-thumbnail-show-image":"1","widget-bullet-thumbnail-width":"120","widget-bullet-thumbnail-style":"eyJuYW1lIjoiU3RhdGljIiwiZGF0YSI6W3siYmFja2dyb3VuZGNvbG9yIjoiMDAwMDAwODAiLCJwYWRkaW5nIjoiM3wqfDN8KnwzfCp8M3wqfHB4IiwiYm94c2hhZG93IjoiMHwqfDB8KnwwfCp8MHwqfDAwMDAwMGZmIiwiYm9yZGVyIjoiMHwqfHNvbGlkfCp8MDAwMDAwZmYiLCJib3JkZXJyYWRpdXMiOiIzIiwiZXh0cmEiOiJtYXJnaW46IDVweDsifV19","widget-bullet-thumbnail-side":"before","widget-arrow-responsive-desktop":1,"widget-arrow-responsive-tablet":0.7,"widget-arrow-responsive-mobile":0.5,"widget-arrow-previous-image":"","widget-arrow-previous":"$ss$\\/plugins\\/widgetarrow\\/image\\/image\\/previous\\/thin-horizontal.svg","widget-arrow-previous-color":"ffffffcc","widget-arrow-previous-hover":"0","widget-arrow-previous-hover-color":"ffffffcc","widget-arrow-style":"","widget-arrow-previous-position-mode":"simple","widget-arrow-previous-position-area":"6","widget-arrow-previous-position-offset":"15","widget-arrow-next-position-mode":"simple","widget-arrow-next-position-area":"7","widget-arrow-next-position-offset":"15","widget-arrow-animation":"fade","widget-arrow-mirror":1,"widget-arrow-next-image":"","widget-arrow-next":"$ss$\\/plugins\\/widgetarrow\\/image\\/image\\/next\\/thin-horizontal.svg","widget-arrow-next-color":"ffffffcc","widget-arrow-next-hover":0,"widget-arrow-next-hover-color":"ffffffcc","controlsScroll":"0","controlsDrag":"1","controlsTouch":"horizontal","controlsKeyboard":"1","align":"normal","animation":"horizontal","animation-duration":"600","background-animation":"","background-animation-speed":"normal","width":"1200","height":"600","fontsize":"16","margin":"0|*|0|*|0|*|0","responsive-mode":"auto","responsiveScaleDown":"1","responsiveScaleUp":"1","responsiveSliderHeightMin":"0","responsiveSliderHeightMax":"3000","responsiveSlideWidthMax":"3000","autoplay":"1","autoplayDuration":"8000","autoplayStopClick":"1","autoplayStopMouse":"0","autoplayStopMedia":"1","widgetarrow":"imageEmpty","widget-arrow-display-hover":"0","widget-arrow-previous-position-stack":"1","widget-arrow-previous-position-horizontal":"left","widget-arrow-previous-position-horizontal-position":"0","widget-arrow-previous-position-horizontal-unit":"px","widget-arrow-previous-position-vertical":"top","widget-arrow-previous-position-vertical-position":"0","widget-arrow-previous-position-vertical-unit":"px","widget-arrow-next-position-stack":"1","widget-arrow-next-position-horizontal":"left","widget-arrow-next-position-horizontal-position":"0","widget-arrow-next-position-horizontal-unit":"px","widget-arrow-next-position-vertical":"top","widget-arrow-next-position-vertical-position":"0","widget-arrow-next-position-vertical-unit":"px","widgetbullet":"transition","widget-bullet-display-hover":"0","widget-bullet-thumbnail-height":"81","widget-bullet-position-stack":"1","widget-bullet-position-horizontal":"left","widget-bullet-position-horizontal-position":"0","widget-bullet-position-horizontal-unit":"px","widget-bullet-position-vertical":"top","widget-bullet-position-vertical-position":"0","widget-bullet-position-vertical-unit":"px","widgetautoplay":"disabled","widget-autoplay-display-hover":"0","widgetbar":"disabled","widget-bar-display-hover":"0","widgetthumbnail":"disabled","widget-thumbnail-display-hover":"0","widget-thumbnail-width":"100","widget-thumbnail-height":"60","widgetshadow":"disabled","widgets":"bullet","background":""}\', \'2015-11-01 14:14:20\');',
        'INSERT INTO `#__nextend2_smartslider3_slides` (`id`, `title`, `slider`, `publish_up`, `publish_down`, `published`, `first`, `slide`, `description`, `thumbnail`, `params`, `ordering`, `generator_id`) VALUES
            (1, \'Slide One\', 1, \'2015-11-01 12:27:34\', \'2025-11-11 12:27:34\', 1, 0, \'[{"zIndex":1,"eye":false,"lock":false,"animations":{"repeatable":0,"specialZeroIn":0,"transformOriginIn":"50|*|50|*|0","inPlayEvent":"","repeatCount":0,"repeatStartDelay":0,"transformOriginLoop":"50|*|50|*|0","loopPlayEvent":"","loopPauseEvent":"","loopStopEvent":"","transformOriginOut":"50|*|50|*|0","outPlayEvent":"","instantOut":1,"in":[],"loop":[],"out":[]},"id":null,"parentid":null,"class":"","name":"MartinDwyer","namesynced":1,"crop":"visible","inneralign":"left","parallax":0,"adaptivefont":0,"desktopportrait":1,"desktoplandscape":1,"tabletportrait":1,"tabletlandscape":1,"mobileportrait":1,"mobilelandscape":1,"responsiveposition":1,"responsivesize":1,"desktopportraitleft":0,"desktopportraittop":-267,"desktopportraitwidth":"auto","desktopportraitheight":"auto","desktopportraitalign":"center","desktopportraitvalign":"bottom","desktopportraitparentalign":"center","desktopportraitparentvalign":"middle","desktopportraitfontsize":100,"mobileportraitleft":0,"mobileportraittop":-319,"mobileportraitalign":"center","mobileportraitvalign":"bottom","mobileportraitfontsize":120,"items":[{"type":"heading","values":{"link":"#|*|_self","font":"eyJuYW1lIjoiU3RhdGljIiwiZGF0YSI6W3siZXh0cmEiOiIiLCJjb2xvciI6IjBiMGIwYmZmIiwic2l6ZSI6IjM2fHxweCIsInRzaGFkb3ciOiIwfCp8MHwqfDB8KnwwMDAwMDBmZiIsImFmb250IjoiUmFsZXdheSxBcmlhbCIsImxpbmVoZWlnaHQiOiIxIiwiYm9sZCI6MCwiaXRhbGljIjowLCJ1bmRlcmxpbmUiOjAsImFsaWduIjoiY2VudGVyIiwibGV0dGVyc3BhY2luZyI6IjEwcHgiLCJ3b3Jkc3BhY2luZyI6Im5vcm1hbCIsInRleHR0cmFuc2Zvcm0iOiJ1cHBlcmNhc2UifSx7ImV4dHJhIjoiIn0seyJleHRyYSI6IiJ9XX0=","style":"eyJuYW1lIjoiU3RhdGljIiwiZGF0YSI6W3siYmFja2dyb3VuZGNvbG9yIjoiZmZmZmZmY2MiLCJwYWRkaW5nIjoiMC44fCp8MXwqfDAuOHwqfDF8KnxlbSIsImJveHNoYWRvdyI6IjB8KnwwfCp8MHwqfDB8KnwwMDAwMDBmZiIsImJvcmRlciI6IjB8Knxzb2xpZHwqfDAwMDAwMGZmIiwiYm9yZGVycmFkaXVzIjoiMCIsImV4dHJhIjoiIn0seyJleHRyYSI6IiJ9XX0=","heading":"Martin Dwyer","fullwidth":"1","nowrap":"1"}}]},{"zIndex":2,"eye":false,"lock":false,"animations":{"repeatable":0,"specialZeroIn":0,"transformOriginIn":"50|*|50|*|0","inPlayEvent":"","repeatCount":0,"repeatStartDelay":0,"transformOriginLoop":"50|*|50|*|0","loopPlayEvent":"","loopPauseEvent":"","loopStopEvent":"","transformOriginOut":"50|*|50|*|0","outPlayEvent":"","instantOut":1,"in":[],"loop":[],"out":[]},"id":null,"parentid":null,"class":"","name":"ApplicationDeveloper","namesynced":1,"crop":"visible","inneralign":"left","parallax":0,"adaptivefont":0,"desktopportrait":1,"desktoplandscape":1,"tabletportrait":1,"tabletlandscape":1,"mobileportrait":1,"mobilelandscape":1,"responsiveposition":1,"responsivesize":1,"desktopportraitleft":0,"desktopportraittop":338,"desktopportraitwidth":"auto","desktopportraitheight":"auto","desktopportraitalign":"center","desktopportraitvalign":"top","desktopportraitparentalign":"center","desktopportraitparentvalign":"middle","desktopportraitfontsize":100,"mobileportraitleft":0,"mobileportraittop":291,"mobileportraitalign":"center","mobileportraitvalign":"top","mobileportraitfontsize":120,"items":[{"type":"heading","values":{"link":"#|*|_self","font":"eyJuYW1lIjoiU3RhdGljIiwiZGF0YSI6W3siZXh0cmEiOiIiLCJjb2xvciI6ImZmZmZmZmZmIiwic2l6ZSI6IjIyfHxweCIsInRzaGFkb3ciOiIwfCp8MHwqfDB8KnwwMDAwMDBmZiIsImFmb250IjoiUmFsZXdheSxBcmlhbCIsImxpbmVoZWlnaHQiOiIxIiwiYm9sZCI6MCwiaXRhbGljIjowLCJ1bmRlcmxpbmUiOjAsImFsaWduIjoiY2VudGVyIiwibGV0dGVyc3BhY2luZyI6IjJweCIsIndvcmRzcGFjaW5nIjoibm9ybWFsIiwidGV4dHRyYW5zZm9ybSI6Im5vbmUifSx7ImV4dHJhIjoiIn0seyJleHRyYSI6IiJ9XX0=","style":"eyJuYW1lIjoiU3RhdGljIiwiZGF0YSI6W3siYmFja2dyb3VuZGNvbG9yIjoiMDAwMDAwY2MiLCJwYWRkaW5nIjoiMC44fCp8MXwqfDAuOHwqfDF8KnxlbSIsImJveHNoYWRvdyI6IjB8KnwwfCp8MHwqfDB8KnwwMDAwMDBmZiIsImJvcmRlciI6IjB8Knxzb2xpZHwqfDAwMDAwMGZmIiwiYm9yZGVycmFkaXVzIjoiMCIsImV4dHJhIjoiIn0seyJleHRyYSI6IiJ9XX0=","heading":"Application Developer","fullwidth":"1","nowrap":"1"}}]}]\', \'\', \'http://smartslider3.com/sample/developerthumbnail.jpg\', \'{"generator_id":"0","first":"0","static-slide":"0","backgroundColor":"ffffff00","backgroundImage":"http:\\/\\/smartslider3.com\\/sample\\/programmer.jpg","backgroundImageOpacity":"100","backgroundMode":"default","link":"|*|_self","slide-duration":"0","background-animation":"","background-animation-speed":"default"}\', 0, 0),
            (2, \'Slide Two\', 1, \'2015-11-01 12:27:34\', \'2025-11-11 12:27:34\', 1, 0, \'[{"zIndex":1,"eye":false,"lock":false,"animations":{"repeatable":0,"specialZeroIn":0,"transformOriginIn":"50|*|50|*|0","inPlayEvent":"","repeatCount":0,"repeatStartDelay":0,"transformOriginLoop":"50|*|50|*|0","loopPlayEvent":"","loopPauseEvent":"","loopStopEvent":"","transformOriginOut":"50|*|50|*|0","outPlayEvent":"","instantOut":1,"in":[],"loop":[],"out":[]},"id":null,"parentid":null,"class":"","name":"RachelWright","namesynced":1,"crop":"visible","inneralign":"left","parallax":0,"adaptivefont":0,"desktopportrait":1,"desktoplandscape":1,"tabletportrait":1,"tabletlandscape":1,"mobileportrait":1,"mobilelandscape":1,"responsiveposition":1,"responsivesize":1,"desktopportraitleft":0,"desktopportraittop":-267,"desktopportraitwidth":"auto","desktopportraitheight":"auto","desktopportraitalign":"center","desktopportraitvalign":"bottom","desktopportraitparentalign":"center","desktopportraitparentvalign":"middle","desktopportraitfontsize":100,"mobileportraitleft":0,"mobileportraittop":-319,"mobileportraitalign":"center","mobileportraitvalign":"bottom","mobileportraitfontsize":120,"items":[{"type":"heading","values":{"link":"#|*|_self","font":"eyJuYW1lIjoiU3RhdGljIiwiZGF0YSI6W3siZXh0cmEiOiIiLCJjb2xvciI6IjBiMGIwYmZmIiwic2l6ZSI6IjM2fHxweCIsInRzaGFkb3ciOiIwfCp8MHwqfDB8KnwwMDAwMDBmZiIsImFmb250IjoiUmFsZXdheSxBcmlhbCIsImxpbmVoZWlnaHQiOiIxIiwiYm9sZCI6MCwiaXRhbGljIjowLCJ1bmRlcmxpbmUiOjAsImFsaWduIjoiY2VudGVyIiwibGV0dGVyc3BhY2luZyI6IjEwcHgiLCJ3b3Jkc3BhY2luZyI6Im5vcm1hbCIsInRleHR0cmFuc2Zvcm0iOiJ1cHBlcmNhc2UifSx7ImV4dHJhIjoiIn0seyJleHRyYSI6IiJ9XX0=","style":"eyJuYW1lIjoiU3RhdGljIiwiZGF0YSI6W3siYmFja2dyb3VuZGNvbG9yIjoiZmZmZmZmY2MiLCJwYWRkaW5nIjoiMC44fCp8MXwqfDAuOHwqfDF8KnxlbSIsImJveHNoYWRvdyI6IjB8KnwwfCp8MHwqfDB8KnwwMDAwMDBmZiIsImJvcmRlciI6IjB8Knxzb2xpZHwqfDAwMDAwMGZmIiwiYm9yZGVycmFkaXVzIjoiMCIsImV4dHJhIjoiIn0seyJleHRyYSI6IiJ9XX0=","heading":"Rachel Wright","fullwidth":"1","nowrap":"1"}}]},{"zIndex":2,"eye":false,"lock":false,"animations":{"repeatable":0,"specialZeroIn":0,"transformOriginIn":"50|*|50|*|0","inPlayEvent":"","repeatCount":0,"repeatStartDelay":0,"transformOriginLoop":"50|*|50|*|0","loopPlayEvent":"","loopPauseEvent":"","loopStopEvent":"","transformOriginOut":"50|*|50|*|0","outPlayEvent":"","instantOut":1,"in":[],"loop":[],"out":[]},"id":null,"parentid":null,"class":"","name":"ArtDirector&Photographer","namesynced":1,"crop":"visible","inneralign":"left","parallax":0,"adaptivefont":0,"desktopportrait":1,"desktoplandscape":1,"tabletportrait":1,"tabletlandscape":1,"mobileportrait":1,"mobilelandscape":1,"responsiveposition":1,"responsivesize":1,"desktopportraitleft":0,"desktopportraittop":338,"desktopportraitwidth":"auto","desktopportraitheight":"auto","desktopportraitalign":"center","desktopportraitvalign":"top","desktopportraitparentalign":"center","desktopportraitparentvalign":"middle","desktopportraitfontsize":100,"mobileportraitleft":0,"mobileportraittop":291,"mobileportraitalign":"center","mobileportraitvalign":"top","mobileportraitfontsize":120,"items":[{"type":"heading","values":{"link":"#|*|_self","font":"eyJuYW1lIjoiU3RhdGljIiwiZGF0YSI6W3siZXh0cmEiOiIiLCJjb2xvciI6ImZmZmZmZmZmIiwic2l6ZSI6IjIyfHxweCIsInRzaGFkb3ciOiIwfCp8MHwqfDB8KnwwMDAwMDBmZiIsImFmb250IjoiUmFsZXdheSxBcmlhbCIsImxpbmVoZWlnaHQiOiIxIiwiYm9sZCI6MCwiaXRhbGljIjowLCJ1bmRlcmxpbmUiOjAsImFsaWduIjoiY2VudGVyIiwibGV0dGVyc3BhY2luZyI6IjJweCIsIndvcmRzcGFjaW5nIjoibm9ybWFsIiwidGV4dHRyYW5zZm9ybSI6Im5vbmUifSx7ImV4dHJhIjoiIn0seyJleHRyYSI6IiJ9XX0=","style":"eyJuYW1lIjoiU3RhdGljIiwiZGF0YSI6W3siYmFja2dyb3VuZGNvbG9yIjoiMDAwMDAwY2MiLCJwYWRkaW5nIjoiMC44fCp8MXwqfDAuOHwqfDF8KnxlbSIsImJveHNoYWRvdyI6IjB8KnwwfCp8MHwqfDB8KnwwMDAwMDBmZiIsImJvcmRlciI6IjB8Knxzb2xpZHwqfDAwMDAwMGZmIiwiYm9yZGVycmFkaXVzIjoiMCIsImV4dHJhIjoiIn0seyJleHRyYSI6IiJ9XX0=","heading":"Art Director & Photographer","fullwidth":"1","nowrap":"1"}}]}]\', \'\', \'http://smartslider3.com/sample/artdirectorthumbnail.jpg\', \'{"generator_id":"0","first":"0","static-slide":"0","backgroundColor":"ffffff00","backgroundImage":"http:\\/\\/smartslider3.com\\/sample\\/free1.jpg","backgroundImageOpacity":"100","backgroundMode":"default","link":"|*|_self","slide-duration":"0","background-animation":"","background-animation-speed":"default"}\', 1, 0),
            (3, \'Slide Three\', 1, \'2015-11-01 12:27:34\', \'2025-11-11 12:27:34\', 1, 0, \'[{"zIndex":1,"eye":false,"lock":false,"animations":{"repeatable":0,"specialZeroIn":0,"transformOriginIn":"50|*|50|*|0","inPlayEvent":"","repeatCount":0,"repeatStartDelay":0,"transformOriginLoop":"50|*|50|*|0","loopPlayEvent":"","loopPauseEvent":"","loopStopEvent":"","transformOriginOut":"50|*|50|*|0","outPlayEvent":"","instantOut":1,"in":[],"loop":[],"out":[]},"id":null,"parentid":null,"class":"","name":"AndrewButler","namesynced":1,"crop":"visible","inneralign":"left","parallax":0,"adaptivefont":0,"desktopportrait":1,"desktoplandscape":1,"tabletportrait":1,"tabletlandscape":1,"mobileportrait":1,"mobilelandscape":1,"responsiveposition":1,"responsivesize":1,"desktopportraitleft":0,"desktopportraittop":-267,"desktopportraitwidth":"auto","desktopportraitheight":"auto","desktopportraitalign":"center","desktopportraitvalign":"bottom","desktopportraitparentalign":"center","desktopportraitparentvalign":"middle","desktopportraitfontsize":100,"mobileportraitleft":0,"mobileportraittop":-319,"mobileportraitalign":"center","mobileportraitvalign":"bottom","mobileportraitfontsize":120,"items":[{"type":"heading","values":{"link":"#|*|_self","font":"eyJuYW1lIjoiU3RhdGljIiwiZGF0YSI6W3siZXh0cmEiOiIiLCJjb2xvciI6IjBiMGIwYmZmIiwic2l6ZSI6IjM2fHxweCIsInRzaGFkb3ciOiIwfCp8MHwqfDB8KnwwMDAwMDBmZiIsImFmb250IjoiUmFsZXdheSxBcmlhbCIsImxpbmVoZWlnaHQiOiIxIiwiYm9sZCI6MCwiaXRhbGljIjowLCJ1bmRlcmxpbmUiOjAsImFsaWduIjoiY2VudGVyIiwibGV0dGVyc3BhY2luZyI6IjEwcHgiLCJ3b3Jkc3BhY2luZyI6Im5vcm1hbCIsInRleHR0cmFuc2Zvcm0iOiJ1cHBlcmNhc2UifSx7ImV4dHJhIjoiIn0seyJleHRyYSI6IiJ9XX0=","style":"eyJuYW1lIjoiU3RhdGljIiwiZGF0YSI6W3siYmFja2dyb3VuZGNvbG9yIjoiZmZmZmZmY2MiLCJwYWRkaW5nIjoiMC44fCp8MXwqfDAuOHwqfDF8KnxlbSIsImJveHNoYWRvdyI6IjB8KnwwfCp8MHwqfDB8KnwwMDAwMDBmZiIsImJvcmRlciI6IjB8Knxzb2xpZHwqfDAwMDAwMGZmIiwiYm9yZGVycmFkaXVzIjoiMCIsImV4dHJhIjoiIn0seyJleHRyYSI6IiJ9XX0=","heading":"Andrew Butler","fullwidth":"1","nowrap":"1"}}]},{"zIndex":2,"eye":false,"lock":false,"animations":{"repeatable":0,"specialZeroIn":0,"transformOriginIn":"50|*|50|*|0","inPlayEvent":"","repeatCount":0,"repeatStartDelay":0,"transformOriginLoop":"50|*|50|*|0","loopPlayEvent":"","loopPauseEvent":"","loopStopEvent":"","transformOriginOut":"50|*|50|*|0","outPlayEvent":"","instantOut":1,"in":[],"loop":[],"out":[]},"id":null,"parentid":null,"class":"","name":"Photographer&Illustrator","namesynced":1,"crop":"visible","inneralign":"left","parallax":0,"adaptivefont":0,"desktopportrait":1,"desktoplandscape":1,"tabletportrait":1,"tabletlandscape":1,"mobileportrait":1,"mobilelandscape":1,"responsiveposition":1,"responsivesize":1,"desktopportraitleft":0,"desktopportraittop":338,"desktopportraitwidth":"auto","desktopportraitheight":"auto","desktopportraitalign":"center","desktopportraitvalign":"top","desktopportraitparentalign":"center","desktopportraitparentvalign":"middle","desktopportraitfontsize":100,"mobileportraitleft":0,"mobileportraittop":291,"mobileportraitalign":"center","mobileportraitvalign":"top","mobileportraitfontsize":120,"items":[{"type":"heading","values":{"link":"#|*|_self","font":"eyJuYW1lIjoiU3RhdGljIiwiZGF0YSI6W3siZXh0cmEiOiIiLCJjb2xvciI6ImZmZmZmZmZmIiwic2l6ZSI6IjIyfHxweCIsInRzaGFkb3ciOiIwfCp8MHwqfDB8KnwwMDAwMDBmZiIsImFmb250IjoiUmFsZXdheSxBcmlhbCIsImxpbmVoZWlnaHQiOiIxIiwiYm9sZCI6MCwiaXRhbGljIjowLCJ1bmRlcmxpbmUiOjAsImFsaWduIjoiY2VudGVyIiwibGV0dGVyc3BhY2luZyI6IjJweCIsIndvcmRzcGFjaW5nIjoibm9ybWFsIiwidGV4dHRyYW5zZm9ybSI6Im5vbmUifSx7ImV4dHJhIjoiIn0seyJleHRyYSI6IiJ9XX0=","style":"eyJuYW1lIjoiU3RhdGljIiwiZGF0YSI6W3siYmFja2dyb3VuZGNvbG9yIjoiMDAwMDAwY2MiLCJwYWRkaW5nIjoiMC44fCp8MXwqfDAuOHwqfDF8KnxlbSIsImJveHNoYWRvdyI6IjB8KnwwfCp8MHwqfDB8KnwwMDAwMDBmZiIsImJvcmRlciI6IjB8Knxzb2xpZHwqfDAwMDAwMGZmIiwiYm9yZGVycmFkaXVzIjoiMCIsImV4dHJhIjoiIn0seyJleHRyYSI6IiJ9XX0=","heading":"Photographer & Illustrator","fullwidth":"1","nowrap":"1"}}]}]\', \'\', \'http://smartslider3.com/sample/photographerthumbnail.jpg\', \'{"generator_id":"0","first":"0","static-slide":"0","backgroundColor":"ffffff00","backgroundImage":"http:\\/\\/smartslider3.com\\/sample\\/photographer.jpg","backgroundImageOpacity":"100","backgroundMode":"default","link":"|*|_self","slide-duration":"0","background-animation":"","background-animation-speed":"default"}\', 2, 0);'
    );

    public function install() {
        foreach (self::$sql AS $query) {
            $this->db->query($this->db->parsePrefix($query));
        }

        N2Loader::import('install', 'smartslider.platform');

        $sliders = $this->db->queryAll($this->db->parsePrefix('SELECT * FROM #__nextend2_smartslider3_sliders LIMIT 1'));
        if (empty($sliders)) {
            foreach (self::$sampleSlider AS $query) {
                $this->db->query($this->db->parsePrefix($query));
            }
        }
    }
}