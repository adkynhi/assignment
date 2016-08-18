<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$doc = \GCore\Libs\Document::getInstance();
	$extra_info = '';
?>
<div class="chronoforums topics edit">
	<div class="container">
		<div class="row cfu-header">
			<?php echo $this->Elements->header(); ?>
		</div>
		<div class="row cfu-body">
			<h3><?php echo l_('CHRONOFORUMS_EDIT_TOPIC_HEADER'); ?></h3>
			<p><?php echo l_('CHRONOFORUMS_EDIT_TOPIC_INFO'); ?></p>
			<form action="<?php echo r_('index.php?ext=chronoforums&cont=topics&act=edit&t='.\GCore\Libs\Request::data('t').'&f='.\GCore\Libs\Request::data('f')); ?>" method="post" name="postform" enctype="multipart/form-data" id="postform" class="panel">
				<?php if($fparams->get('enable_extra_topic_info', 0)): ?>
					<?php ob_start(); ?>
					<div class="row cfu-extra-info">
						<?php
						ob_start();
						eval('?>'.$fparams->get('extra_topic_info_code', ''));
						$output = ob_get_clean();
						echo $output;
						?>
					</div>
					<?php $extra_info .= ob_get_clean(); ?>
				<?php endif; ?>
				<?php $this->PostEdit->display($extra_info, false); ?>
			</form>
		</div>
	</div>
</div>