<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if((bool)$fparams->get('attach_files', 1) === true){
		if(!empty($this->data['Attachment'])){
			foreach($this->data['Attachment'] as $k => $attachment){
			?>
			<div class="cfu-attachment">
				<div class="col-md-6">
					<?php echo $this->Html->formLine('Attachment['.$k.'][comment]', array('type' => 'textarea', 'placeholder' => l_('CHRONOFORUMS_FILE_COMMENT'), 'sublabel' => $attachment['filename'], 'rows' => 2, 'cols' => 50)); ?>
				</div>
				<div class="col-md-6">
					<?php if(!isset($external_editor)): ?>
					<button type="button" class="btn btn-default gcoreTooltip" onclick="attach_inline(<?php echo $k; ?>, '<?php echo $attachment['filename']; ?>');" title="<?php echo l_('CHRONOFORUMS_PLACE_INLINE'); ?>"><i class="fa fa-pencil-square-o fa-lg"></i></button>
					<?php endif; ?>
					<button type="submit" class="btn btn-danger gcoreTooltip" name="delete_file[<?php echo $k; ?>]" title="<?php echo l_('CHRONOFORUMS_DELETE_FILE'); ?>"><i class="fa fa-trash-o fa-lg"></i></button>
					<input type="hidden" name="Attachment[<?php echo $k; ?>][filename]" value="" />
					<input type="hidden" name="Attachment[<?php echo $k; ?>][vfilename]" value="" />
					<input type="hidden" name="Attachment[<?php echo $k; ?>][size]" value="" />
					<input type="hidden" name="Attachment[<?php echo $k; ?>][id]" value="" />
				</div>
			</div>
			<div class="clearfix"></div>
			<?php
			}
		}
	}
?>