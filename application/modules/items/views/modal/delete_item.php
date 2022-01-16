<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header bg-danger"> <button type="button" class="close" data-dismiss="modal">&times;</button> 
		<h4 class="modal-title"><?php echo lang('delete_item'); ?></h4>
		</div><?php
            echo form_open(base_url().'items/delete_item'); ?>
		<div class="modal-body">
			<p><?php echo lang('delete_item_warning'); ?></p>
			<input type="hidden" name="r_url" value="<?php echo base_url(); ?>items?view=<?php echo $item; ?>">
			
			<input type="hidden" name="item" value="<?php echo $item_id; ?>">

		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a>
			<button type="submit" class="btn btn-danger"><?php echo lang('delete_button'); ?></button>
		</form>
	</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->