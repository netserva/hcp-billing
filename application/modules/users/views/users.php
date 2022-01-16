<?php declare(strict_types=1);
$company = User::profile_info($this->session->userdata('user_id')); ?>
 
 			<div class="box">
				<div class="box-header b-b b-light">
					<a href="#aside" data-toggle="class:show" class="btn btn-sm btn-<?php echo config_item('theme_color'); ?> pull-right"><i class="fa fa-plus"></i> <?php echo lang('new_user'); ?></a>
				</div>
				 		<div class="box-body">						
						 
						 <div class="hide" id="aside">	
						<div class="row">
						<div class="col-md-6"></div>
							<div class="col-md-6">
									<div class="box box-primary">	
										<div class="box-header with-border"><?php echo lang('new_user'); ?></div>
										<div class="box-body">	
											<?php
                                            echo form_open(base_url().'auth/register_user'); ?>
											<p class="text-danger"><?php echo $this->session->flashdata('form_errors'); ?></p>
											<input type="hidden" name="r_url" value="<?php echo base_url(); ?>users/account">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label><?php echo lang('full_name'); ?> <span class="text-danger">*</span></label>
														<input type="text" class="input-sm form-control" value="<?php echo set_value('fullname'); ?>" placeholder="<?php echo lang('eg'); ?> <?php echo lang('user_placeholder_name'); ?>" name="fullname" required>
													</div>
													<div class="form-group">
														<label><?php echo lang('username'); ?> <span class="text-danger">*</span></label>
														<input type="text" name="username" placeholder="<?php echo lang('eg'); ?> <?php echo lang('user_placeholder_username'); ?>" value="<?php echo set_value('username'); ?>" class="input-sm form-control" required>
													</div>
													
													<div class="form-group">
														<label><?php echo lang('password'); ?></label>
														<input type="password" placeholder="<?php echo lang('password'); ?>" value="<?php echo set_value('password'); ?>" name="password"  class="input-sm form-control">
													</div>
													<div class="form-group">
														<label><?php echo lang('confirm_password'); ?></label>
														<input type="password" placeholder="<?php echo lang('confirm_password'); ?>" value="<?php echo set_value('confirm_password'); ?>" name="confirm_password"  class="input-sm form-control">
													</div>
												</div>
											<div class="col-md-6">
													<div class="form-group">
														<label><?php echo lang('email'); ?> <span class="text-danger">*</span></label>
														<input type="email" placeholder="<?php echo lang('eg'); ?> <?php echo lang('user_placeholder_email'); ?>" name="email" value="<?php echo set_value('email'); ?>" class="input-sm form-control" required>
													</div>

													<div class="form-group">
														<label><?php echo lang('company'); ?></label>
														<select class="select2-option w_200" name="company" >
															<optgroup label="<?php echo lang('default_company'); ?>">
																<option value="<?php echo $company->company; ?>"><?php echo config_item('company_name'); ?></option>
															</optgroup>
															<optgroup label="<?php echo lang('other_companies'); ?>">
																<?php foreach (Client::get_all_clients() as $company) { ?>
																<option value="<?php echo $company->co_id; ?>"><?php echo $company->company_name; ?></option>
																<?php } ?>
															</optgroup>
														</select>
													</div>
													<div class="form-group">
														<label><?php echo lang('phone'); ?> </label>
														<input type="text" class="input-sm form-control" value="<?php echo set_value('phone'); ?>" name="phone" placeholder="<?php echo lang('eg'); ?> <?php echo lang('user_placeholder_phone'); ?>">
													</div>
													<div class="form-group">
														<label><?php echo lang('role'); ?></label>
														<select name="role" class="form-control">
															<?php foreach (User::get_roles() as $r) { ?>
															<option value="<?php echo $r->r_id; ?>"><?php echo ucfirst($r->role); ?></option>
															<?php } ?>
														</select>
													</div>
													<div class="m-t-lg"><button class="btn btn-sm btn-<?php echo config_item('theme_color'); ?>"><?php echo lang('register_user'); ?></button></div>
												</div>
											</div>	
										</form>
									</div>
							</div>
					</div>
				</div>
				</div>



								<div class="table-responsive">
									<table id="table-users" class="table table-striped m-b-none AppendDataTables">
										<thead>
											<tr>
												<th><?php echo lang('username'); ?> </th>
												<th><?php echo lang('full_name'); ?></th>
												<th><?php echo lang('company'); ?> </th>
												<th><?php echo lang('role'); ?> </th>
												<th class="hidden-sm"><?php echo lang('date'); ?> </th>
												<th class="col-options no-sort"><?php echo lang('options'); ?></th>
											</tr>
										</thead>
										<tbody>
			<?php foreach (User::all_users() as $key => $user) { ?>
				<tr>
				<?php $info = User::profile_info($user->id); ?>				
				<td>
				<a class="pull-left thumb-sm avatar" data-toggle="tooltip" data-title="<?php echo User::login_info($user->id)->email; ?>" data-placement="right">


	<img src="<?php echo User::avatar_url($user->id); ?>" class="img-rounded radius_6">

	<span class="label label-<?php echo ('1' == $user->banned) ? 'danger' : 'success'; ?>"><?php echo $user->username; ?></span>
 
				</a>
				</td>

				<td class=""><?php echo $info->fullname; ?></td>
				<td class="">
					<a href="<?php echo base_url(); ?>companies/view/<?php echo $info->company; ?>" class="text-info">
					<?php echo ($info->company > 0) ? Client::view_by_id($info->company)->company_name : 'N/A'; ?></a>
				</td>

				<td>

	<?php if ('admin' == User::get_role($user->id)) {
                                                $span_badge = 'label label-danger';
                                            } elseif ('staff' == User::get_role($user->id)) {
                                                $span_badge = 'label label-info';
                                            } elseif ('client' == User::get_role($user->id)) {
                                                $span_badge = 'label label-default';
                                            } else {
                                                $span_badge = '';
                                            }
    ?>
				<span class="<?php echo $span_badge; ?>">
				<?php echo lang(User::get_role($user->id)); ?></span>
												 </td>

													<td class="hidden-sm">
				<?php echo strftime(config_item('date_format'), strtotime($user->created)); ?>
													</td>

													<td >
	<a href="<?php echo base_url(); ?>users/account/auth/<?php echo $user->id; ?>" class="btn btn-vk btn-xs" data-toggle="ajaxModal" title="<?php echo lang('user_edit_login'); ?>"><i class="fa fa-lock"></i>
	</a>
														<?php if ('3' == $user->role_id) { ?>
	<a href="<?php echo base_url(); ?>users/account/permissions/<?php echo $user->id; ?>" class="btn btn-success btn-xs" data-toggle="ajaxModal" title="<?php echo lang('staff_permissions'); ?>"><i class="fa fa-shield"></i>
	</a>
														<?php } ?>

	<a href="<?php echo base_url(); ?>users/account/update/<?php echo $user->id; ?>" class="btn btn-twitter btn-xs" data-toggle="ajaxModal" title="<?php echo lang('edit'); ?>"><i class="fa fa-edit"></i>
	</a>
				<?php if ($user->id != User::get_id()) { ?>

	<a href="<?php echo base_url(); ?>users/account/ban/<?php echo $user->id; ?>" class="btn btn-<?php echo ('1' == $user->banned) ? 'danger' : 'warning'; ?> btn-xs" data-toggle="ajaxModal" title="<?php echo lang('ban_user'); ?>"><i class="fa fa-times-circle-o"></i>
	</a>

	<a href="<?php echo base_url(); ?>users/account/delete/<?php echo $user->id; ?>" class="btn btn-google btn-xs" data-toggle="ajaxModal" title="<?php echo lang('delete'); ?>"><i class="fa fa-trash-o"></i>
	</a>
														<?php } ?>
													</td>
												</tr>
												<?php } ?>
											</tbody>
										</table>
								</div>
							</div>
 