<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button> <h4 class="modal-title"><?php echo lang('new_payment'); ?></h4>
		</div>
		<?php $attributes = ['class' => 'bs-example form-horizontal'];
          echo form_open(base_url().'invoices/pay', $attributes); ?>
		<div class="modal-body">
			<p><?php echo lang('payment_for_invoice'); ?></p>
			<input type="hidden" name="invoice_id" value="<?php echo $invoice_id; ?>">

          				<div class="form-group">
				<label class="col-lg-4 control-label"><?php echo lang('trans_id'); ?> <span class="text-danger">*</span></label>
				<div class="col-lg-8">
				<?php $this->load->helper('string'); ?>
					<input type="text" class="form-control" value="<?php echo random_string('nozero', 6); ?>" name="trans_id" readonly>
				</div>
				</div>
				<div class="form-group">
				<label class="col-lg-4 control-label"><?php echo lang('amount'); ?> (<?php echo $info->currency; ?>) <span class="text-danger">*</span></label>
				<div class="col-lg-8">
					<input type="text" class="form-control" value="<?php echo Applib::format_tax(Invoice::get_invoice_due_amount($invoice_id)); ?>" name="amount">
				</div>
				</div>

				<div class="form-group">
				<label class="col-lg-4 control-label"><?php echo lang('payment_date'); ?></label>
				<div class="col-lg-8">
				<input class="input-sm input-s datepicker-input form-control" size="16" type="text" value="<?php echo strftime(config_item('date_format'), time()); ?>" name="payment_date" data-date-format="<?php echo config_item('date_picker_format'); ?>" >
				</div>
				</div>

				<div class="form-group">
				<label class="col-lg-4 control-label"><?php echo lang('payment_method'); ?> <span class="text-danger">*</span></label>
				<div class="col-lg-8">
				<select name="payment_method" class="form-control">
					<?php
                    if (!empty($payment_methods)) {
                        foreach ($payment_methods as $key => $p_method) { ?>
						<option value="<?php echo $p_method->method_id; ?>"><?php echo $p_method->method_name; ?></option>
					<?php }
                    } ?>
				</select>
				</div>
				</div>
				<div class="form-group">
				<label class="col-lg-4 control-label"><?php echo lang('notes'); ?></label>
				<div class="col-lg-8">
				<textarea name="notes" class="form-control ta"></textarea>
				</div>
				</div>

				<div class="form-group">
                      <label class="col-lg-4 control-label"><?php echo lang('send_email'); ?></label>
                      <div class="col-lg-8">
                        <label class="switch">
                          <input type="checkbox" name="send_thank_you">
                          <span></span>
                        </label>
                      </div>
                    </div>

		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a>
		<button type="submit" class="btn btn-success"><?php echo lang('add_payment'); ?></button>
		</form>
		</div>
	</div>
	<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
