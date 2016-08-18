<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="gbs3">
<div class="chronoforums profiles mini">
	<div class="cfu-profile">
	<?php /*
		<table>
			<tr>
				<td class="cfu-avatar">
					<?php if((bool)$fparams->get('show_post_author_avatar', 1) AND !empty($user['Profile']['params']['avatar'])): ?>
						<?php echo $this->UserTasks->avatar(array('User' => $user['User'], 'Profile' => $user['Profile'])); ?>
					<?php endif; ?>
					<h5 class="text-center"><?php echo $this->UserTasks->username(array('User' => $user['User'], 'Profile' => $user['Profile']), false); ?></h5>
				</td>
				<td class="cfu-info">
					<div class="text-center">
					<?php if($fparams->get('load_ranks', 0)): ?>
					<div class="cfu-ranks">
						<?php echo $this->UserTasks->display_ranks(array('User' => $user['User'], 'Profile' => $user['Profile'])); ?>
					</div>
					<?php endif; ?>
					</div>
					<?php if((bool)$fparams->get('show_author_posts_count', 1)): ?>
					<small class="cfu-posts"><span class="btn btn-xs gcoreTooltip" title="<?php echo l_('CHRONOFORUMS_POSTS'); ?>"><i class="fa fa-fw fa-lg fa-comments"></i></span> <?php echo $this->UserTasks->post_count(array('User' => $user['User'], 'Profile' => $user['Profile'])); ?></small>
					<br>
					<?php endif; ?>
					<?php if((bool)$fparams->get('show_author_join_date', 1)): ?>
					<small class="cfu-join"><span class="btn btn-xs gcoreTooltip" title="<?php echo l_('CHRONOFORUMS_JOINED'); ?>"><i class="fa fa-fw fa-lg fa-credit-card"></i></span> <?php echo $this->UserTasks->join_date(array('User' => $user['User'], 'Profile' => $user['Profile'])); ?></small>
					<?php endif; ?>
				</td>
			</tr>
		</table>
	*/ ?>
	<div class="panel panel-default" style="margin:0; width:330px;">
		<div class="panel-body" style="padding:3px !important;">
			<div class="col-sm-7" style="padding:5px !important;">
				<h5 class="text-center"><?php echo $this->UserTasks->username(array('User' => $user['User'], 'Profile' => $user['Profile']), false); ?></h5>
				<div class="text-center">
					<?php if($fparams->get('load_ranks', 0)): ?>
					<div class="cfu-ranks">
						<?php echo $this->UserTasks->display_ranks(array('User' => $user['User'], 'Profile' => $user['Profile'])); ?>
					</div>
					<?php endif; ?>
				</div>
				<?php if((bool)$fparams->get('show_author_posts_count', 1)): ?>
				<small class="cfu-posts"><span class="btn btn-xs gcoreTooltip" title="<?php echo l_('CHRONOFORUMS_POSTS'); ?>"><i class="fa fa-fw fa-lg fa-comments"></i></span> <?php echo $this->UserTasks->post_count(array('User' => $user['User'], 'Profile' => $user['Profile'])); ?></small>
				<br>
				<?php endif; ?>
				<?php if((bool)$fparams->get('show_author_join_date', 1)): ?>
				<small class="cfu-join"><span class="btn btn-xs gcoreTooltip" title="<?php echo l_('CHRONOFORUMS_JOINED'); ?>"><i class="fa fa-fw fa-lg fa-credit-card"></i></span> <?php echo $this->UserTasks->join_date(array('User' => $user['User'], 'Profile' => $user['Profile'])); ?></small>
				<?php endif; ?>
			</div>
			<div class="col-sm-5" style="padding:5px !important;">
				<?php if((bool)$fparams->get('show_post_author_avatar', 1) AND !empty($user['Profile']['params']['avatar'])): ?>
					<?php echo $this->UserTasks->avatar(array('User' => $user['User'], 'Profile' => $user['Profile'])); ?>
				<?php endif; ?>
			</div>
		</div>
		<div class="panel-footer" style="padding:3px !important;">
			<span class="text-right">
				<?php if($fparams->get('enable_pm', 1)): ?>
					<a class="btn btn-default btn-xs gcoreTooltip" title="<?php echo l_('CHRONOFORUMS_SEND_PRIVATE_MESSAGING'); ?>" href="<?php echo r_("index.php?ext=chronoforums&cont=messages&act=compose&u=".$user['User']['id']); ?>"><i class="fa fa-envelope fa-lg fa-fw"></i><?php echo l_('CHRONOFORUMS_PM'); ?></a>
				<?php endif; ?>
			</span>
			<?php if($this->UserTasks->is_online($user['User']['id'])): ?>
				<span class="label label-success"><i class="fa fa-laptop fa-lg"></i>&nbsp;<?php echo l_('CHRONOFORUMS_ONLINE'); ?></span>
			<?php endif; ?>
		</div>
	</div>
	</div>
</div>
</div>