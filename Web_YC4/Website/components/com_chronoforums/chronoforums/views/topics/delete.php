<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="chronoforums topics delete">
	<div class="container">
		<div class="row cfu-header">
			<?php echo $this->Elements->header(); ?>
		</div>
		<div class="row cfu-body">
			<h3><?php echo l_('CHRONOFORUMS_TOPIC_DELETE_HEADER'); ?></h3>
			<p><?php echo l_('CHRONOFORUMS_TOPIC_DELETE_INFO'); ?></p>
			<form action="<?php echo r_('index.php?ext=chronoforums&cont=topics&act=delete'); ?>" method="post" name="postform" id="postform">
				<ul class="list-group">
				<?php
					if(!empty($topics)){
						foreach($topics as $topic):
						?>
							<li class="list-group-item">
								<a href="<?php echo r_('index.php?ext=chronoforums&cont=posts&t='.$topic['Topic']['id'].'&alias='.$topic['Topic']['alias']); ?>"><?php echo $topic['Topic']['title']; ?></a>
								<?php echo $this->Html->input('topics_ids['.$topic['Topic']['id'].']', array('type' => 'hidden', 'value' => 1)); ?>
							</li>
						<?php
						endforeach;
					}
				?>
				</ul>
				<?php echo $this->Html->formSecStart(); ?>
				<?php echo $this->Html->formLine('buttons', array('type' => 'multi', 'layout' => 'wide',
					'inputs' => array(
						array('type' => 'submit', 'name' => 'cancel_delete', 'value' => l_('CHRONOFORUMS_CANCEL'), 'class' => 'btn btn-primary'),
						array('type' => 'submit', 'name' => 'confirm_delete', 'value' => l_('CHRONOFORUMS_DELETE'), 'class' => 'btn btn-danger')
					)
				)); ?>
				<?php echo $this->Html->formSecEnd(); ?>
			</form>
		</div>
	</div>
</div>