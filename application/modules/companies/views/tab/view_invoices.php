    <?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'view_all_invoices')) { ?>
    <table id="table-invoices" class="table table-striped b-t b-light AppendDataTables">
        <thead>
        <tr>
            <th class="w_5 hidden"></th>
            <th><?php echo lang('invoice'); ?></th>
            <th class=""><?php echo lang('status'); ?></th>
            <th class="col-date"><?php echo lang('due_date'); ?></th>
            <th class="col-currency"><?php echo lang('amount'); ?></th>
            <th class="col-currency"><?php echo lang('due_amount'); ?></th>
            <th><?php echo lang('options'); ?></th>
        </tr> </thead> <tbody>
<?php foreach (Invoice::get_client_invoices($company) as $key => $inv) { ?>
    <?php
    $status = Invoice::payment_status($inv->inv_id);

    switch ($status) {
        case 'fully_paid': $label2 = 'success';

break;

        case 'partially_paid': $label2 = 'warning';

break;

        case 'not_paid': $label2 = 'danger';

break;
    } ?>
            <tr>
                <td class="hidden"><?php echo $inv->inv_id; ?></td>
                <td>
                    <a class="text-info" href="<?php echo base_url(); ?>invoices/view/<?php echo $inv->inv_id; ?>">
                        <?php echo $inv->reference_no; ?>
                    </a>
                </td>

                <td class="">
                    <span class="label label-<?php echo $label2; ?>"><?php echo lang($status); ?> <?php if ('Yes' == $inv->emailed) { ?><i class="fa fa-envelope-o"></i><?php } ?></span>
                  <?php if ('Yes' == $inv->recurring) { ?>
                  <span class="label label-primary"><i class="fa fa-retweet"></i></span>
                  <?php }  ?>

                </td>

                <td><?php echo strftime(config_item('date_format'), strtotime($inv->due_date)); ?></td>
                <td class="col-currency">
                <?php echo Applib::format_currency($inv->currency, Invoice::get_invoice_subtotal($inv->inv_id)); ?>
                </td>

                <td class="col-currency">
                    <strong>
                <?php echo Applib::format_currency($inv->currency, Invoice::get_invoice_due_amount($inv->inv_id)); ?>
                </strong>
                </td>

                <td> 
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
 
                </td>
            </tr>
        <?php } ?>



        </tbody>
    </table>

    <?php } ?>
 