<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$doc = \GCore\Libs\Document::getInstance();
	$doc->_('jquery');
	$doc->_('editor');
	$doc->__('editor', '#description');
	
	$this->Toolbar->addButton('apply', r_('index.php?ext=chronoforums&cont=forums&act=save&save_act=apply'), l_('APPLY'), $this->Assets->image('apply', 'toolbar/'));
	$this->Toolbar->addButton('save', r_('index.php?ext=chronoforums&cont=forums&act=save'), l_('SAVE'), $this->Assets->image('save', 'toolbar/'));
	$this->Toolbar->addButton('cancel', r_('index.php?ext=chronoforums&cont=forums'), l_('CANCEL'), $this->Assets->image('cancel', 'toolbar/'), 'link');
?>
<div class="chrono-page-container">
<div class="container" style="width:100%;">
	<div class="row" style="margin-top:20px;">
		<div class="col-md-6">
			<h3><?php echo l_('FORUMS_MANAGER'); ?></h3>
		</div>
		<div class="col-md-6 pull-right text-right">
			<?php
				echo $this->Toolbar->renderBar();
			?>
		</div>
	</div>
	<div class="row">
	<div class="panel panel-default">
		<div class="panel-body">
			<form action="<?php echo r_('index.php?ext=chronoforums&cont=forums&act=save'); ?>" method="post" name="admin_form" id="admin_form">
				<div id="details-panel">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#general" data-g-toggle="tab"><?php echo l_('GENERAL'); ?></a></li>
						<li><a href="#permissions" data-g-toggle="tab"><?php echo l_('PERMISSIONS'); ?></a></li>
					</ul>
					<div class="tab-content">
						<div id="general" class="tab-pane active">
							<?php echo $this->Html->formStart(); ?>
							<?php echo $this->Html->formSecStart(); ?>
							<?php echo $this->Html->formLine('Forum[title]', array('type' => 'text', 'label' => l_('TITLE'), 'class' => 'L')); ?>
							<?php echo $this->Html->formLine('Forum[alias]', array('type' => 'text', 'label' => l_('ALIAS'), 'class' => 'L')); ?>
							<?php echo $this->Html->formLine('Forum[cat_id]', array('type' => 'dropdown', 'label' => l_('CATEGORY'), 'options' => $categories)); ?>
							<?php echo $this->Html->formLine('Forum[description]', array('type' => 'textarea', 'id' => 'description', 'label' => l_('DESCRIPTION'), 'class' => 'XL')); ?>
							<?php echo $this->Html->formLine('Forum[ordering]', array('type' => 'text', 'label' => l_('POSITION'))); ?>
							<?php echo $this->Html->formLine('Forum[published]', array('type' => 'dropdown', 'label' => l_('PUBLISHED'), 'values' => 1, 'options' => array(0 => l_('NO'), 1 => l_('YES')))); ?>
							<?php echo $this->Html->formLine('Forum[params][icon]', array('type' => 'radio', 'label' => array('text' => l_('FORUM_ICON'), 'position' => 'top'), 'horizontal' => true, 'value' => 'forum_read.gif', 'options' => $forums_icons)); ?>
							<?php echo $this->Html->formSecEnd(); ?>
							<?php echo $this->Html->formEnd(); ?>
						</div>
						<div id="permissions" class="tab-pane">
							<?php echo $this->Html->formSecStart(); ?>
							<?php echo $this->Html->formLine('Forum[params][enable_permissions]', array('type' => 'dropdown', 'label' => l_('ENABLE_PERMISSIONS'), 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('ENABLE_PERMISSIONS_DESC'))); ?>
							<?php echo $this->Html->formSecEnd(); ?>
							<div class="container" style="width:100%; margin-top:20px;">
								<div class="row">
									<div class="col-md-4">
										<ul class="nav nav-pills nav-stacked" id="">
										<?php $counter = 0; ?>
										<?php foreach($perms as $action => $label): ?>
											<li class="<?php echo ($counter == 0) ? 'active':''; ?>"><a href="#permissions-<?php echo $action; ?>" data-g-toggle="tab"><strong><?php echo $label; ?></strong></a></li>
										<?php $counter++; ?>
										<?php endforeach; ?>
										</ul>
									</div>
									<div class="col-md-8">
										<div class="tab-content" id="">
										<?php $counter = 0; ?>
										<?php foreach($perms as $action => $label): ?>
											<div id="permissions-<?php echo $action; ?>" class="tab-pane <?php echo ($counter == 0) ? 'active':''; ?>">
												<div class="panel panel-info">
													<div class="panel-heading"><strong><?php echo $label; ?></strong></div>
													<div class="panel-body">
														<?php foreach($rules as $g_id => $g_name): ?>
															<?php echo $this->Html->formSecStart(); ?>
																<?php echo $this->Html->formLine('Forum[rules]['.$action.']['.$g_id.']', array('type' => 'dropdown', 'label' => $g_name, 'class' => 'M', 'options' => array(0 => l_('INHERITED'), '' => l_('NOT_SET'), 1 => l_('ALLOWED'), -1 => l_('DENIED')))); ?>
															<?php echo $this->Html->formSecEnd(); ?>
														<?php endforeach; ?>
													</div>
												</div>
											</div>
										<?php $counter++; ?>
										<?php endforeach; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php echo $this->Html->input('Forum[id]', array('type' => 'hidden')); ?>
			</form>
		</div>
	</div>
	</div>
</div>
</div>