<?php declare(strict_types=1);
$i = Invoice::view_by_id($id);
?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header bg-danger"> <button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title"><?php echo lang('cancel'); ?> <?php echo lang('invoice'); ?> #<?php echo $i->reference_no; ?></h4>
		</div><?php
            echo form_open(base_url().'invoices/cancel'); ?>
		<div class="modal-body">
			<p>Invoice <?php echo $i->reference_no; ?> will be marked as Cancelled.</p>

			<input type="hidden" name="id" value="<?php echo $id; ?>">

		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a>
			<button type="submit" class="btn btn-danger"><?php echo lang('cancelled'); ?></button>
		</form>
	</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
