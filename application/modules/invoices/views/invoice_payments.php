
            <div class="box">
                <?php $inv = Invoice::view_by_id($id); ?>
                <div class="box-header b-b clearfix hidden-print">              
                    
                        <strong><?php echo lang('invoice'); ?> <?php echo $inv->reference_no; ?></strong>
                            <div class="btn-group pull-right">
                            <a href="<?php echo site_url(); ?>invoices/view/<?php echo $inv->inv_id; ?>" class="btn btn-sm btn-success">
                                <?php echo lang('view_invoice'); ?>
                            </a>


                            <?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'edit_all_invoices')) { ?>

                            <?php } ?>

                            <?php if ('fully_paid' != Invoice::payment_status($inv->inv_id)) { ?>

                              
                            <?php } ?>
 

                                    <?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'email_invoices')) { ?>
                                      
                                            <a class="btn btn-sm btn-vk" href="<?php echo base_url(); ?>invoices/send_invoice/<?php echo $inv->inv_id; ?>" data-toggle="ajaxModal" title="<?php echo lang('email_invoice'); ?>"><?php echo lang('email_invoice'); ?></a>
                                        
                                    <?php } if (User::is_admin() || User::perm_allowed(User::get_id(), 'send_email_reminders')) { ?>
                                       
                                        <a class="btn btn-sm btn-google" href="<?php echo base_url(); ?>invoices/remind/<?php echo $inv->inv_id; ?>" data-toggle="ajaxModal" title="<?php echo lang('send_reminder'); ?>"><?php echo lang('send_reminder'); ?></a>
                                        
                                    <?php } ?>
  
                         
                            <?php if ('invoicr' == config_item('pdf_engine')) { ?>
                                <a href="<?php echo base_url(); ?>fopdf/invoice/<?php echo $inv->inv_id; ?>" class="btn btn-sm btn-primary"><i class="fa fa-file-pdf-o"></i> <?php echo lang('pdf'); ?></a>
                            <?php } ?>

                            </div>
                        </div>

                        <div class="box-body">      
                                                           
                                <div class="table-responsive">
                                    <table id="table-payments" class="table table-striped b-t b-light AppendDataTables">
                                        <thead>
                                        <tr>
                                            <th class="col-options no-sort  col-sm-2"><?php echo lang('trans_id'); ?></th>
                                            <th class="col-sm-3"><?php echo lang('client'); ?></th>
                                            <th class="col-date col-sm-2"><?php echo lang('payment_date'); ?></th>
                                            <th class="col-currency col-sm-2"><?php echo lang('amount'); ?></th>
                                            <th class="col-sm-2"><?php echo lang('payment_method'); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($payments as $key => $p) { ?>


                                            <tr>

                                                <td>

                                                    <a href="<?php echo base_url(); ?>payments/view/<?php echo $p->p_id; ?>" class="small text-info">
                                                        <?php echo $p->trans_id; ?>
                                                    </a>
                                                </td>


                                                <td>
                                                    <?php echo Client::view_by_id($p->paid_by)->company_name; ?>
                                                </td>


                                                <td><?php echo strftime(config_item('date_format'), strtotime($p->payment_date)); ?></td>


                                                <td class="col-currency"><?php echo Applib::format_currency($inv->currency, $p->amount); ?></td>


                                                <td><?php echo App::get_method_by_id($p->payment_method); ?>
                                                </td>


                                            </tr>


                                        <?php } ?>


                                        </tbody>
                                    </table>
                                </div> 
                    
                  </div>
 
