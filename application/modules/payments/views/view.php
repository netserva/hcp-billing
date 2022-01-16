          <div class="box">
            <div class="box-header clearfix">               
                <?php $i = Payment::view_by_id($id); ?>
                <?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'edit_payments')) { ?>

                    <a href="<?php echo base_url(); ?>payments/edit/<?php echo $i->p_id; ?>" title="<?php echo lang('edit_payment'); ?>" class="btn btn-sm btn-<?php echo config_item('theme_color'); ?>">
                  <i class="fa fa-pencil text-white"></i> <?php echo lang('edit_payment'); ?></a>

                  <?php if ('No' == $i->refunded) { ?>
                  <a href="<?php echo base_url(); ?>payments/refund/<?php echo $i->p_id; ?>" title="<?php echo lang('refund'); ?>" class="btn btn-sm btn-<?php echo config_item('theme_color'); ?>" data-toggle="ajaxModal">
                  <i class="fa fa-warning text-white"></i> <?php echo lang('refund'); ?></a>
                  <?php } ?>

                  <?php } ?>

                  <a href="<?php echo base_url(); ?>payments/pdf/<?php echo $i->p_id; ?>" title="<?php echo lang('pdf'); ?>" class="btn btn-sm btn-<?php echo config_item('theme_color'); ?>">
                  <i class="fa fa-file-pdf-o text-white"></i> <?php echo lang('pdf'); ?> <?php echo lang('receipt'); ?></a>
            </div> 
            
            <div class="box-body">
      
              <!-- Start Payment -->
              <?php if ('Yes' == $i->refunded) { ?>
              <div class="alert alert-danger hidden-print">
              <button type="button" class="close" data-dismiss="alert">×</button>
              <i class="fa fa-warning"></i> <?php echo lang('transaction_refunded'); ?>
              </div>
              <?php } ?>


              <div class="column content-column">
                <div class="details-page">
                  <div class="details-container clearfix mb_20" id="payment_view">
                    <div class="row">
                      <div class="col-md-6">
                          <table class="table">
                            <tbody>
                              <tr><td class="line_label"><?php echo lang('payment_date'); ?></td><td><?php echo strftime(config_item('date_format').' %H:%M:%S', strtotime($i->created_date)); ?></td></tr>
                              <tr><td class="line_label"><?php echo lang('transaction_id'); ?></td><td><?php echo $i->trans_id; ?></td></tr>
                              <tr><td class="line_label"><?php echo lang('received_from'); ?></td><td><strong><a href="<?php echo base_url(); ?>companies/view/<?php echo $i->paid_by; ?>">
                          <?php echo ucfirst(Client::view_by_id($i->paid_by)->company_name); ?></a></strong></td></tr>
                              <tr><td class="line_label"><?php echo lang('payment_mode'); ?></td><td><?php echo App::get_method_by_id($i->payment_method); ?></td></tr>
                              <tr><td class="line_label"><?php echo lang('notes'); ?></td><td><?php echo ($i->notes) ? $i->notes : 'NULL'; ?></td></tr>
                              <?php if ($i->attached_file) { ?>
                              <tr><td class="line_label"><?php echo lang('attachment'); ?></td><td><a href="<?php echo base_url(); ?>resource/uploads/<?php echo $i->attached_file; ?>" target="_blank">
                          <?php echo $i->attached_file; ?>
                          </a></td></tr>
                              <?php } ?>
                            </tbody>
                          </table>
                      </div>
                      <div class="col-md-6">                
                           <div class="bg-<?php echo config_item('theme_color'); ?> payment_received">
                                    <span> <?php echo lang('amount_received'); ?></span><br>
                                    <?php $cur = Invoice::view_by_id($i->invoice)->currency; ?>
                                    <span style="font-size:16pt;"><?php echo Applib::format_currency($cur, $i->amount); ?></span>
                            </div>                       
                      </div>
                    </div> 
                      


                        <div class="mt_100">
                           <h4><?php echo lang('payment_for'); ?></h4>
                            <div style="clear:both;"></div>
                          </div>

                          <table class="payment_details" cellpadding="0" cellspacing="0" border="0">
                            <thead>
                              <tr class="h_40">
                                <td class="p_item">
                                  <?php echo lang('invoice_code'); ?>
                                </td>
                                <td class="p_item_r">
                                  <?php echo lang('invoice_date'); ?>
                                </td>
                                <td class="p_item_r">
                                  <?php echo lang('due_amount'); ?>
                                </td>
                                <td class="p_item_r">
                                  <?php echo lang('paid_amount'); ?>
                                </td>
                              </tr>
                            </thead>
                            <tbody>
                              <tr class="p_border">
                                <td class="pp_10" valign="top">
                                <a href="<?php echo base_url(); ?>invoices/view/<?php echo $i->invoice; ?>"><?php echo Invoice::view_by_id($i->invoice)->reference_no; ?></a></td>
                                <td class="p_td" valign="top">
                <?php echo strftime(config_item('date_format'), strtotime(Invoice::view_by_id($i->invoice)->date_saved)); ?>
                                </td>
                                <td class="p_td" valign="top">
                                  <span>
                <?php echo Applib::format_currency($cur, Invoice::get_invoice_due_amount($i->invoice)); ?> </span>
                                </td>
                                <td class="p_td_r" valign="top">
                                  <span><?php echo Applib::format_currency($cur, $i->amount); ?></span>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
               </div> 
              <!-- End Payment -->
         
        