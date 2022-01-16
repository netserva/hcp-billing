<?php declare(strict_types=1);
$i = Client::view_by_id($company);
$cur = Client::client_currency($i->co_id);
$due = Client::due_amount($i->co_id);
?>
 
 
 <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile"> 
              <h3 class="profile-username text-center"><?php echo $i->company_name; ?></h3> 

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b><?php echo lang('paid'); ?> - <?php echo lang('this_month'); ?></b> <a class="pull-right"><?php echo Applib::format_currency('', Client::month_amount(date('Y'), date('m'), $i->co_id)); ?></a>
                </li>
                <li class="list-group-item">
                  <b><?php echo lang('balance_due'); ?> </b> <a class="pull-right"><?php echo Applib::format_currency('', $due); ?></a>
                </li>
                <li class="list-group-item">
                  <b><?php echo lang('total_paid'); ?></b> <a class="pull-right"><?php echo Applib::format_currency('', Client::amount_paid($i->co_id)); ?></a>
                </li>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo lang('details'); ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
             <p>
              <strong><?php echo ($i->primary_contact) ? User::displayName($i->primary_contact) : ''; ?></strong>
              <span class="pull-right"><?php echo $i->company_ref; ?></span>
            </p>
              <p class="text-muted">
              <i class="fa fa-envelope margin-r-5"></i> <?php echo $i->company_email; ?>
              </p>

              <p class="text-muted">
              <i class="fa fa-phone margin-r-5"></i> <?php echo $i->company_phone; ?>
              </p>

              <p class="text-muted">
              <i class="fa fa-mobile margin-r-5"></i> <?php echo $i->company_mobile; ?>
              </p>

              <p class="text-muted">
              <i class="fa fa-fax margin-r-5"></i> <?php echo $i->company_fax; ?>
              </p>

              <hr>

              <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>

              <p class="text-muted"><?php echo nl2br($i->company_address); ?>, <?php echo $i->city; ?>, <?php echo $i->zip; ?>, <?php echo $i->state; ?>, <?php echo $i->country; ?></p>

              <hr>

              <strong><i class="fa fa-pencil margin-r-5"></i> <?php echo lang('additional_fields'); ?></strong>

              <p>
              
              <ul class="list-group no-radius">                                          

                <?php $custom_fields = Client::custom_fields($i->co_id); ?>
                <?php foreach ($custom_fields as $key => $f) { ?>
                    <?php if ($this->db->where('name', $f->meta_key)->get('fields')->num_rows() > 0) { ?>
                    <li class="list-group-item">
                            <span class="pull-right">
                                <?php echo is_json($f->meta_value) ? implode(',', json_decode($f->meta_value)) : $f->meta_value; ?></span>
                            <span class="text-muted"><?php echo ucfirst(humanize($f->meta_key, '-')); ?></span>

                    </li>
                <?php } ?>
                <?php } ?>

                </ul>
              </p>

              <hr>

              <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>
              <p><?php echo nl2br_except_pre($i->notes); ?></p>
            </div>

            <a href="<?php echo base_url(); ?>companies/update/<?php echo $i->co_id; ?>" class="btn btn-<?php echo config_item('theme_color'); ?> btn-sm btn-block" data-toggle="ajaxModal" title="<?php echo lang('edit'); ?>"><i class="fa fa-edit"></i> <?php echo lang('edit'); ?></a> 


            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              
            <li class="<?php echo ('accounts' == $tab) ? 'active' : ''; ?>">
                             <a href="<?php echo base_url(); ?>companies/view/<?php echo $i->co_id; ?>/accounts"><i class="fa fa-server"></i> <?php echo lang('hosting_accounts'); ?></a>
                            </li>

                            <li class="<?php echo ('domains' == $tab) ? 'active' : ''; ?>">
                             <a href="<?php echo base_url(); ?>companies/view/<?php echo $i->co_id; ?>/domains"><i class="fa fa-globe"></i> <?php echo lang('domains'); ?></a>
                            </li>

                            <li class="<?php echo ('contacts' == $tab) ? 'active' : ''; ?>">
                             <a href="<?php echo base_url(); ?>companies/view/<?php echo $i->co_id; ?>/contacts"><i class="fa fa-user"></i> <?php echo lang('contacts'); ?></a>
                            </li>
                            <?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'view_all_invoices')) { ?>
                            <li class="<?php echo ('invoices' == $tab) ? 'active' : ''; ?>">
                            <a href="<?php echo base_url(); ?>companies/view/<?php echo $i->co_id; ?>/invoices"><i class="fa fa-money"></i> <?php echo lang('invoices'); ?></a>
                            </li>
                            <?php } ?>
                            <?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'view_all_payments')) { ?>
                         
                            <li class="<?php echo ('payments' == $tab) ? 'active' : ''; ?>">
                            <a href="<?php echo base_url(); ?>companies/view/<?php echo $i->co_id; ?>/payments"><i class="fa fa-credit-card"></i> <?php echo lang('payments'); ?></a>
                            </li>
                            <?php } ?>
                      
                            <li class="<?php echo ('files' == $tab) ? 'active' : ''; ?>">
                             <a href="<?php echo base_url(); ?>companies/view/<?php echo $i->co_id; ?>/files"><i class="fa fa-file-o"></i> <?php echo lang('files'); ?></a>
                            </li>

                            <li class="<?php echo ('email' == $tab) ? 'active' : ''; ?>">
                             <a href="<?php echo base_url(); ?>companies/view/<?php echo $i->co_id; ?>/email"><i class="fa fa-envelope"></i> <?php echo lang('send_email'); ?></a>
                            </li>

                            <?php if ('TRUE' == config_item('sms_gateway')) { ?>
                            <li>
                             <a href="<?php echo base_url(); ?>companies/send_sms/<?php echo $i->co_id; ?>" data-toggle="ajaxModal"><i class="fa fa-paper-plane"></i> <?php echo lang('send_sms'); ?></a>
                            </li>
                            <?php } ?>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane">
             
                <?php $data = ['i' => $i, 'cur' => $cur, 'due' => $due]; ?>
                            <?php $this->view('tab/view_'.$tab, $data); ?>

              
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->


 

     
       