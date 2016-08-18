<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$doc = \GCore\Libs\Document::getInstance();
	//$doc->_('forms');
?>
<div class="chronoforums posts edit">
	<div class="container">
		<div class="row cfu-header">
			<?php echo $this->Elements->header(); ?>
		</div>
		<div class="row cfu-body">
			<?php
				$f = \GCore\Libs\Request::data('f');
				$t = \GCore\Libs\Request::data('t');
				$p = \GCore\Libs\Request::data('p');
			?>
			<h3><?php echo l_('CHRONOFORUMS_POST_EDIT_HEADER'); ?></h3>
			<h4><?php $this->TopicTasks->topic_title($topic); ?></h4>
			<form action="<?php echo r_('index.php?ext=chronoforums&cont=posts&act=edit&f='.$f.'&t='.$t.'&p='.$p); ?>" method="post" name="postform" enctype="multipart/form-data" id="postform" class="panel">
				<?php $this->PostEdit->display(); ?>
			</form>
		</div>
	</div>
</div>