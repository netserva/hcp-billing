<section id="content">
          <section class="hbox stretch">
            <!-- .aside -->
            <aside>
              <section class="vbox">
               <header class="header bg-white b-b b-light">
                  <a href="#aside" data-toggle="class:show" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i> <?php echo lang('new_user'); ?></a>
                  <p><?php echo lang('registered_clients'); ?></p>
                </header>
                <section class="scrollable wrapper">

                  <div class="row">			
				<div class="col-lg-12">
				<?php echo modules::run('sidebar/flash_msg'); ?>
					<section class="panel panel-default">

						<div class="table-responsive">
							<table id="clients" class="table table-striped m-b-none">
								<thead>
									<tr>
										<th><?php echo lang('avatar_image'); ?></th>
										<th><?php echo lang('username'); ?> </th>
										<th><?php echo lang('full_name'); ?></th>										
										<th><?php echo lang('company'); ?> </th>
										<th><?php echo lang('role'); ?> </th>
										<th><?php echo lang('registered_on'); ?> </th>
										<th class="col-options no-sort"><?php echo lang('options'); ?></th>
									</tr> </thead> <tbody>
			<?php
            if (!empty($users)) {
                foreach ($users as $key => $user) { ?>
									<tr>
									<td><a class="pull-left thumb-sm avatar">
									<img src="<?php echo base_url(); ?>resource/avatar/<?php echo $user->avatar; ?>" class="img-circle"></a>
									</td>
										<td><a href="<?php echo base_url(); ?>contacts/view/details/<?php echo $user->user_id * 1200; ?>" class="text-info"><?php echo ucfirst($user->username); ?></a></td>
										<td><?php echo $user->fullname; ?></td>										
										<td><?php echo $user->company; ?></td>
										<td><?php
                    if ('admin' == $this->user_profile->role_by_id($user->role_id)) {
                        $span_badge = 'label label-danger';
                    } elseif ('staff' == $this->user_profile->role_by_id($user->role_id)) {
                        $span_badge = 'label label-primary';
                    } else {
                        $span_badge = '';
                    }
                    ?><span class="<?php echo $span_badge; ?>">
					<?php echo ucfirst($this->user_profile->role_by_id($user->role_id)); ?></span></td>
										<td><?php echo strftime(config_item('date_format'), strtotime($user->created)); ?> </td>
					<td>
					<a href="<?php echo base_url(); ?>users/view/update/<?php echo $user->user_id; ?>" class="btn btn-default btn-xs" data-toggle="ajaxModal" title="<?php echo lang('edit'); ?>"><i class="fa fa-pencil"></i> </a>
					<?php
                    if ($user->username != $this->tank_auth->get_username()) { ?>
					<a href="<?php echo base_url(); ?>users/account/delete/<?php echo $user->user_id; ?>" class="btn btn-danger btn-xs" data-toggle="ajaxModal" title="<?php echo lang('delete'); ?>"><i class="fa fa-trash-o"></i></a>
					<?php } ?>
					</td>
									</tr>
									<?php }
            } ?>
									
									
								</tbody>
							</table>
						</div>
					</section>
				</div>
			</div>

                </section>
              </section>
            </aside>
            <!-- /.aside -->
            <!-- .aside -->
            <aside class="aside-lg bg-white b-l hide" id="aside">
              <div class="scrollable wrapper">
                <h4 class="m-t-none"><?php echo lang('new_client'); ?></h4>
                <?php
          echo form_open(base_url().'auth/register_user'); ?>
           <?php echo $this->session->flashdata('form_errors'); ?>
           <input type="hidden" name="r_url" value="<?php echo base_url(); ?>contacts">
                  <div class="form-group">
                    <label><?php echo lang('username'); ?> <span class="text-danger">*</span></label>
                    <input type="text" name="username" placeholder="<?php echo lang('eg'); ?> johndoe" value="<?php echo set_value('username'); ?>" class="input-sm form-control">
                  </div>
                  <div class="form-group">
                    <label><?php echo lang('email'); ?> <span class="text-danger">*</span></label>
                    <input type="email" placeholder="johndoe@me.com" name="email" value="<?php echo set_value('email'); ?>" class="input-sm form-control">
                  </div>
                  <div class="form-group">
                    <label><?php echo lang('password'); ?> <span class="text-danger">*</span></label>
                    <input type="password" placeholder="<?php echo lang('password'); ?>" value="<?php echo set_value('password'); ?>" name="password"  class="input-sm form-control">
                  </div>
                  <div class="form-group">
                    <label><?php echo lang('confirm_password'); ?> <span class="text-danger">*</span></label>
                    <input type="password" placeholder="<?php echo lang('confirm_password'); ?>" value="<?php echo set_value('confirm_password'); ?>" name="confirm_password"  class="input-sm form-control">
                  </div>
                  <div class="form-group">
                    <label><?php echo lang('company'); ?> </label>
                    <input type="text" value="<?php echo set_value('company'); ?>" name="company" class="input-sm form-control">
                  </div>
                  <div class="form-group">
                    <label><?php echo lang('role'); ?></label>
                    <div>
                      <select name="role" class="form-control">
                      <?php
                      if (!empty($roles)) {
                          foreach ($roles as $r) { ?>
                      	 <option value="<?php echo $r->r_id; ?>"><?php echo ucfirst($r->role); ?></option>
                      <?php }
                      } ?>
                          </select>
                    </div>
                  </div>
                  <div class="m-t-lg"><button class="btn btn-sm btn-success"><?php echo lang('register_user'); ?></button></div>
                </form>
              </div>
            </aside>
            <!-- /.aside -->
          </section>
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen, open" data-target="#nav,html"></a>
        </section>

