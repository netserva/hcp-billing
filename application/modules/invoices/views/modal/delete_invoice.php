<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header bg-danger"> <button type="button" class="close" data-dismiss="modal">&times;</button> 
		<h4 class="modal-title"><?php echo lang('delete_invoice'); ?></h4>
		</div><?php
            echo form_open(base_url().'invoices/delete'); ?>
		<div class="modal-body">
			<p><?php echo lang('delete_invoice_warning'); ?></p>
			
			<input type="hidden" name="invoice" value="<?php echo $invoice; ?>">

		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a>
			<button type="submit" class="btn btn-danger"><?php echo lang('delete_button'); ?></button>
		</form>
	</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->