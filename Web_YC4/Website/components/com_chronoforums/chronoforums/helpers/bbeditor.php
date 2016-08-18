<?php
/**
* ChronoCMS version 1.0
* Copyright (c) 2012 ChronoCMS.com, All rights reserved.
* Author: (ChronoCMS.com Team)
* license: Please read LICENSE.txt
* Visit http://www.ChronoCMS.com for regular updates and information.
**/
namespace GCore\Extensions\Chronoforums\Helpers;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Bbeditor {
	var $view;
	
	function editor($message_name = 'Post[text]', $message_rows = 10){
		$fparams = $this->view->vars['fparams'];
		?>
		<?php if($fparams->get('board_editor', 'default') != 'default'): ?>
			<?php
				$doc = \GCore\Libs\Document::getInstance();
				//$doc->_('jquery');
				$doc->_('editor');
				$doc->__('editor', '#post-text', array('plugins' => 'bbcode'));
				echo $this->view->Html->input($message_name, array('type' => 'textarea', 'id' => 'post-text', 'rows' => '10', 'cols' => '80', 'style' => 'height:300px; width:600px;'));
				$external_editor = true;
			?>
		<?php else: ?>
			<script type="text/javascript">
			// <![CDATA[
				//var form_name = 'postform';
				//var text_name = 'message';
				var bbcode_form_id = 'postform';
				var bbcode_area_id = 'post-text';
				var load_draft = false;
				var upload = false;

				// Define the bbCode tags
				var bbcode = new Array();
				var bbtags = new Array('[b]','[/b]','[i]','[/i]','[u]','[/u]','[quote]','[/quote]','[code]','[/code]','[list]','[/list]','[list=]','[/list]','[img]','[/img]','[url]','[/url]','[flash=]', '[/flash]','[size=]','[/size]','[private]','[/private]');
				var imageTag = false;

			// ]]>
			</script>
			<script src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/js/editor.js" type="text/javascript"></script>
			
			<div class="panel panel-default cfu-editor">
				<div class="panel-heading">
					<a title="<?php echo l_('CHRONOFORUMS_BOLD_TEXT'); ?>: [b]text[/b]" onclick="bbstyle(0); return false;" name="addbbcode0" accesskey="b" class="btn btn-default btn-sm gcoreTooltip"><i class="fa fa-bold fa-fw fa-lg"></i></a>
					<a title="<?php echo l_('CHRONOFORUMS_ITALIC_TEXT'); ?>: [i]text[/i]" onclick="bbstyle(2); return false;" name="addbbcode2" accesskey="i" class="btn btn-default btn-sm gcoreTooltip"><i class="fa fa-italic fa-fw fa-lg"></i></a>
					<a title="<?php echo l_('CHRONOFORUMS_UNDERLINE_TEXT'); ?>: [u]text[/u]" onclick="bbstyle(4); return false;" name="addbbcode4" accesskey="u" class="btn btn-default btn-sm gcoreTooltip"><i class="fa fa-underline fa-fw fa-lg"></i></a>
					<a title="<?php echo l_('CHRONOFORUMS_QUOTE_TEXT'); ?>: [quote]text[/quote]" onclick="bbstyle(6); return false;" name="addbbcode6" accesskey="q" class="btn btn-default btn-sm gcoreTooltip"><i class="fa fa-quote-left fa-fw fa-lg"></i></a>
					<a title="<?php echo l_('CHRONOFORUMS_CODE_DISPLAY'); ?>: [code]code[/code]" onclick="bbstyle(8); return false;" name="addbbcode8" accesskey="c" class="btn btn-default btn-sm gcoreTooltip"><i class="fa fa-code fa-fw fa-lg"></i></a>
					<a title="<?php echo l_('CHRONOFORUMS_LIST'); ?>: [list]text[/list]" onclick="bbstyle(10); return false;" name="addbbcode10" accesskey="l" class="btn btn-default btn-sm gcoreTooltip"><i class="fa fa-list-ul fa-fw fa-lg"></i></a>
					<a title="<?php echo l_('CHRONOFORUMS_ORDERED_LIST'); ?>: [list=]text[/list]" onclick="bbstyle(12); return false;" name="addbbcode12" accesskey="o" class="btn btn-default btn-sm gcoreTooltip"><i class="fa fa-list-ol fa-fw fa-lg"></i></a>
					<a title="<?php echo l_('CHRONOFORUMS_LIST_ELEMENT'); ?>: [*]text[/*]" onclick="bbstyle(-1); return false;" name="addlistitem" accesskey="y" class="btn btn-default btn-sm gcoreTooltip"><i class="fa fa-circle-o fa-fw fa-lg"></i></a>
					<a title="<?php echo l_('CHRONOFORUMS_INSERT_IMAGE'); ?>: [img]http://image_url[/img]" onclick="bbstyle(14); return false;" name="addbbcode14" accesskey="p" class="btn btn-default btn-sm gcoreTooltip"><i class="fa fa-picture-o fa-fw fa-lg"></i></a>
					<a title="<?php echo l_('CHRONOFORUMS_INSERT_URL'); ?>: [url]http://url[/url] or [url=http://url]URL text[/url]" onclick="bbstyle(16); return false;" name="addbbcode16" accesskey="w" class="btn btn-default btn-sm gcoreTooltip"><i class="fa fa-link fa-fw fa-lg"></i></a>
					<!--<a title="<?php echo l_('CHRONOFORUMS_FLASH'); ?>: [flash=width,height]http://url[/flash]" onclick="bbstyle(18); return false;" name="addbbcode18" accesskey="d" class="btn btn-default btn-sm"><i class="fa fa-bold fa-fw fa-lg"></i></a>-->
					<div class="btn-group">
						<button type="button" class="btn btn-default btn-sm dropdown-toggle gcoreTooltip" data-g-toggle="dropdown" title="<?php echo l_('CHRONOFORUMS_FONT_SIZE'); ?>">
						<i class="fa fa-text-height fa-fw fa-lg"></i>
						</button>
						<ul class="dropdown-menu gdropdown" role="menu">
							<li><a title="<?php echo l_('CHRONOFORUMS_TINY'); ?>: [size=50]text[/size]" onclick="bbfontstyle('[size=50]', '[/size]'); return false;" name="addbbcode20" class="" style="font-size:0.7em;"><?php echo l_('CHRONOFORUMS_TINY'); ?></a></li>
							<li><a title="<?php echo l_('CHRONOFORUMS_SMALL'); ?>: [size=50]text[/size]" onclick="bbfontstyle('[size=85]', '[/size]'); return false;" name="addbbcode20" class="" style="font-size:0.9em;"><?php echo l_('CHRONOFORUMS_SMALL'); ?></a></li>
							<li><a title="<?php echo l_('CHRONOFORUMS_NORMAL'); ?>: [size=50]text[/size]" onclick="bbfontstyle('[size=100]', '[/size]'); return false;" name="addbbcode20" class="" style="font-size:1em;"><?php echo l_('CHRONOFORUMS_NORMAL'); ?></a></li>
							<li><a title="<?php echo l_('CHRONOFORUMS_LARGE'); ?>: [size=50]text[/size]" onclick="bbfontstyle('[size=150]', '[/size]'); return false;" name="addbbcode20" class="" style="font-size:1.2em;"><?php echo l_('CHRONOFORUMS_LARGE'); ?></a></li>
							<li><a title="<?php echo l_('CHRONOFORUMS_HUGE'); ?>: [size=50]text[/size]" onclick="bbfontstyle('[size=200]', '[/size]'); return false;" name="addbbcode20" class="" style="font-size:1.8em;"><?php echo l_('CHRONOFORUMS_HUGE'); ?></a></li>
						</ul>
					</div>
					
					<div class="btn-group">
						<button type="button" class="btn btn-default btn-sm dropdown-toggle gcoreTooltip" data-g-toggle="dropdown" title="<?php echo l_('CHRONOFORUMS_FONT_COLOR'); ?>: [color=red]text[/color]  Tip: you can also use color=#FF0000">
						<i class="fa fa-font fa-fw fa-lg" style="color:#ff0000;"></i>
						</button>
						<div class="dropdown-menu gdropdown" role="menu" style="max-width:300px; padding:5px;">
							<table cellspacing="1" cellpadding="0" border="0">
								<tbody>
									<tr>
									<td bgcolor="#000000" style="background-color: rgb(0, 0, 0); height: 7px; width: 10px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#000000]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#000000" alt="#000000" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									<td bgcolor="#000040" style="background-color:#000040;width: 10px; height: 7px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#000040]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#000040" alt="#000040" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									<td bgcolor="#000080" style="background-color:#000080;width: 10px; height: 7px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#000080]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#000080" alt="#000080" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									<td bgcolor="#0000BF" style="background-color:#0000BF;width: 10px; height: 7px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#0000BF]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#0000BF" alt="#0000BF" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									<td bgcolor="#0000FF" style="background-color:#0000FF;width: 10px; height: 7px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#0000FF]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#0000FF" alt="#0000FF" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									<td bgcolor="#00FF80" style="background-color:#00FF80;width: 10px; height: 7px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#00FF80]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#00FF80" alt="#00FF80" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									<td bgcolor="#00FFBF" style="background-color:#00FFBF;width: 10px; height: 7px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#00FFBF]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#00FFBF" alt="#00FFBF" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									<td bgcolor="#00FFFF" style="background-color:#00FFFF;width: 10px; height: 7px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#00FFFF]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#00FFFF" alt="#00FFFF" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									</tr>
									<tr>
									<td bgcolor="#400000" style="background-color:#400000;width: 10px; height: 7px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#400000]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#400000" alt="#400000" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									<td bgcolor="#400040" style="background-color:#400040;width: 10px; height: 7px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#400040]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#400040" alt="#400040" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									<td bgcolor="#400080" style="background-color:#400080;width: 10px; height: 7px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#400080]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#400080" alt="#400080" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									<td bgcolor="#4000BF" style="background-color:#4000BF;width: 10px; height: 7px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#4000BF]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#4000BF" alt="#4000BF" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									<td bgcolor="#4000FF" style="background-color:#4000FF;width: 10px; height: 7px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#4000FF]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#4000FF" alt="#4000FF" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									<td bgcolor="#40FF80" style="background-color:#40FF80;width: 10px; height: 7px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#40FF80]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#40FF80" alt="#40FF80" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									<td bgcolor="#40FFBF" style="background-color:#40FFBF;width: 10px; height: 7px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#40FFBF]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#40FFBF" alt="#40FFBF" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									<td bgcolor="#40FFFF" style="background-color:#40FFFF;width: 10px; height: 7px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#40FFFF]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#40FFFF" alt="#40FFFF" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									</tr>
									<tr>
									<td bgcolor="#800000" style="background-color:#800000;width: 10px; height: 7px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#800000]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#800000" alt="#800000" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									<td bgcolor="#800040" style="background-color:#800040;width: 10px; height: 7px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#800040]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#800040" alt="#800040" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									<td bgcolor="#800080" style="background-color:#800080;width: 10px; height: 7px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#800080]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#800080" alt="#800080" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									<td bgcolor="#8000BF" style="background-color:#8000BF;width: 10px; height: 7px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#8000BF]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#8000BF" alt="#8000BF" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									<td bgcolor="#8000FF" style="background-color:#8000FF;width: 10px; height: 7px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#8000FF]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#8000FF" alt="#8000FF" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									<td bgcolor="#80FF80" style="background-color:#80FF80;width: 10px; height: 7px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#80FF80]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#80FF80" alt="#80FF80" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									<td bgcolor="#80FFBF" style="background-color:#80FFBF;width: 10px; height: 7px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#80FFBF]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#80FFBF" alt="#80FFBF" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									<td bgcolor="#80FFFF" style="background-color:#80FFFF;width: 10px; height: 7px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#80FFFF]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#80FFFF" alt="#80FFFF" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									</tr>
									<tr>
									<td bgcolor="#BF0000" style="background-color:#BF0000;width: 10px; height: 7px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#BF0000]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#BF0000" alt="#BF0000" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									<td bgcolor="#BF0040" style="background-color:#BF0040;width: 10px; height: 7px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#BF0040]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#BF0040" alt="#BF0040" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									<td bgcolor="#BF0080" style="background-color:#BF0080;width: 10px; height: 7px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#BF0080]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#BF0080" alt="#BF0080" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									<td bgcolor="#BF00BF" style="background-color:#BF00BF;width: 10px; height: 7px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#BF00BF]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#BF00BF" alt="#BF00BF" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									<td bgcolor="#BF00FF" style="background-color:#BF00FF;width: 10px; height: 7px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#BF00FF]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#BF00FF" alt="#BF00FF" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									<td bgcolor="#BFFF80" style="background-color:#BFFF80;width: 10px; height: 7px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#BFFF80]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#BFFF80" alt="#BFFF80" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									<td bgcolor="#BFFFBF" style="background-color:#BFFFBF;width: 10px; height: 7px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#BFFFBF]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#BFFFBF" alt="#BFFFBF" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									<td bgcolor="#BFFFFF" style="background-color:#BFFFFF;width: 10px; height: 7px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#BFFFFF]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#BFFFFF" alt="#BFFFFF" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									</tr>
									<tr>
									<td bgcolor="#FF0000" style="background-color:#FF0000;width: 10px; height: 7px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#FF0000]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#FF0000" alt="#FF0000" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									<td bgcolor="#FF0040" style="background-color:#FF0040;width: 10px; height: 7px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#FF0040]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#FF0040" alt="#FF0040" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									<td bgcolor="#FF0080" style="background-color:#FF0080;width: 10px; height: 7px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#FF0080]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#FF0080" alt="#FF0080" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									<td bgcolor="#FF00BF" style="background-color:#FF00BF;width: 10px; height: 7px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#FF00BF]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#FF00BF" alt="#FF00BF" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									<td bgcolor="#FF00FF" style="background-color:#FF00FF;width: 10px; height: 7px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#FF00FF]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#FF00FF" alt="#FF00FF" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									<td bgcolor="#FFFF80" style="background-color:#FFFF80;width: 10px; height: 7px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#FFFF80]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#FFFF80" alt="#FFFF80" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									<td bgcolor="#FFFFBF" style="background-color:#FFFFBF;width: 10px; height: 7px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#FFFFBF]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#FFFFBF" alt="#FFFFBF" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									<td bgcolor="#FFFFFF" style="background-color:#FFFFFF;width: 10px; height: 7px;"><a style="display:inline; padding:5px;" onclick="bbfontstyle('[color=#FFFFFF]', '[/color]'); return false;" href="#"><img width="10" height="7" title="#FFFFFF" alt="#FFFFFF" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/spacer.gif"></a></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					
					<?php if((bool)$fparams->get('enable_smilies', 1) === true): ?>
					<div class="btn-group">
						<button type="button" class="btn btn-default btn-sm dropdown-toggle gcoreTooltip" title="<?php echo l_('CHRONOFORUMS_INSERT_SMILIES'); ?>" data-g-toggle="dropdown">
						<img width="15" height="17" title="Smile" alt=":)" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_smile.gif">
						</button>
						<div class="dropdown-menu gdropdown" role="menu" style="max-width:200px; padding:5px;">
							<a class="btn btn-sm" style="display:inline; white-space:normal; padding:5px;" onclick="insert_text(':D', true); return false;" href="#"><img width="15" height="17" title="Very Happy" alt=":D" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_biggrin.gif"></a>
							<a class="btn btn-sm" style="display:inline; white-space:normal; padding:5px;" onclick="insert_text(':)', true); return false;" href="#"><img width="15" height="17" title="Smile" alt=":)" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_smile.gif"></a>
							<a class="btn btn-sm" style="display:inline; white-space:normal; padding:5px;" onclick="insert_text(';)', true); return false;" href="#"><img width="15" height="17" title="Wink" alt=";)" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_wink.gif"></a>
							<a class="btn btn-sm" style="display:inline; white-space:normal; padding:5px;" onclick="insert_text(':(', true); return false;" href="#"><img width="15" height="17" title="Sad" alt=":(" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_sad.gif"></a>
							<a class="btn btn-sm" style="display:inline; white-space:normal; padding:5px;" onclick="insert_text(':o', true); return false;" href="#"><img width="15" height="17" title="Surprised" alt=":o" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_surprised.gif"></a>
							<a class="btn btn-sm" style="display:inline; white-space:normal; padding:5px;" onclick="insert_text(':shock:', true); return false;" href="#"><img width="15" height="17" title="Shocked" alt=":shock:" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_eek.gif"></a>
							<a class="btn btn-sm" style="display:inline; white-space:normal; padding:5px;" onclick="insert_text(':?', true); return false;" href="#"><img width="15" height="17" title="Confused" alt=":?" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_confused.gif"></a>
							<a class="btn btn-sm" style="display:inline; white-space:normal; padding:5px;" onclick="insert_text('8-)', true); return false;" href="#"><img width="15" height="17" title="Cool" alt="8-)" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_cool.gif"></a>
							<a class="btn btn-sm" style="display:inline; white-space:normal; padding:5px;" onclick="insert_text(':lol:', true); return false;" href="#"><img width="15" height="17" title="Laughing" alt=":lol:" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_lol.gif"></a>
							<a class="btn btn-sm" style="display:inline; white-space:normal; padding:5px;" onclick="insert_text(':x', true); return false;" href="#"><img width="15" height="17" title="Mad" alt=":x" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_mad.gif"></a>
							<a class="btn btn-sm" style="display:inline; white-space:normal; padding:5px;" onclick="insert_text(':P', true); return false;" href="#"><img width="15" height="17" title="Razz" alt=":P" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_razz.gif"></a>
							<a class="btn btn-sm" style="display:inline; white-space:normal; padding:5px;" onclick="insert_text(':oops:', true); return false;" href="#"><img width="15" height="17" title="Embarrassed" alt=":oops:" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_redface.gif"></a>
							<a class="btn btn-sm" style="display:inline; white-space:normal; padding:5px;" onclick="insert_text(':cry:', true); return false;" href="#"><img width="15" height="17" title="Crying or Very Sad" alt=":cry:" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_cry.gif"></a>
							<a class="btn btn-sm" style="display:inline; white-space:normal; padding:5px;" onclick="insert_text(':evil:', true); return false;" href="#"><img width="15" height="17" title="Evil or Very Mad" alt=":evil:" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_evil.gif"></a>
							<a class="btn btn-sm" style="display:inline; white-space:normal; padding:5px;" onclick="insert_text(':twisted:', true); return false;" href="#"><img width="15" height="17" title="Twisted Evil" alt=":twisted:" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_twisted.gif"></a>
							<a class="btn btn-sm" style="display:inline; white-space:normal; padding:5px;" onclick="insert_text(':roll:', true); return false;" href="#"><img width="15" height="17" title="Rolling Eyes" alt=":roll:" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_rolleyes.gif"></a>
							<a class="btn btn-sm" style="display:inline; white-space:normal; padding:5px;" onclick="insert_text(':!:', true); return false;" href="#"><img width="15" height="17" title="Exclamation" alt=":!:" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_exclaim.gif"></a>
							<a class="btn btn-sm" style="display:inline; white-space:normal; padding:5px;" onclick="insert_text(':?:', true); return false;" href="#"><img width="15" height="17" title="Question" alt=":?:" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_question.gif"></a>
							<a class="btn btn-sm" style="display:inline; white-space:normal; padding:5px;" onclick="insert_text(':idea:', true); return false;" href="#"><img width="15" height="17" title="Idea" alt=":idea:" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_idea.gif"></a>
							<a class="btn btn-sm" style="display:inline; white-space:normal; padding:5px;" onclick="insert_text(':arrow:', true); return false;" href="#"><img width="15" height="17" title="Arrow" alt=":arrow:" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_arrow.gif"></a>
							<a class="btn btn-sm" style="display:inline; white-space:normal; padding:5px;" onclick="insert_text(':|', true); return false;" href="#"><img width="15" height="17" title="Neutral" alt=":|" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_neutral.gif"></a>
							<a class="btn btn-sm" style="display:inline; white-space:normal; padding:5px;" onclick="insert_text(':mrgreen:', true); return false;" href="#"><img width="15" height="17" title="Mr. Green" alt=":mrgreen:" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_mrgreen.gif"></a>
							<a class="btn btn-sm" style="display:inline; white-space:normal; padding:5px;" onclick="insert_text(':geek:', true); return false;" href="#"><img width="17" height="17" title="Geek" alt=":geek:" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_e_geek.gif"></a>
							<a class="btn btn-sm" style="display:inline; white-space:normal; padding:5px;" onclick="insert_text(':ugeek:', true); return false;" href="#"><img width="17" height="18" title="Uber Geek" alt=":ugeek:" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_e_ugeek.gif"></a>
							
						</div>
					</div>
					<?php endif; ?>
					
					<?php if($fparams->get('enable_private_data', 0)): ?>
					<a title="<?php echo l_('CHRONOFORUMS_PRIVATE'); ?>: [private]data here[/private]" onclick="bbstyle(22); return false;" name="addbbcode22" class="btn btn-default btn-sm gcoreTooltip"><i class="fa fa-lock fa-fw fa-lg"></i>&nbsp;<i class="fa fa-eye-slash fa-fw fa-lg"></i></a>
					<?php endif; ?>
					
					<!--<a title="<?php echo l_('CHRONOFORUMS_FONT_COLOR'); ?>: [color=red]text[/color]  Tip: you can also use color=#FF0000" onclick="change_palette(); return false;" name="bbpalette" id="bbpalette" class="btn btn-warning btn-sm"><i class="fa fa-th fa-fw fa-lg"></i></a>-->
				</div>
				
				<div class="panel-body">
					<div id="cfu-message">
						<textarea class="form-control" onfocus="initInsertions();" onkeyup="storeCaret(this);" onclick="storeCaret(this);" onselect="storeCaret(this);" tabindex="4" cols="76" rows="<?php echo $message_rows; ?>" id="post-text" name="<?php echo $message_name; ?>"></textarea>
					</div>
				</div>
			</div>
		<?php endif; ?>
		
	<?php
	}
}