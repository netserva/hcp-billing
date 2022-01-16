<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title"><?php echo lang('cancel_order'); ?></h4>
		</div><?php
             $attributes = ['class' => 'bs-example form-horizontal'];
          echo form_open(base_url().'domains/cancel', $attributes); ?>
		<div class="modal-body">

		<input type="hidden" name="id" value="<?php echo $item->id; ?>">
		<input type="hidden" name="domain" value="<?php echo $item->item_desc; ?>">
		<input type="hidden" name="order" value="<?php echo $item->type; ?>">
		<input type="hidden" name="inv_id" value="<?php echo $item->invoice_id; ?>">
			
		<h3><?php echo $item->domain; ?></h3>
					<table class="table table-bordered table-striped">		
						<thead><tr><th><?php echo lang('service'); ?></th><th><?php echo lang('nameservers'); ?></th><th><?php echo lang('cancel'); ?></th></thead>
						<tbody> 
							<tr><td><?php echo $item->item_name; ?></td>
							<td><?php echo $item->nameservers; ?></td>
							<td>							
							<label class="switch">
									<input type="hidden" value="off" name="cancel_domain" />
									<input type="checkbox" <?php if (6 == $item->status_id) {
              echo 'checked="checked"';
          } ?> name="cancel_domain">
								<span></span>
							</label></td></tr>				 
					</tbody>
				</table>
				<div class="row"> 
				<div class="col-md-12">
					<span class="pull-right"><?php echo lang('credit_account_item'); ?>: <label class="switch">
						<input type="hidden" value="off" name="credit_account" />
						<input type="checkbox" name="credit_account">									
						<span></span>
						</label>
					</span>
				</div>
				</div>	
				 
		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a>
		<button <?php echo ('TRUE' == config_item('demo_mode')) ? 'disabled' : ''; ?> type="submit" class="btn btn-<?php echo config_item('theme_color'); ?>"><?php echo lang('cancel_domain'); ?></button>
		</form>
		</div>
	</div>
	<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
