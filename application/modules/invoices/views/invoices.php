<?php declare(strict_types=1);
$client = User::is_client(); ?>       
       <div class="box">
            <div class="box-header">
              <div class="btn-group">

              <button class="btn btn-<?php echo config_item('theme_color'); ?> btn-sm">
              <?php
              $view = $_GET['view'] ?? null;

              switch ($view) {
                case 'paid':
                  echo lang('paid');

                  break;

                case 'unpaid':
                  echo lang('not_paid');

                  break;

                case 'partially_paid':
                  echo lang('partially_paid');

                  break;

                case 'recurring':
                  echo lang('recurring');

                  break;

                default:
                  echo lang('filter');

                  break;
              }
              ?></button>
              <button class="btn btn-<?php echo config_item('theme_color'); ?> btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span>
              </button>
              <ul class="dropdown-menu">

              <li><a href="<?php echo base_url(); ?>invoices?view=paid"><?php echo lang('paid'); ?></a></li>
              <li><a href="<?php echo base_url(); ?>invoices?view=unpaid"><?php echo lang('not_paid'); ?></a></li>
              <li><a href="<?php echo base_url(); ?>invoices?view=partially_paid"><?php echo lang('partially_paid'); ?></a></li>
              <li><a href="<?php echo base_url(); ?>invoices?view=recurring"><?php echo lang('recurring'); ?></a></li>
              <li><a href="<?php echo base_url(); ?>invoices"><?php echo lang('all_invoices'); ?></a></li>

              </ul>
              </div>
              
              <?php
              if (User::is_admin() || User::perm_allowed(User::get_id(), 'add_invoices')) { ?>
              <a href="<?php echo base_url(); ?>invoices/add" class="btn btn-sm btn-<?php echo config_item('theme_color'); ?> pull-right"><i class="fa fa-plus"></i> <?php echo lang('create_invoice'); ?></a>
              <?php } ?>
              </div>
            <div class="box-body">
            <div class="table-responsive">
		      <table class="table table-striped b-t AppendDataTables">
                <thead>
                  <tr>
                    <th class="w_5 hidden"></th>
                    <th class=""><?php echo lang('invoice'); ?></th>
                    <th class=""><?php echo lang('client_name'); ?></th>
                    <th class=""><?php echo lang('status'); ?></th>
                    <th class="col-date"><?php echo lang('date'); ?></th>
                    <th class="col-date"><?php echo lang('due_date'); ?></th>
                    <th class="col-currency"><?php echo lang('sub_total'); ?></th>
                    <th class="col-currency"><?php echo lang('due_amount'); ?></th>
                    <th><?php echo lang('options'); ?></th>

                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($invoices as $key => &$inv) {
                      $status = Invoice::payment_status($inv->inv_id);

                      switch ($status) {
                        case 'fully_paid': $label2 = 'success';

break;

                        case 'partially_paid': $label2 = 'warning';

break;

                        case 'not_paid': $label2 = 'danger';

break;

                        case 'cancelled': $label2 = 'primary';

break;
                    } ?>
                  <tr class="<?php echo ('Cancelled' == $inv->status) ? 'text-danger' : ''; ?>">
                  <td class="hidden"><?php echo $inv->inv_id; ?></td>

                  <td style="border-left: 2px solid <?php echo ('fully_paid' == $status) ? '#1ab394' : '#f0ad4e'; ?>"> 
                    <a class="text-info" href="<?php echo base_url(); ?>invoices/view/<?php echo $inv->inv_id; ?>">
                    <?php echo $inv->reference_no; ?>
                    </a>

                    </td>

                    <td>
                    <?php $client = Client::view_by_id($inv->client);
                      echo is_object($client) ? Client::view_by_id($inv->client)->company_name : ''; ?>
                    </td>

                    <td class="">
                        <span class="label label-<?php echo $label2; ?>"><?php echo lang($status); ?> <?php if ('Yes' == $inv->emailed) { ?><i class="fa fa-envelope-o"></i><?php } ?></span>
                      <?php if ('Yes' == $inv->recurring) { ?>
                      <span class="label label-primary"><i class="fa fa-retweet"></i></span>
                      <?php } ?>

                    </td>

                    <td><?php echo strftime(config_item('date_format'), strtotime($inv->date_saved)); ?></td>

                    <td><?php echo strftime(config_item('date_format'), strtotime($inv->due_date)); ?></td>

                    <td class="col-currency">
                      <?php if ($client) {
                          $client_cur = Client::view_by_id($inv->client)->currency;
                          echo Applib::format_currency($client_cur, Applib::client_currency($client_cur, Invoice::get_invoice_subtotal($inv->inv_id)));
                      } else {
                          echo Applib::format_currency($inv->currency, Invoice::get_invoice_subtotal($inv->inv_id));
                      } ?>
                    </td>

                    <td class="col-currency">
                     <?php if ($client) {
                          $client_cur = Client::view_by_id($inv->client)->currency;
                          echo Applib::format_currency($client_cur, Applib::client_currency($client_cur, Invoice::get_invoice_due_amount($inv->inv_id)));
                      } else {
                          echo Applib::format_currency($inv->currency, Invoice::get_invoice_due_amount($inv->inv_id));
                      } ?>
                    
                    </td>
                    <td>

                      <div class="">
                   
                           <a class="btn btn-xs btn-primary" href="<?php echo base_url(); ?>invoices/view/<?php echo $inv->inv_id; ?>" 
                           data-toggle="tooltip" data-original-title="<?php echo lang('view'); ?>" data-placement="top">
                           <i class="fa fa-eye"></i>
                           </a>
                          

                <?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'edit_all_invoices')) { ?>
                         
                          <a class="btn btn-xs btn-twitter" href="<?php echo base_url(); ?>invoices/edit/<?php echo $inv->inv_id; ?>" 
                          data-toggle="tooltip" data-original-title="<?php echo lang('edit'); ?>" data-placement="top">
                          <i class="fa fa-pencil"></i>
                          </a>                          

                <?php } ?>
                          
                        <a class="btn btn-xs btn-warning" href="<?php echo base_url(); ?>invoices/transactions/<?php echo $inv->inv_id; ?>" 
                        data-toggle="tooltip" data-original-title="<?php echo lang('payments'); ?>" data-placement="top">
                        <i class="fa fa-money"></i></a>
                          

                <?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'email_invoices')) { ?>
                        <a class="btn btn-xs btn-success" href="<?php echo base_url(); ?>invoices/send_invoice/<?php echo $inv->inv_id; ?>" 
                        data-toggle="ajaxModal"><span data-toggle="tooltip" data-original-title="<?php echo lang('email_invoice'); ?>" data-placement="top">
                        <i class="fa fa-envelope"></i></span></a>
                <?php } ?>


                <?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'send_email_reminders')) { ?>                   
                    <a href="<?php echo base_url(); ?>invoices/remind/<?php echo $inv->inv_id; ?>" data-toggle="ajaxModal" 
                    class="btn btn-xs btn-vk" data-original-title="<?php echo lang('send_reminder'); ?>">
                    <span data-toggle="tooltip" data-original-title="<?php echo lang('send_reminder'); ?>" data-placement="top">
                    <i class="fa fa-bell"></i></span> </a>
                <?php } ?>
                    
                      <a class="btn btn-xs btn-linkedin" href="<?php echo base_url(); ?>fopdf/invoice/<?php echo $inv->inv_id; ?>" 
                      data-toggle="tooltip" data-original-title="<?php echo lang('pdf'); ?>" data-placement="top">
                      <i class="fa fa-file-pdf-o"></i></a>

                <?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'delete')) { ?>
                                 
                      <a class="btn btn-xs btn-danger" href="<?php echo base_url(); ?>invoices/delete/<?php echo $inv->inv_id; ?>" data-toggle="ajaxModal">
                      <span data-toggle="tooltip" data-original-title="<?php echo lang('delete'); ?>" data-placement="top"><i class="fa fa-trash"></i></span></a>
                        

                <?php } ?>

                </div>
                     </td>
                  </tr>
                  <?php
                  } ?>
                </tbody>
              </table>
            </div>
        </div>
    </div>
  