<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button> 
		<h4 class="modal-title"><?php echo lang('mark_as_paid'); ?></h4>
		</div><?php
            echo form_open(base_url().'invoices/mark_as_paid'); ?>
		<div class="modal-body">
			<p><?php echo lang('mark_as_paid_notice'); ?></p>
			
			<input type="hidden" name="invoice" value="<?php echo $invoice; ?>">

		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a>
			<button type="submit" class="btn btn-<?php echo config_item('theme_color'); ?>"><?php echo lang('mark_as_paid'); ?></button>
		</form>
	</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->