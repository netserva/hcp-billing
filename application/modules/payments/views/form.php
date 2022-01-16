<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button> <h4 class="modal-title"><?php echo lang('new_payment'); ?></h4>
		</div>		
		<div class="modal-body">
			<p><?php echo lang('paypal_redirection_alert'); ?></p>

		<?php $attributes = ['name' => 'paypal_form', 'class' => 'bs-example form-horizontal'];
              echo form_open($paypal_url, $attributes);
              $cur = $this->applib->currencies($invoice_info['currency']);
        ?>
					<input name="rm" value="2" type="hidden">
					<input name="cmd" value="_xclick" type="hidden">
					<input name="currency_code" value="<?php echo $invoice_info['currency']; ?>" type="hidden">
					<input name="quantity" value="1" type="hidden">
					<input name="business" value="<?php echo config_item('paypal_email'); ?>" type="hidden">
					<input name="return" value="<?php echo base_url(); ?><?php echo config_item('paypal_success_url'); ?>" type="hidden">
					<input name="cancel_return" value="<?php echo base_url(); ?><?php echo config_item('paypal_cancel_url'); ?>" type="hidden">
					<input name="notify_url" value="<?php echo base_url(); ?><?php echo config_item('paypal_ipn_url'); ?>" type="hidden">
					<input name="custom" value="<?php echo $this->user_profile->get_profile_details($this->tank_auth->get_user_id(), 'company'); ?>" type="hidden">
					<input name="item_name" value="<?php echo $invoice_info['item_name']; ?>" type="hidden">
					<input name="item_number" value="<?php echo $invoice_info['item_number']; ?>" type="hidden">
					<input name="amount" value="<?php echo number_format($invoice_info['amount'], 2); ?>" type="hidden">
			 <div class="form-group">
				<label class="col-lg-4 control-label"><?php echo lang('reference_no'); ?></label>
				<div class="col-lg-4">
					<input type="text" class="form-control" readonly value="<?php echo $invoice_info['item_name']; ?>">
				</div>
				</div>
          				
				<div class="form-group">
				<label class="col-lg-4 control-label"><?php echo lang('amount'); ?> (<?php echo $cur->symbol; ?>) </label>
				<div class="col-lg-4">
					<input type="text" class="form-control" value="<?php echo number_format($invoice_info['amount'], 2); ?>" readonly>
				</div>
				</div>

				<img src="<?php echo base_url(); ?>resource/images/payment_2checkout.png">
				<img src="<?php echo base_url(); ?>resource/images/payment_american.png">
				<img src="<?php echo base_url(); ?>resource/images/payment_discover.png">
				<img src="<?php echo base_url(); ?>resource/images/payment_maestro.png">
				<img src="<?php echo base_url(); ?>resource/images/payment_paypal.png">

				<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a> 
		<button type="submit" class="btn btn-success"><?php echo lang('pay_invoice'); ?></button>
		</div>
				
			
		</div>
		
		</form>
	</div>
	<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->