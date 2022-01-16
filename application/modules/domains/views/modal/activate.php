<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title"><?php echo lang('activate_order'); ?></h4>
		</div><?php
             $attributes = ['class' => 'bs-example form-horizontal'];
          echo form_open(base_url().'domains/activate', $attributes); ?>
		<div class="modal-body">
		<div class="row">
		 
					<table class="table table-bordered table-striped">		
						<thead><tr><th><?php echo lang('service'); ?></th><?php if ($item->item_name == lang('domain_transfer')) { ?><th><?php echo lang('authcode'); ?></th><?php } ?><th><?php echo lang('nameservers'); ?></th><th><?php echo lang('register_transfer'); ?></th><th><?php echo lang('registrar'); ?></th></thead>
						<tbody> 
							<tr><td><?php echo $item->item_name; ?></td>
							<?php if ($item->item_name == lang('domain_transfer')) { ?><td><input type="text" value="<?php echo $item->authcode; ?>" name="authcode"></td> <?php } ?>
							<td><?php echo $item->nameservers; ?></td>
							<td>
							<input type="hidden" name="domain_status" value="<?php echo $item->status_id; ?>">
							<input type="hidden" name="id" value="<?php echo $item->id; ?>">
							<input type="hidden" name="domain" value="<?php echo $item->item_desc; ?>">
							<label class="switch">
									<input type="hidden" value="off" name="activate_domain" />
									<input type="checkbox" <?php if (6 == $item->status_id) {
              echo 'checked="checked"';
          } ?> name="activate_domain">
								<span></span>
							</label></td>
							<td>
							<select name="registrar" class="form-control m-b">
							<option value=""><?php echo lang('registrar'); ?></option>
							<?php if ('TRUE' == config_item('resellerclub_live')) { ?>
							<option value="resellerclub">ResellerClub</option>
							<?php }

                            if ('TRUE' == config_item('domainscoza_live')) { ?>
								<option value="domainscoza">DomainsCO.ZA</option>
							<?php }

                            if ('TRUE' == config_item('namecheap_live')) { ?>
								<option value="namecheap">Namecheap</option>
								<?php }

                            ?>
						</select></td></tr>				 
					</tbody>
				</table>
				
				 
		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a>
		<button type="submit" class="btn btn-<?php echo config_item('theme_color'); ?>"><?php echo lang('activate'); ?></button>
		</form>
		</div>
	</div>
	<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
