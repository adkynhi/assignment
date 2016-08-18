<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$my = \GCore\Libs\Base::getUser();
?>
<div class="chronoforums profiles index">
	<div class="container">
		<div class="row cfu-header">
			<?php echo $this->Elements->header(); ?>
		</div>
		<div class="row cfu-data">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="pull-left cfu-title"><?php echo sprintf(l_('CHRONOFORUMS_PROFILE_TITLE'), $user['User'][$fparams->get('display_name', 'username')]); ?></h3>
					<?php if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'modify_topics') AND (bool)$fparams->get('allow_author_delete', 1) === true AND $my['id'] != $user['User']['id']): ?>
						<span class="pull-right">
						<a title="<?php echo l_('CHRONOFORUMS_DELETE_AUTHOR'); ?>" class="btn btn-sm gcoreTooltip text-danger btn-danger" href="<?php echo r_("index.php?ext=chronoforums&cont=topics&act=delete_author&u=".$user['User']['id']."&f=0&t=0"); ?>"><i class="fa fa fa-trash-o fa-lg text-default"></i></a>
						</span>
					<?php endif; ?>
					<div class="clearfix"></div>
				</div>
				<div class="panel-body">
					<?php if(!empty($user['Profile']['params']['avatar'])): ?>
					<div class="cfu-avatar pull-right">
						<?php echo $this->Html->image(r_('index.php?ext=chronoforums&cont=profiles&act=avatar&img='.$user['Profile']['params']['avatar']), array('class' => 'img-rounded')); ?>
					</div>
					<?php endif; ?>
					<div class="cfu-details pull-left">
						<dl class="dl-horizontal">
							<dt><?php echo l_('CHRONOFORUMS_POSTS'); ?></dt>
							<dd><?php echo $user['Profile']['post_count']; ?></dd>
							<dt><?php echo l_('CHRONOFORUMS_TOPICS'); ?></dt>
							<dd><?php echo $user['Profile']['topic_count']; ?></dd>
							<?php if(!empty($user['Profile']['params']['location'])): ?>
								<dt><?php echo l_('CHRONOFORUMS_LOCATION'); ?></dt>
								<dd><?php echo htmlspecialchars($user['Profile']['params']['location']); ?></dd>
							<?php endif; ?>
							<?php if(!empty($user['Profile']['params']['website'])): ?>
								<dt><?php echo l_('CHRONOFORUMS_WEBSITE'); ?></dt>
								<dd><?php echo htmlspecialchars($user['Profile']['params']['website']); ?></dd>
							<?php endif; ?>
							<?php if(!empty($user['Profile']['params']['about'])): ?>
								<dt><?php echo l_('CHRONOFORUMS_ABOUT'); ?></dt>
								<dd><?php echo htmlspecialchars($user['Profile']['params']['about']); ?></dd>
							<?php endif; ?>
						</dl>
					</div>
				</div>
				<?php if(!empty($editable)): ?>
				<div class="panel-footer">
					<div class="row cfu-buttons">
						<a href="<?php echo r_('index.php?ext=chronoforums&cont=profiles&act=edit&u='.$user['User']['id']); ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit fa-lg fa-fw"></i><?php echo l_('CHRONOFORUMS_EDIT_PROFILE'); ?></a>
					</div>
				</div>
				<?php endif; ?>
			</div>
		</div>
		<div class="row cfu-footer">
			<?php echo $this->Elements->footer(); ?>
		</div>
	</div>
</div>