<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title"><?php echo lang('activate_order'); ?></h4>
		</div><?php
             $attributes = ['class' => 'bs-example form-horizontal'];
          echo form_open(base_url().'orders/activate', $attributes); ?>
		<div class="modal-body">

		<input type="hidden" name="o_id" value="<?php echo $order[0]->o_id; ?>"> 
		
				<?php if ($order[0]->o_id > 0) { ?>
					<h3><?php echo lang('upgrade_downgrade'); ?> (<?php echo $order[0]->domain; ?>)</h3>
					  <h5> <?php echo $order[0]->item_desc; ?> </h5>	  

				<?php } else { ?>
			 
						<input type="hidden" name="client_id" value="<?php echo $order[0]->client_id; ?>">
						<input type="hidden" name="inv_id" value="<?php echo $order[0]->invoice_id; ?>">
			 
			 
				<h3><?php echo lang('hosting'); ?></h3>
				<table class="table table-bordered table-striped">		
						<thead><tr><th><?php echo lang('package'); ?></th><th><?php echo lang('username'); ?></th><th><?php echo lang('password'); ?></th><th><?php echo lang('create_controlpanel'); ?></th><th style="width:180px;text-align:center;"><?php echo lang('server'); ?></th><th><?php echo lang('send_details'); ?></th></thead>
						<tbody>
						<?php foreach ($order as $item) {
              if ('hosting' == $item->type) { ?>	 
							<tr>
							<td><?php echo $item->item_name; ?> - <?php echo $item->domain; ?></td>
							<td>							
							<input type="hidden" name="service[]" value="<?php echo $item->item_name; ?>">
							<input type="hidden" name="hosting[]" value="<?php echo $item->id; ?>">
							<input type="hidden" name="hosting_status[]" value="<?php echo $item->status_id; ?>">
							<input type="hidden" name="hosting_domain[]" value="<?php echo $item->domain; ?>">
							<input type="hidden" name="hosting_item_id[]" value="<?php echo $item->item_parent; ?>">
							<input type="text" value="<?php echo $item->username; ?>" name="username[]" class="form-control"></td>
							<td><input type="text" value="<?php echo $item->password; ?>" name="password[]" class="form-control">
							</td>					
							<td><?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'manage_accounts')) { ?>
								<label class="switch">
									<input type="hidden" value="off" name="<?php echo $item->username; ?>_controlpanel" />
									<input type="checkbox" name="<?php echo $item->username; ?>_controlpanel">									
								<span></span>
							</label>
							<?php } ?>
							</td>
							<td>
							<select id="server" name="server[]" class="form-control m-b">							
								<?php
                                $parent = $this->db->where('item_id', $item->item_parent)->get('items_saved')->row();
                                $default_server = $this->db->where('id', $parent->server)->get('servers')->row();
                                foreach ($servers as $server) {
                                    if ($default_server) {?>
								<option value="<?php echo $server->id; ?>" <?php echo ($default_server->id == $server->id) ? 'selected' : ''; ?>><?php echo $server->name; ?></option>
								<?php } else {?>
									<option value="<?php echo $server->id; ?>"><?php echo $server->name; ?></option>
								<?php }
                                } ?>
							</select>
							</td>
							<td><?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'manage_accounts')) { ?><label class="switch">
									<input type="hidden" value="off" name="<?php echo $item->username; ?>_send_details[]" />
									<input type="checkbox" name="<?php echo $item->username; ?>_send_details[]">									
								<span></span>
							</label>
							<?php } ?></td>
						</tr>
						<?php }
          } ?>
					</tbody>
				</table>
				
				<h3><?php echo lang('domains'); ?></h3>
					<table class="table table-bordered table-striped">		
						<thead><tr><th><?php echo lang('service'); ?></th><th><?php echo lang('domain'); ?></th><th><?php echo lang('authcode'); ?></th><th><?php echo lang('nameservers'); ?></th><th><?php echo lang('register'); ?></th><th><?php echo lang('registrar'); ?></th></thead>
						<tbody>
								<?php foreach ($order as $item) {
              if ('domain' == $item->type || 'domain_only' == $item->type) { ?>
									<tr><td><?php echo $item->item_name; ?></td>
									<td><?php echo $item->domain; ?></td>
									<td><input type="text" value="<?php echo $item->authcode; ?>" name="authcode[]" <?php if ($item->item_name != lang('domain_transfer')) { ?> readonly <?php } ?>> </td>
									<td><?php echo $item->nameservers; ?></td>
									<td>
									<input type="hidden" name="domain_status[]" value="<?php echo $item->status_id; ?>">
									<input type="hidden" name="domain[]" value="<?php echo $item->id; ?>">
									<input type="hidden" name="domain_name[]" value="<?php echo $item->domain; ?>">
									<input type="hidden" name="domain_item_id[]" value="<?php echo $item->item_parent; ?>">
									<?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'manage_accounts')) { ?>
									<label class="switch">
									<?php $domain = explode('.', $item->domain, 2); ?>
									<input type="hidden" value="off" name="<?php echo $domain[0]; ?>_activate" />
									<input type="checkbox" name="<?php echo $domain[0]; ?>_activate">
								<span></span>
							</label>
							<?php } ?> 
							</td>
							<td>
							<select name="registrar[]" class="form-control m-b">
							<?php

                                    $registrars = Plugin::domain_registrars();
                                    foreach ($registrars as $registrar) {?> 
									<option value="<?php echo $registrar->system_name; ?>"><?php echo ucfirst($registrar->system_name); ?></option>
                                    <?php } ?>
	
							</select></td>
							</tr>
							<?php }
          } ?>
						</tbody>
					</table>

				<?php } ?>
			</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a>
		<button type="submit" class="btn btn-<?php echo config_item('theme_color'); ?>"><?php echo lang('activate'); ?></button>
		</form>
		</div>
	</div>
	<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
