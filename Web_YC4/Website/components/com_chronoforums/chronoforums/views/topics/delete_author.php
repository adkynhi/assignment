<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$doc = \GCore\Libs\Document::getInstance();
	$doc->_('forms');
?>
<div class="chronoforums topics delete_author">
	<div class="container">
		<div class="row cfu-header">
			<?php echo $this->Elements->header(); ?>
		</div>
		<div class="row cfu-body">
			<h3><?php echo l_('CHRONOFORUMS_DELETE_AUTHOR_HEADER'); ?></h3>
			<p class="text-danger"><?php echo l_('CHRONOFORUMS_DELETE_AUTHOR_INFO'); ?></p>
			<form action="<?php echo r_('index.php?ext=chronoforums&cont=topics&act=delete_author&f='.$fid.'&t='.$tid); ?>" method="post" name="postform" enctype="multipart/form-data" id="postform" class="cfu-panel">
				<ul class="list-group">
				<?php
					if(!empty($users)){
						foreach($users as $user):
						?>
							<li class="list-group-item">
								<?php echo $this->UserTasks->username(array('User' => $user['User'], 'Profile' => $user['Profile'])); ?>
								<?php if(isset($user['TopicCounter'][0]['count'])): ?>
									<?php echo ' - '.$user['TopicCounter'][0]['count'].' '.l_('CHRONOFORUMS_TOPICS'); ?>
								<?php endif; ?>
								<?php if(isset($user['PostCounter'][0]['count'])): ?>
									<?php echo ' - '.$user['PostCounter'][0]['count'].' '.l_('CHRONOFORUMS_POSTS'); ?>
								<?php endif; ?>
							</li>
						<?php
							//echo $this->Html->formLine('user', array('type' => 'custom', 'code' => $code));
						endforeach;
					}
				?>
				</ul>
				<?php echo $this->Html->formSecStart(); ?>
				<?php echo $this->Html->input('f', array('type' => 'hidden', 'value' => $fid)); ?>
				<?php echo $this->Html->input('t', array('type' => 'hidden', 'value' => $tid)); ?>
				<?php echo $this->Html->input('u', array('type' => 'hidden', 'value' => $uid)); ?>
				<?php
					foreach($tids as $t){
						echo $this->Html->input('topics_ids['.$t.']', array('type' => 'hidden', 'value' => 1));
					}
				?>
				<?php echo $this->Html->formLine('buttons', array('type' => 'multi', 'layout' => 'wide',
					'inputs' => array(
						array('type' => 'submit', 'name' => 'cancel_delete_author', 'value' => l_('CHRONOFORUMS_CANCEL'), 'class' => 'btn btn-primary'),
						array('type' => 'submit', 'name' => 'confirm_delete_author', 'value' => l_('CHRONOFORUMS_DELETE'), 'class' => 'btn btn-danger delete_button')
					)
				)); ?>
				<?php echo $this->Html->formSecEnd(); ?>
			</form>
		</div>
	</div>
</div>