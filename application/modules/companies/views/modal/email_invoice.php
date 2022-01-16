<div class="modal-dialog">
	<div class="modal-content">

		<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title"><?php echo lang('email_invoice'); ?></h4>
		</div><?php
             $attributes = ['class' => 'bs-example form-horizontal'];
          echo form_open(base_url().'companies/send_invoice', $attributes); ?>
		<div class="modal-body">
			<input type="hidden" name="company" value="<?php echo $company; ?>">
        <div class="form-group">
				<label class="col-lg-4 control-label"><?php echo lang('select_invoice'); ?> <span class="text-danger">*</span></label>
				<div class="col-lg-8">
		
		<select name="invoice_id" class="select2-option form-control" required="">
            <?php if (count($invoices) > 0) {
              foreach ($invoices as $key => $inv) { ?>
              <option value="<?php echo $inv->inv_id; ?>"><?php echo $inv->reference_no; ?> - 
              <?php echo Applib::format_currency($inv->currency, Invoice::get_invoice_due_amount($inv->inv_id)); ?> : <?php echo lang(Invoice::payment_status($inv->inv_id)); ?>
              </option>
            <?php } ?>
            <?php
          } ?>
          </select>
				</div>
				</div>
        <input type="hidden" name="user" value="<?php echo $user; ?>">
		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a>
		<button type="submit" class="submit btn btn-<?php echo config_item('theme_color'); ?>"><?php echo lang('email_invoice'); ?></button>
		</form>
		</div>
	</div>
	<!-- /.modal-content -->




</div>
<!-- /.modal-dialog -->