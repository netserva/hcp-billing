<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header bg-<?php echo config_item('theme_color'); ?>"> <button type="button" class="close" data-dismiss="modal">&times;</button> 
		<h4 class="modal-title"><?php echo lang('unsuspend_account'); ?></h4>
		</div><?php
            echo form_open(base_url().'accounts/unsuspend'); ?>
		<div class="modal-body">
			<h4><?php echo lang('unsuspend_warning'); ?></h4>   
			<input type="hidden" name="id" value="<?php echo $id; ?>">

		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a>
			<button type="submit" class="btn btn-<?php echo config_item('theme_color'); ?>"><?php echo lang('unsuspend'); ?></button>
		</form>
	</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->