<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header bg-danger"> <button type="button" class="close" data-dismiss="modal">&times;</button> 
		<h4 class="modal-title"><?php echo lang('delete_user'); ?></h4>
		</div><?php
            echo form_open(base_url().'users/account/delete'); ?>
		<div class="modal-body">
			<p><?php echo lang('delete_user_warning'); ?></p>

			<ul>
				<li><?php echo lang('tickets'); ?></li>
				<li><?php echo lang('activities'); ?></li>
			</ul>
			
			<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
			<?php
            $company = User::profile_info($user_id)->company;
            if ($company >= 1) {
                $redirect = 'companies/view/'.$company;
            } else {
                $redirect = 'users/account';
            }
            ?>
			<input type="hidden" name="r_url" value="<?php echo base_url(); ?><?php echo $redirect; ?>">

		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a>
			<button type="submit" class="btn btn-danger"><?php echo lang('delete_button'); ?></button>
		</form>
	</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->