<?php declare(strict_types=1);
$user_login = User::login_info($id);
$profile = User::profile_info($id);
?>
          <div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button> 
		<h4 class="modal-title text-danger"><?php echo lang('edit_user'); ?> - <?php echo User::displayName($id); ?></h4>
		</div><?php
             $attributes = ['class' => 'bs-example form-horizontal'];
          echo form_open(base_url().'contacts/update', $attributes); ?>
          
		<div class="modal-body">
			 <input type="hidden" name="user_id" value="<?php echo $profile->user_id; ?>">
			 <input type="hidden" name="company" value="<?php echo $profile->company; ?>">
			 
			 <div class="form-group">
				<label class="col-lg-4 control-label"><?php echo lang('full_name'); ?> <span class="text-danger">*</span></label>
				<div class="col-lg-8">
					<input type="text" class="form-control" value="<?php echo $profile->fullname; ?>" name="fullname">
				</div>
				</div>
          		<div class="form-group">
				<label class="col-lg-4 control-label"><?php echo lang('email'); ?> <span class="text-danger">*</span></label>
				<div class="col-lg-8">
					<input type="email" class="form-control" value="<?php echo $user_login->email; ?>" name="email" required>
				</div>
				</div>
				<div class="form-group">
				<label class="col-lg-4 control-label"><?php echo lang('phone'); ?> </label>
				<div class="col-lg-8">
					<input type="text" class="form-control" value="<?php echo $profile->phone; ?>" name="phone">
				</div>
				</div>
				<div class="form-group">
				<label class="col-lg-4 control-label"><?php echo lang('mobile_phone'); ?> </label>
				<div class="col-lg-8">
					<input type="text" class="form-control" value="<?php echo $profile->mobile; ?>" name="mobile">
				</div>
                                </div>
				<div class="form-group">
				<label class="col-lg-4 control-label">Skype</label>
				<div class="col-lg-8">
					<input type="text" class="form-control" value="<?php echo $profile->skype; ?>" name="skype">
				</div>
                </div>


				<div class="form-group">
					<label class="col-lg-4 control-label"><?php echo lang('language'); ?></label>
					<div class="col-lg-5">
						<select name="language" class="form-control">
						<?php foreach (App::languages() as $lang) { ?>
						<option value="<?php echo $lang->name; ?>"<?php echo ($profile->language == $lang->name ? ' selected="selected"' : ''); ?>><?php echo ucfirst($lang->name); ?></option>
						<?php } ?>
						</select>
					</div>
				</div>
			
			
				<div class="form-group">
						<label class="col-lg-4 control-label"><?php echo lang('locale'); ?></label>
						<div class="col-lg-5">
								<select class="select2-option form-control" name="locale">
								<?php foreach (App::locales() as $loc) { ?>
								<option lang="<?php echo $loc->code; ?>" value="<?php echo $loc->locale; ?>"<?php echo (config_item('locale') == $loc->locale ? ' selected="selected"' : ''); ?>><?php echo $loc->name; ?></option>
								<?php } ?>
								</select>
						</div>
				</div>
			
		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a> 
		<button type="submit" class="btn btn-<?php echo config_item('theme_color'); ?>"><?php echo lang('save_changes'); ?></button>
		</form>		</div>
	</div>
	<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->