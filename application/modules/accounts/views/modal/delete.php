<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title"><?php echo lang('delete_account'); ?></h4>
		</div><?php
             $attributes = ['class' => 'bs-example form-horizontal'];
          echo form_open(base_url().'accounts/delete', $attributes); ?>
		<div class="modal-body">

		<input type="hidden" name="id" value="<?php echo $item->id; ?>">
				<div class="form-group">
						<label class="col-lg-5 control-label"><?php echo lang('delete_controlpanel'); ?></label>
						<div class="col-lg-5"><label class="switch">
									<input type="hidden" value="off" name="delete_controlpanel" />
									<input type="checkbox" name="delete_controlpanel">									
								<span></span>
							</label>
					</div>	 
				</div>
		 

				<h3><?php echo lang('hosting'); ?></h3>

				<table class="table table-bordered table-striped">		
						<thead><tr><th><?php echo lang('package'); ?></th><th><?php echo lang('username'); ?></th><th><?php echo lang('password'); ?></th></thead>
						<tbody>
							<tr><td><?php echo $item->item_name; ?></td>
							<td><input type="text" value="<?php echo $item->username; ?>" name="username" class="form-control" readonly="readonly"></td>
							<td><input type="text" value="<?php echo $item->password; ?>" name="password" class="form-control" readonly="readonly"></td>
							</tr>

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
		<button <?php echo ('TRUE' == config_item('demo_mode')) ? 'disabled' : ''; ?> type="submit" class="btn btn-<?php echo config_item('theme_color'); ?>"><?php echo lang('delete_account'); ?></button>
		</form>
		</div>
	</div>
	<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
