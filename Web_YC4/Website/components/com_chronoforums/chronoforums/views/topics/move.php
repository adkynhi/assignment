<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$doc = \GCore\Libs\Document::getInstance();
	$extra_info = '';
?>
<div class="chronoforums topics move">
	<div class="container">
		<div class="row cfu-header">
			<?php echo $this->Elements->header(); ?>
		</div>
		<div class="row cfu-body">
			<h3><?php echo l_('CHRONOFORUMS_MOVE_TOPIC_HEADER'); ?></h3>
			<p><?php echo l_('CHRONOFORUMS_MOVE_TOPIC_INFO'); ?></p>
			<form action="<?php echo r_('index.php?ext=chronoforums&cont=topics&act=move'); ?>" method="post" name="postform" enctype="multipart/form-data" id="postform" class="panel">
				<div class="container">
					<ul class="list-group">
					<?php
						if(!empty($topics)){
							foreach($topics as $topic):
							?>
								<li class="list-group-item">
									<h4><a href="<?php echo r_('index.php?ext=chronoforums&cont=posts&t='.$topic['Topic']['id']); ?>"><?php echo $topic['Topic']['title']; ?></a></h4>
								</li>
							<?php
							endforeach;
						}
					?>
					</ul>
					<div class="row cfu-forum-select">
						<?php echo $this->Html->formSecStart(); ?>
						<?php echo $this->Html->formLine('f',array('type' => 'dropdown', 'label' => l_('CHRONOFORUMS_FORUM'), 'options' => $forums_list)); ?>
						<?php echo $this->Html->formSecEnd(); ?>
						
						<?php echo $this->Html->input('t', array('type' => 'hidden', 'value' => $tid)); ?>
						<?php
							foreach($tids as $t){
								echo $this->Html->input('topics_ids['.$t.']', array('type' => 'hidden', 'value' => 1));
							}
						?>
					</div>
					<div class="row">
						<?php echo $this->Html->input('buttons', array('type' => 'multi', 'layout' => 'wide',
							'inputs' => array(
								array('type' => 'submit', 'name' => 'cancel_move_topic', 'value' => l_('CHRONOFORUMS_CANCEL'), 'class' => 'btn btn-danger'),
								array('type' => 'submit', 'name' => 'confirm_move_topic', 'value' => l_('CHRONOFORUMS_CONFIRM'), 'class' => 'btn btn-primary')
							)
						)); ?>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>