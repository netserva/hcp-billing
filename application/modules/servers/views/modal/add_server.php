<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title"><?php echo lang('add_server'); ?></h4>
		</div><?php
             $attributes = ['class' => 'bs-example form-horizontal'];
          echo form_open(base_url().'servers/add_server', $attributes); ?>
			<div class="modal-body"> 

<div class="row">
	<div class="col-md-8">	
			<div class="form-group">
				<label class="col-md-3 control-label"><?php echo lang('name'); ?></label>
				<div class="col-md-9">
					<input type="text" class="form-control" name="name">
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label"><?php echo lang('type'); ?></label>
				<div class="col-md-8">
					<select name="type" class="form-control m-b">
						<?php $servers = Plugin::servers();
                                foreach ($servers as $server) {?>
									<option value="<?php echo $server->system_name; ?>"><?php echo lang($server->system_name); ?></option>
								<?php } ?> 
					</select> 
				</div>
			</div>					
		</div>
	</div> 

	<div class="row">
	<div class="row">					
			<div class="col-lg-6">
				<div class="form-group">
				<label class="col-md-5 control-label"><?php echo lang('default_server'); ?></label>
				<div class="col-md-7">
					<label class="switch">
						<input type="hidden" value="off" name="selected" />
						<input type="checkbox" name="selected">
						<span></span>
					</label>
				</div>
			</div>
			</div>


			<div class="col-lg-6">
				<div class="form-group">
					<label class="col-md-4 control-label"><?php echo lang('use_ssl'); ?></label>
					<div class="col-md-7">
						<label class="switch">
							<input type="hidden" value="off" name="use_ssl" />
							<input type="checkbox" name="use_ssl">
							<span></span>
						</label>
					</div>
				</div>
			</div>
	</div>

<hr>

			<div class="row">
				<div class="col-md-8">							
					<div class="form-group">
						<label class="col-md-3 control-label"><?php echo lang('server_hostname'); ?></label>
						<div class="col-md-9">
							<input type="text" id="qty" class="form-control" name="hostname">
						</div>
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
						<label class="col-md-4 control-label"><?php echo lang('port'); ?></label>
						<div class="col-md-8">
							<input type="text" id="price" class="form-control" name="port">
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-8">
					<div class="form-group">
						<label class="col-md-3 control-label"><?php echo lang('api_key'); ?></label>
						<div class="col-md-9">
							<input type="<?php echo 'TRUE' == config_item('demo_mode') ? 'password' : 'text'; ?>"  id="price"  class="form-control" name="authkey">
						</div>
					</div>
				</div>

				<div class="col-md-4">
						<div class="form-group">
							<label class="col-md-4 control-label"><?php echo lang('username'); ?></label>
							<div class="col-md-8">
								<input type="text" id="qty" class="form-control" name="username">
							</div>
						</div>
					</div>
				</div>  

	
		</div>

		<hr> 

		<div class="form-group">
					<label class="col-lg-3 control-label"><?php echo lang('nameserver_1'); ?></label>
					<div class="col-lg-9">
						<input type="text" class="form-control" name="ns1">
					</div>
				</div>

				<div class="form-group">
					<label class="col-lg-3 control-label"><?php echo lang('nameserver_2'); ?></label>
					<div class="col-lg-9">
						<input type="text" class="form-control" name="ns2">
					</div>
				</div>

				<div class="form-group">
					<label class="col-lg-3 control-label"><?php echo lang('nameserver_3'); ?></label>
					<div class="col-lg-9">
						<input type="text" class="form-control" name="ns3">
					</div>
				</div>


				<div class="form-group">
					<label class="col-lg-3 control-label"><?php echo lang('nameserver_4'); ?></label>
					<div class="col-lg-9">
						<input type="text" class="form-control" name="ns4">
					</div>
				</div>


				<div class="form-group">
					<label class="col-lg-3 control-label"><?php echo lang('nameserver_5'); ?></label>
					<div class="col-lg-9">
						<input type="text" class="form-control" name="ns5">
					</div>
				</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a>
		<button type="submit" class="btn btn-<?php echo config_item('theme_color'); ?>"><?php echo lang('add_server'); ?></button>
		</form>
		</div>
	</div>
	<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
