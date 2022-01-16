<?php declare(strict_types=1);
$company = User::profile_info($this->session->userdata('user_id')); ?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title"><?php echo lang('edit_user'); ?></h4>
		</div><?php
             $attributes = ['class' => 'bs-example form-horizontal'];
          echo form_open_multipart(base_url().'users/account/update', $attributes); ?>
          <?php $user = User::view_user($id); $info = User::profile_info($id); ?>
		<div class="modal-body">
			 <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">

			 <div class="form-group">
				<label class="col-lg-3 control-label"><?php echo lang('full_name'); ?> <span class="text-danger">*</span></label>
				<div class="col-lg-8">
					<input type="text" class="form-control" value="<?php echo $info->fullname; ?>" name="fullname">
				</div>
				</div>

				<div class="form-group">
                                <label class="col-lg-3 control-label"><?php echo lang('company'); ?></label>
                                <div class="col-lg-7">
                                    <select class="select2-option w_210" name="company" >
                                    <optgroup label="<?php echo lang('default_company'); ?>">
                                        <?php if ($info->company == $company->company) { ?>
                                        <option value="<?php echo $company->company; ?>" selected="selected"><?php echo config_item('company_name'); ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $company->company; ?>"><?php echo config_item('company_name'); ?></option>
                                        <?php } ?>
                                    </optgroup>
                                    <optgroup label="<?php echo lang('other_companies'); ?>">
                                        <?php foreach (Client::get_all_clients() as $company) { ?>
                                        <option value="<?php echo $company->co_id; ?>"<?php echo ($info->company == $company->co_id ? ' selected="selected"' : ''); ?>><?php echo $company->company_name; ?></option>
                                        <?php } ?>
                                    </optgroup>
 
                                    </select>
                                </div>
                            </div>


			      <?php
                  if ('staff' == User::get_role($user->id) || 'admin' == User::get_role($user->id)) { ?>
			      <div class="form-group">
			        <label class="col-lg-3 control-label"><?php echo lang('department'); ?> </label>
			        <div class="col-lg-8">
			        <select  name="department[]" class="select2-option w_200" multiple="multiple">

			          <?php
                      $departments = $this->db->get('departments')->result();
                      $dep = json_decode($info->department, true);
                      if (!empty($departments)) {
                          foreach ($departments as $d) { ?>

		<option value="<?php echo $d->deptid; ?>" <?php echo ($d->deptid == $info->department || (is_array($dep) && in_array($d->deptid, $dep))) ? ' selected="selected"' : ''; ?>>

			            <?php echo $d->deptname; ?> </option>
			            <?php }
                      } ?>
			          </select>
			          <a href="<?php echo site_url(); ?>settings/?settings=departments" class="btn btn-sm btn-danger">Add Department</a>
			          </div>
			      </div>
			      <?php } ?>

				<div class="form-group">
				<label class="col-lg-3 control-label"><?php echo lang('phone'); ?> </label>
				<div class="col-lg-4">
					<input type="text" class="form-control" value="<?php echo $info->phone; ?>" name="phone">
				</div>
				</div>

				<div class="form-group">
				<label class="col-lg-3 control-label"><?php echo lang('mobile_phone'); ?> </label>
				<div class="col-lg-4">
					<input type="text" class="form-control" value="<?php echo $info->mobile; ?>" name="mobile">
				</div>
                                </div>
				<div class="form-group">
				<label class="col-lg-3 control-label">Skype</label>
				<div class="col-lg-6">
					<input type="text" class="form-control" value="<?php echo $info->skype; ?>" name="skype">
			</div>
			</div>


			<div class="form-group">
				<label class="col-lg-3 control-label"><?php echo lang('language'); ?></label>
				<div class="col-lg-5">
					<select name="language" class="form-control">
					<?php foreach (App::languages() as $lang) { ?>
					<option value="<?php echo $lang->name; ?>"<?php echo ($info->language == $lang->name ? ' selected="selected"' : ''); ?>><?php echo ucfirst($lang->name); ?></option>
					<?php } ?>
					</select>
				</div>
			</div>

			<div class="form-group">
					<label class="col-lg-3 control-label"><?php echo lang('locale'); ?></label>
					<div class="col-lg-5">
							<select class="select2-option form-control" name="locale">
							<?php foreach (App::locales() as $loc) { ?>
							<option lang="<?php echo $loc->code; ?>" value="<?php echo $loc->locale; ?>"<?php echo ($info->locale == $loc->locale ? ' selected="selected"' : ''); ?>>
							<?php echo $loc->name; ?></option>
							<?php } ?>
							</select>
					</div>
			</div>
		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a>
		<button type="submit" class="btn btn-<?php echo config_item('theme_color'); ?>"><?php echo lang('save_changes'); ?></button>
		</form>
		</div>
	</div>
	<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
<script type="text/javascript">
(function($){
   "use strict";
	$(".select2-option").select2();
})(jQuery); 
</script>
