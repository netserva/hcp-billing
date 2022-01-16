<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title"><?php echo lang('cancel_order'); ?></h4>
		</div><?php
             $attributes = ['class' => 'bs-example form-horizontal'];
          echo form_open(base_url().'orders/cancel', $attributes); ?>
		<div class="modal-body">
		<input type="hidden" name="invoice_id" value="<?php echo $order[0]->invoice_id; ?>">
				<h3><?php echo lang('hosting'); ?></h3>
			
				<table class="table table-bordered table-striped">		
						<thead><tr><th><?php echo lang('service'); ?></th><th><?php echo lang('username'); ?></th><th><?php echo lang('password'); ?></th><th><?php echo lang('delete_controlpanel'); ?></th></thead>
						<tbody>
						<?php foreach ($order as $item) {
              if ('hosting' == $item->type) { ?>
							<tr><td><?php echo $item->item_name; ?></td>
							<td>
							<input type="hidden" name="hosting[]" value="<?php echo $item->id; ?>">
							<input type="hidden" name="account[]" value="<?php echo $item->domain; ?>">
							<input type="hidden" name="service[]" value="<?php echo $item->item_name; ?>">
							<input type="text" value="<?php echo $item->username; ?>" name="username[]" class="form-control" readonly="readonly"></td>
							<td><input type="text" value="<?php echo $item->password; ?>" name="password[]" class="form-control" readonly="readonly">
							</td>
							<td>
							<?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'manage_accounts')) { ?>
							<label class="switch">
									 <input type="hidden" value="off" name="<?php echo $item->username; ?>_delete_controlpanel" />
									<input type="checkbox" name="<?php echo $item->username; ?>_delete_controlpanel">									
								<span></span>
							</label>
							<?php } ?>
						</td></tr>
						<?php }
          } ?>
					</tbody>
				</table>
				
				<h3><?php echo lang('domains'); ?></h3>
			
				<table class="table table-bordered table-striped">		
						<thead><tr><th><?php echo lang('service'); ?></th><th><?php echo lang('domain'); ?></th><th><?php echo lang('nameservers'); ?></th></thead>
						<tbody>
						<?php foreach ($order as $item) {
              if ('domain' == $item->type || 'domain_only' == $item->type) { ?>
							<tr><td><?php echo $item->item_name; ?></td><td><?php echo $item->domain; ?></td>
							<td>
							<input type="hidden" name="domain_name[]" value="<?php echo $item->domain; ?>">
							<input type="hidden" name="domain[]" value="<?php echo $item->id; ?>">
							<?php echo $item->nameservers; ?>
							</td>
							</tr>
						<?php }
          } ?>
					</tbody>
				</table>

				<div class="row"> 
					<div class="col-md-12">
					<span class="pull-right"><?php echo lang('credit_account'); ?>: <label class="switch">
						<input type="hidden" value="off" name="credit_account" />
						<input type="checkbox" name="credit_account">									
						<span></span>
						</label>
					</span>
				</div>
			</div>

		</div>
		

		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a>
		<button <?php echo ('TRUE' == config_item('demo_mode')) ? 'disabled' : ''; ?> type="submit" class="btn btn-<?php echo config_item('theme_color'); ?>"><?php echo lang('cancel_order'); ?></button>
		</form>
		</div>
	</div>
	<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
