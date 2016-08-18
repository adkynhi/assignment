<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$doc = \GCore\Libs\Document::getInstance();
	//$doc->_('forms');
?>
<div class="chronoforums posts reply">
	<div class="container">
		<div class="row cfu-header">
			<?php echo $this->Elements->header(); ?>
		</div>
		<div class="row cfu-body">
			<?php
				$f = \GCore\Libs\Request::data('f');
				$t = \GCore\Libs\Request::data('t');
			?>
			<h3><?php echo l_('CHRONOFORUMS_POST_REPLY_HEADER'); ?></h3>
			<h4><?php $this->TopicTasks->topic_title($topic); ?></h4>
			<form action="<?php echo r_('index.php?ext=chronoforums&cont=posts&act=reply&f='.$f.'&t='.$t); ?>" method="post" name="postform" enctype="multipart/form-data" id="postform" class="panel">
				<?php $this->PostEdit->display(); ?>
				<div class="well well-sm cfu-fields">
					<div class="container">
						<div class="row cfu-subscribe">
							<?php echo $this->Html->formSecStart(); ?>
							<?php echo $this->Html->formLine('subscribe', array('type' => 'checkbox', 'checked' => (bool)$fparams->get('topic_subscribe_enabled', 1), 'value' => 1, 'label' => l_('CHRONOFORUMS_SUBSCRIBE_TOPIC'), 'sublabel' => l_('CHRONOFORUMS_SUBSCRIBE_TOPIC_DESC'))); ?>
							<?php echo $this->Html->formSecEnd(); ?>
						</div>
					</div>
				</div>
				<div class="container" id="reply-topic-preview"></div>
				<?php $this->TopicTasks->topic_preview($topic); ?>
			</form>
		</div>
	</div>
</div>