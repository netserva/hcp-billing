      <div class="box">
          <div class="box-body">
                <div class="table-responsive">
                  <table id="table-payments" class="table table-striped b-t b-light AppendDataTables">
                    <thead>
                      <tr>
                        <th class="w_5 hidden"></th>
                        <th class=""><?php echo lang('invoice'); ?></th>
                        <th class=""><?php echo lang('client'); ?></th>
                        <th class="col-date"><?php echo lang('payment_date'); ?></th>
                        <th class="col-date"><?php echo lang('invoice_date'); ?></th>
                        <th class="col-currency"><?php echo lang('amount'); ?></th>
                        <th class=""><?php echo lang('payment_method'); ?></th>
                        <th class=""><?php echo lang('options'); ?></th>
                      </tr>
                    </thead>
                    <tbody>


                    <?php foreach ($payments as $key => $p) { ?>
                      <tr>
                      <?php
                        $currency = Invoice::view_by_id($p->invoice)->currency;
                        $invoice_date = Invoice::view_by_id($p->invoice)->date_saved;
                        $invoice_date = strftime(config_item('date_format'), strtotime($invoice_date));
                        ?>


                        <td class="hidden"><?php echo $p->p_id; ?></td>

                        <td style="border-left: 2px solid <?php echo ('Yes' != $p->refunded) ? '#1AB394' : '#e05d6f'; ?>;">
                         
                        <a class="text-info" href="<?php echo base_url(); ?>payments/view/<?php echo $p->p_id; ?>">
                        <?php echo Invoice::view_by_id($p->invoice)->reference_no; ?></a>
                        </td>

                        <td>
                        <?php echo Client::view_by_id($p->paid_by)->company_name; ?>
                        </td>
                        <td><?php echo strftime(config_item('date_format'), strtotime($p->payment_date)); ?></td>
                        <td><?php echo $invoice_date; ?></td>

                        <td class="col-currency <?php echo ('Yes' == $p->refunded) ? 'text-lt text-danger' : ''; ?>">
                        <strong>
                        <?php echo Applib::format_currency($currency, $p->amount); ?>
                        </strong>
                        </td>

                        <td><?php echo App::get_method_by_id($p->payment_method); ?></td>

                        <td>                        
                            <a class="btn btn-xs btn-primary" href="<?php echo base_url(); ?>payments/view/<?php echo $p->p_id; ?>" data-toggle="tooltip" data-original-title="<?php echo lang('view_payment'); ?>" data-placement="top"><i class="fa fa-eye"></i></a>
                            
                            <a class="btn btn-xs btn-warning" href="<?php echo base_url(); ?>payments/pdf/<?php echo $p->p_id; ?>" data-toggle="tooltip" data-original-title="<?php echo lang('pdf'); ?> <?php echo lang('receipt'); ?>" data-placement="top"><i class="fa fa-file-pdf-o"></i></a>
                             

                            <?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'edit_payments')) { ?>
                            <a class="btn btn-xs btn-success" data-toggle="tooltip" data-original-title="<?php echo lang('edit_payment'); ?>" data-placement="top" href="<?php echo base_url(); ?>payments/edit/<?php echo $p->p_id; ?>"><i class="fa fa-pencil"></i></a> 
                            <?php if ('No' == $p->refunded) { ?>
                             <span data-toggle="tooltip" data-original-title="<?php echo lang('refund'); ?>" data-placement="top"><a class="btn btn-xs btn-twitter" href="<?php echo base_url(); ?>payments/refund/<?php echo $p->p_id; ?>" data-toggle="ajaxModal"><i class="fa fa-warning"></i></a></span>
                            
                            <?php } } ?>
                             <a class="btn btn-xs btn-google" href="<?php echo base_url(); ?>payments/delete/<?php echo $p->p_id; ?>" data-toggle="ajaxModal"><i class="fa fa-trash"></i></a>
                            
                            </td>
                      </tr>
                      <?php }  ?>
                    </tbody>
                  </table>
                </div>
          </div>
   </div>
 

<!-- end -->