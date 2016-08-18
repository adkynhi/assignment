<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$doc = \GCore\Libs\Document::getInstance();
	$doc->_('gcompleter');
	/*
	$doc->_('select2');
	$doc->addJsCode('jQuery(document).ready(function($){ $("#recipients").select2(
		{
			placeholder: "Search for a user",
			minimumInputLength: 3,
			width: "element",
			//multiple: true,
			//tags: true,
			//tokenSeparators: [","," "],
			ajax:{
				url: "'.r_('index.php?ext=chronoforums&cont=messages&act=username_lookup&tvout=ajax').'",
				dataType: "json",
				data: function (term, page){
					return {
						username_q: term,
					};
				},
				results: function (data, page){
					return {results: data};
				}
			}'.(!empty($username) ? ',
			initSelection: function(element, callback){
				var uid = $(element).val();
				var data = {"id": $(element).val(), "text": "'.$username.'"};
				callback(data);
			},' : '').'
		}
	); });');
	*/
	$doc->addJsCode('
		jQuery(document).ready(function($){
			$("#recipients2").gcompleter({
				placeholder: "'.l_('CHRONOFORUMS_SEARCH_FOR_USER').'",
				label: "'.l_('CHRONOFORUMS_ENTER_X_CHARS').'",
				minimumInputLength: 3,
				ajax:{
					url: "'.r_('index.php?ext=chronoforums&cont=messages&act=username_lookup&tvout=ajax').'",
					term: "username_q",
				}
			});
		});
	');
	
	$doc->addJsCode('
		function preview_quick_reply(){
			jQuery.ajax({
				"type" : "POST",
				"url" : "'.r_('index.php?ext=chronoforums&cont=messages&tvout=ajax&act=bbcode_preview').'",
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
	');
?>
<div class="chronoforums messages compose">
	<div class="container">
		<div class="row cfu-header">
			<?php echo $this->Elements->header(); ?>
		</div>
		<div class="row">
			<h3><?php echo l_('CHRONOFORUMS_PRIVATE_MESSAGING'); ?> - <?php echo l_('CHRONOFORUMS_COMPOSE'); ?></h3>
		</div>
		<div class="row cfu-editor">
			<div class="panel panel-default">
				<div class="panel-heading cfu-messages-nav">
					<ul class="nav nav-tabs">
						<li><a href="<?php echo r_('index.php?ext=chronoforums&cont=messages&act=inbox'); ?>"><?php echo l_('CHRONOFORUMS_INBOX'); ?></a></li>
						<li><a href="<?php echo r_('index.php?ext=chronoforums&cont=messages&act=outbox'); ?>"><?php echo l_('CHRONOFORUMS_OUTBOX'); ?></a></li>
						<li class="active pull-right"><a class="gcoreTooltip" title="<?php echo l_('CHRONOFORUMS_COMPOSE_DESC'); ?>" href="<?php echo r_("index.php?ext=chronoforums&cont=messages&act=compose"); ?>"><?php echo l_('CHRONOFORUMS_COMPOSE'); ?></a></li>
					</ul>
				</div>
				<div class="panel-body">
					<form action="<?php echo r_('index.php?ext=chronoforums&cont=messages&act=compose'); ?>" method="post" name="postform" enctype="multipart/form-data" id="postform" class="panel">
						<div class="container">
							<div class="row cfu-preview">
								<div id="quick_reply_preview" class="well" style="display:none;"></div>
							</div>
							<?php echo $this->Html->input('d', array('type' => 'hidden', 'value' => \GCore\Libs\Request::data('d'))); ?>
							<?php echo $this->Html->input('m', array('type' => 'hidden', 'value' => \GCore\Libs\Request::data('m'))); ?>
							<div class="row cfu-recipient">
								<?php echo $this->Html->formSecStart(); ?>
								<?php //echo $this->Html->formLine('u', array('type' => 'hidden', 'label' => l_('CHRONOFORUMS_RECIPIENTS'), 'id' => 'recipients', 'class' => 'M')); ?>
								<?php echo $this->Html->formLine('u', array('type' => 'dropdown', 'label' => l_('CHRONOFORUMS_RECIPIENTS'), 'id' => 'recipients2', 'class' => 'M', 'options' => !empty($this->data['u']) ? array($this->data['u'] => $username) : array())); ?>
								<?php echo $this->Html->formSecEnd(); ?>
							</div>
							<div class="row cfu-subject">
								<?php echo $this->Html->formSecStart(); ?>
								<?php echo $this->Html->formLine('Message[subject]', array('type' => 'text', 'label' => l_('CHRONOFORUMS_SUBJECT'), 'class' => 'XL form-control')); ?>
								<?php echo $this->Html->formSecEnd(); ?>
							</div>
							<div class="row cfu-message">
								<?php $this->Bbeditor->editor('Message[text]'); ?>
							</div>
							<div class="row cfu-submit">
								<?php echo $this->Html->input('buttons', array('type' => 'multi', 'layout' => 'wide',
									'inputs' => array(
										array('type' => 'submit', 'name' => 'cancel_post', 'value' => l_('CHRONOFORUMS_CANCEL'), 'class' => 'btn btn-danger'),
										array('type' => 'button', 'name' => 'preview', 'value' => l_('CHRONOFORUMS_PREVIEW'), 'class' => 'btn btn-info', 'onclick' => 'preview_quick_reply();'),
										array('type' => 'submit', 'name' => 'submit', 'value' => l_('CHRONOFORUMS_SUBMIT'), 'class' => 'btn btn-success'),
									)
								)); ?>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="row cfu-preview">
			<?php if(!empty($d_messages)): ?>
				<?php foreach($d_messages as $d_message): ?>
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="col-lg-7 pull-left cfu-post-subject">
								<strong><?php echo $d_message['Message']['subject']; ?></strong>
							</div>
							<div class="col-lg-5 pull-right cfu-post-info">
								<span class="pull-right">
									<i class="fa fa-fw fa-calendar"></i>
									<small class="cfu-time"><?php echo $this->Output->date_time($d_message['Message']['created']); ?></small>
								</span>
								<small class="cfu-user-info pull-right">
									<i class="fa fa-lg- fa-user"></i><?php echo $this->UserTasks->username(array('User' => $d_message['MessageUser'], 'Profile' => $d_message['MessageUserProfile']), false); ?>
								</small>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="panel-body">
							<?php echo $this->Bbcode->parse($d_message['Message']['text']); ?>
						</div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
		<div class="row cfu-footer">
			<?php echo $this->Elements->footer(); ?>
		</div>
	</div>
</div>