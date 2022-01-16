<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title"><?php echo lang('activate_account'); ?></h4>
		</div><?php
             $attributes = ['class' => 'bs-example form-horizontal'];
          echo form_open(base_url().'accounts/activate', $attributes); ?>
		<div class="modal-body">
			
				<div class="form-group">
						<label class="col-lg-5 control-label"><?php echo lang('server'); ?></label>
						<div class="col-lg-5">
						<select id="server" name="server" class="form-control m-b">
							<?php $default_server = $this->db->where(['id' => $item->server])->get('servers')->row();
                            foreach ($servers as $server) { ?>
							<option value="<?php echo $server->id; ?>" <?php echo (isset($default_server->id) && $default_server->id == $server->id) ? 'selected' : ''; ?>><?php echo $server->name; ?> (<?php echo $server->type; ?>)</option>
							<?php } ?>
						</select>
						</div>

						<label class="col-lg-5 control-label"><?php echo lang('send_details_to_client'); ?></label>
						<div class="col-lg-5">
							<label class="switch">
									<input type="hidden" value="off" name="send_details" />
									<input type="checkbox" name="send_details">									
								<span></span>
							</label>
						</div>

						<label class="col-lg-5 control-label"><?php echo lang('create_controlpanel'); ?></label>
						<div class="col-lg-5">
						<label class="switch">
									<input type="hidden" value="off" name="create_controlpanel" />
									<input type="checkbox" name="create_controlpanel">									
								<span></span>
							</label>
						</div>
 
						<input type="hidden" name="id" value="<?php echo $item->id; ?>">						
					
				</div>
				<h3><?php echo $item->item_name; ?> - <?php echo $item->domain; ?></h3>
				<table class="table table-bordered table-striped">		
						<thead><tr><th><?php echo lang('username'); ?></th><th><?php echo lang('password'); ?></th></thead>
						<tbody>						
							<tr>
							<td><input type="text" value="<?php echo $item->username; ?>" name="username" class="form-control"></td>
							<td><input type="text" value="<?php echo $item->password; ?>" name="password" class="form-control"></td>
							 </tr>
						<?php ?>
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
