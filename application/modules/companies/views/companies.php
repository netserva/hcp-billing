<div class="box">
        <div class="box-header b-b b-light">
          <a href="<?php echo base_url(); ?>companies/create" class="btn btn-<?php echo config_item('theme_color'); ?> btn-sm pull-right" data-toggle="ajaxModal" title="<?php echo lang('new_company'); ?>" data-placement="bottom"><i class="fa fa-plus"></i> <?php echo lang('new_client'); ?></a>
          <?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'manage_accounts')) { ?>
          <a href="<?php echo base_url(); ?>companies/upload" class="btn btn-info btn-sm" title="<?php echo lang('new_company'); ?>" data-placement="bottom"><i class="fa fa-download"></i> <?php echo lang('import_whmcs'); ?></a>
          <?php } ?>
        </div>
      
              <div class="box-body">
                <div class="table-responsive">
                  <table id="table-clients" class="table table-striped m-b-none AppendDataTables">
                    <thead>
                      <tr>
                        
                        <th><?php echo lang('client'); ?> </th>
                        <th><?php echo lang('company_id'); ?> </th>
                        <th><?php echo lang('credit_balance'); ?></th>
                        <th><?php echo lang('due_amount'); ?></th>
                        <th class="hidden-sm"><?php echo lang('primary_contact'); ?></th>
                        <th><?php echo lang('email'); ?> </th>
                        <th class="col-options no-sort"><?php echo lang('options'); ?> </th>
                      </tr> </thead> <tbody>
                      <?php
                      if (!empty($companies)) {
                          foreach ($companies as $client) {
                              $client_due = Client::due_amount($client->co_id); ?>
                      <tr>
                        <td>
                        <i class="fa fa-briefcase text-<?php echo ($client_due > 0) ? 'default' : 'success'; ?>"></i>

                        <a href="<?php echo base_url(); ?>companies/view/<?php echo $client->co_id; ?>" class="text-info">
                        <?php echo (null != $client->company_name) ? $client->company_name : '...'; ?></a></td>

                        <td> 
                        <?php echo $client->company_ref; ?> 
                        </td>

                        <td>
                        <strong>
                        <?php echo Applib::format_currency(config_item('default_currency'), $client->transaction_value); ?>
                          </strong>
                        </td>


                        <td>
                        <strong>
                        <?php echo Applib::format_currency(config_item('default_currency'), $client_due); ?>
                          </strong>
                        </td>

      
                        <td class="hidden-sm">
                        <?php if (0 == $client->individual) {
                                  echo ($client->primary_contact) ? User::displayName($client->primary_contact) : 'N/A';
                              } ?>
                        </td>



                      <td><?php echo $client->company_email; ?></td>
                      <td>

                      <a href="<?php echo base_url(); ?>companies/view/<?php echo $client->co_id; ?>" class="btn btn-success btn-xs" title="<?php echo lang('view'); ?>"><i class="fa fa-eye"></i> <?php echo lang('view'); ?></a>

                        <a href="<?php echo base_url(); ?>companies/delete/<?php echo $client->co_id; ?>" class="btn btn-danger btn-xs" data-toggle="ajaxModal" title="<?php echo lang('delete'); ?>"><i class="fa fa-trash-o"></i> <?php echo lang('delete'); ?></a>
                        
                      </td>
                    </tr>
                    <?php
                          }
                      } ?>
                    
                    
                  </tbody>
                </table>

              </div>          
          </div>
        </div>
     