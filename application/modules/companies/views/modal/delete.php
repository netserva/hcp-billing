<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header bg-danger"> <button type="button" class="close" data-dismiss="modal">&times;</button> 
		<h4 class="modal-title"><?php echo lang('delete_company'); ?></h4>
		</div><?php
            echo form_open(base_url().'companies/delete'); ?>
		<div class="modal-body">
			<p><?php echo lang('delete_company_warning'); ?></p>
			<ul>
				<li><?php echo lang('invoices'); ?></li>
				<li><?php echo lang('payments'); ?></li>
				<li><?php echo lang('activities'); ?></li>
			</ul>
			
			<input type="hidden" name="company" value="<?php echo $company_id; ?>">

		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a>
			<button type="submit" class="btn btn-danger"><?php echo lang('delete_button'); ?></button>
		</form>
	</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->