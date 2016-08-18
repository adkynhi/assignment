<?php
/**
* ChronoCMS version 1.0
* Copyright (c) 2012 ChronoCMS.com, All rights reserved.
* Author: (ChronoCMS.com Team)
* license: Please read LICENSE.txt
* Visit http://www.ChronoCMS.com for regular updates and information.
**/
namespace GCore\Admin\Extensions\Chronoforums\Helpers;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Menu {
	var $config = true;
	var $view;

	public static function render(){
		$class_noreplies = ' btn-default';
		if(\GCore\Libs\Request::data('list') == 'noreplies'){
			$class_noreplies = ' btn-warning active';
		}
		?>
		<div class="btn-group">
			<a class="btn<?php echo $class_noreplies; ?>" title="<?php echo l_('CATEGORIES_MANAGER'); ?>" href="<?php echo r_("index.php?ext=chronoforums&cont=categories"); ?>"><?php echo l_('CATEGORIES_MANAGER'); ?></a>
			<a class="btn<?php echo $class_noreplies; ?>" title="<?php echo l_('FORUMS_MANAGER'); ?>" href="<?php echo r_("index.php?ext=chronoforums&cont=forums"); ?>"><?php echo l_('FORUMS_MANAGER'); ?></a>
			<a class="btn<?php echo $class_noreplies; ?>" title="<?php echo l_('TAGS_MANAGER'); ?>" href="<?php echo r_("index.php?ext=chronoforums&cont=tags"); ?>"><?php echo l_('TAGS_MANAGER'); ?></a>
			<a class="btn<?php echo $class_noreplies; ?>" title="<?php echo l_('RANKS_MANAGER'); ?>" href="<?php echo r_("index.php?ext=chronoforums&cont=ranks"); ?>"><?php echo l_('RANKS_MANAGER'); ?></a>
			<a class="btn<?php echo $class_noreplies; ?>" title="<?php echo l_('SETTINGS'); ?>" href="<?php echo r_("index.php?ext=chronoforums&act=settings"); ?>"><?php echo l_('SETTINGS'); ?></a>
			<a class="btn<?php echo $class_noreplies; ?>" title="<?php echo l_('PERMISSIONS'); ?>" href="<?php echo r_("index.php?ext=chronoforums&act=permissions"); ?>"><?php echo l_('PERMISSIONS'); ?></a>
			<a class="btn<?php echo $class_noreplies; ?>" title="<?php echo l_('HOME'); ?>" href="<?php echo r_("index.php?ext=chronoforums"); ?>"><?php echo l_('HOME'); ?></a>
		</div>
		<?php
	}
}
?>