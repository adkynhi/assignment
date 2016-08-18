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
class PostEdit {
	var $view;
	
	function display($extra = '', $editor = true){
		$fparams = $this->view->vars['fparams'];
		//$preview = isset($this->view->vars['preview']) ? $this->view->vars['preview'] : false;
		$editor_attachments = isset($this->view->vars['editor_attachments']) ? $this->view->vars['editor_attachments'] : true;
		
		$doc = \GCore\Libs\Document::getInstance();
		$doc->_('jquery');
		$doc->_('guploader');
		$doc->addJsCode('
			function preview_quick_reply(){
				jQuery.ajax({
					"type" : "POST",
					"url" : "'.r_('index.php?ext=chronoforums&cont=posts&tvout=ajax&act=bbcode_preview').'",
					"data" : jQuery("#postform").serialize(),
					beforeSend: function(){
						jQuery("#quick_reply_preview").empty();
						jQuery("#quick_reply_preview").append("<img src=\"'.\GCore\Helpers\Assets::image('loading.gif').'\" border=\"0\" />");
						jQuery("#quick_reply_preview").css("display", "block");
					},
					"success" : function(res){
						jQuery("#quick_reply_preview").empty();
						jQuery("#quick_reply_preview").append(res);
					},
				});
			}
			/*jQuery(document).ready(function($){
				$(".file_upload").guploader({
					"url" : $(".file_upload").closest("form").attr("action"),
					"data" : {"upload" : 1, "Post" : 1, "tvout" : "ajax"},
				});
				$(".file_upload").on("beforeSend.guploader", function(){
					$("#submit-post").prop("disabled", true);
				});
				$(".file_upload").on("success.guploader", function(e, res){
					$("#cfu-attachments").html(res);
					$("#submit-post").prop("disabled", false);
				});
			});*/
		');
		?>
			<div class="cfu-post-edit">
				<div class="container">
					<div class="row cfu-preview">
						<div id="quick_reply_preview" class="well" style="display:none;"></div>
					</div>
					<div class="row">
						<div class="container">
							<?php echo $this->view->Html->input('f', array('type' => 'hidden', 'value' => \GCore\Libs\Request::data('f'))); ?>
							<?php echo $this->view->Html->input('t', array('type' => 'hidden', 'value' => \GCore\Libs\Request::data('t'))); ?>
							<?php echo $this->view->Html->input('p', array('type' => 'hidden', 'value' => \GCore\Libs\Request::data('p'))); ?>
							<div class="row cfu-subject">
								<?php echo $this->view->Html->formSecStart(); ?>
								<?php echo $this->view->Html->formLine('Post[subject]', array('type' => 'text', 'label' => l_('CHRONOFORUMS_SUBJECT'), 'class' => 'XL form-control')); ?>
								<?php echo $this->view->Html->formSecEnd(); ?>
							</div>
							<?php if($extra): ?>
							<?php echo $extra; ?>
							<?php endif; ?>
							
							<?php if($editor): ?>
							<div class="row cfu-message">
								<?php $this->view->Bbeditor->editor('Post[text]', $fparams->get('reply_textarea_rows', 10)); ?>
							</div>
							<?php endif; ?>
							
							<?php
								if((bool)$fparams->get('attach_files', 1) === true){
									if(!empty($this->view->data['Attachment'])){
										foreach($this->view->data['Attachment'] as $k => $attachment){
										?>
										<div class="cfu-attachment">
											<div class="col-md-6">
												<?php echo $this->view->Html->formLine('Attachment['.$k.'][comment]', array('type' => 'textarea', 'placeholder' => l_('CHRONOFORUMS_FILE_COMMENT'), 'sublabel' => $attachment['filename'], 'rows' => 2, 'cols' => 50)); ?>
											</div>
											<div class="col-md-6">
												<?php if(!isset($external_editor)): ?>
												<button type="button" class="btn btn-default gcoreTooltip" onclick="attach_inline(<?php echo $k; ?>, '<?php echo $attachment['filename']; ?>');" title="<?php echo l_('CHRONOFORUMS_PLACE_INLINE'); ?>"><i class="fa fa-pencil-square-o fa-lg"></i></button>
												<?php endif; ?>
												<button type="submit" class="btn btn-danger gcoreTooltip" name="delete_file[<?php echo $k; ?>]" title="<?php echo l_('CHRONOFORUMS_DELETE_FILE'); ?>"><i class="fa fa-trash-o fa-lg"></i></button>
												<input type="hidden" name="Attachment[<?php echo $k; ?>][filename]" value="" />
												<input type="hidden" name="Attachment[<?php echo $k; ?>][vfilename]" value="" />
												<input type="hidden" name="Attachment[<?php echo $k; ?>][size]" value="" />
												<input type="hidden" name="Attachment[<?php echo $k; ?>][id]" value="" />
											</div>
										</div>
										<div class="clearfix"></div>
										<?php
										}
									}
								}
							?>
							
							<?php if($editor AND (!isset($editor_attachments) OR $editor_attachments === true)): ?>
								<div class="row cfu-attachments" id="cfu-attachments">
									
								</div>
								<div class="row cfu-upload">
									<?php if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'attach_files') === true): ?>
										<?php echo $this->view->Html->input('photo', array('type' => 'multi', 'label' => l_('CHRONOFORUMS_ATTACH_FILE'), 'layout' => 'wide',
											'inputs' => array(
												array('type' => 'file', 'class' => 'M file_upload', 'name' => 'attach'),
												array('type' => 'submit', 'name' => 'upload', 'value' => l_('CHRONOFORUMS_UPLOAD'), 'style' => 'margin-left:50px;', 'class' => 'btn btn-default')
											)
										)); ?>
									<?php endif; ?>
								</div>
							<?php endif; ?>
							<div class="row cfu-submit text-center">
								<?php 
								$buttons = array();
								$buttons[] = array('type' => 'submit', 'name' => 'cancel_post', 'value' => l_('CHRONOFORUMS_CANCEL'), 'class' => 'btn btn-danger');
								if($editor){
									$buttons[] = array('type' => 'button', 'name' => 'preview', 'value' => l_('CHRONOFORUMS_PREVIEW'), 'class' => 'btn btn-info', 'onclick' => 'preview_quick_reply();');
								}
								$buttons[] = array('type' => 'submit', 'name' => 'submit', 'id' => 'submit-post', 'value' => l_('CHRONOFORUMS_SUBMIT'), 'class' => 'btn btn-success');								
								
								foreach($buttons as $button){
									echo $this->view->Html->input($button['name'], $button);
								}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php
	}
}