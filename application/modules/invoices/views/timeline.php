<!-- Start -->
<section id="content">
    <section class="hbox stretch">        

        <aside>
            <section class="vbox">
                <?php $inv = Invoice::view_by_id($id); ?>
                <header class="header bg-white b-b clearfix hidden-print">
                    <div class="row m-t-sm">
                        <div class="col-sm-8 m-b-xs">

                            <a href="<?php echo site_url(); ?>invoices/view/<?php echo $inv->inv_id; ?>" class="btn btn-sm btn-dark">
                                <?php echo lang('view_invoice'); ?>
                            </a>



                            <?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'edit_all_invoices')) { ?>



                                <?php if ('Yes' == $inv->show_client) { ?>

                                    <a class="btn btn-sm btn-success" href="<?php echo base_url(); ?>invoices/hide/<?php echo $inv->inv_id; ?>" data-toggle="tooltip" data-placement="bottom" data-title="<?php echo lang('hide_to_client'); ?>"><i class="fa fa-eye-slash"></i>
                                    </a>

                                <?php } else { ?>

                                    <a class="btn btn-sm btn-dark" href="<?php echo base_url(); ?>invoices/show/<?php echo $inv->inv_id; ?>" data-toggle="tooltip" data-placement="bottom" data-title="<?php echo lang('show_to_client'); ?>"><i class="fa fa-eye"></i>
                                    </a>

                                <?php } ?>
                            <?php } ?>

                            <?php if ('fully_paid' != Invoice::payment_status($inv->inv_id)) { ?>

                                <?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'pay_invoice_offline')) { ?>

                                    <?php
                                } else {
                                    if ('Yes' == $inv->allow_paypal) { ?>

                                    <a class="btn btn-sm btn-<?php echo config_item('theme_color'); ?>" href="<?php echo base_url(); ?>paypal/pay/<?php echo $inv->inv_id; ?>" data-toggle="ajaxModal"
                                       title="<?php echo lang('via_paypal'); ?>"><?php echo lang('via_paypal'); ?>
                                    </a>

                                <?php }
                                    if ('Yes' == $inv->allow_2checkout) { ?>

                                    <a class="btn btn-sm btn-<?php echo config_item('theme_color'); ?>" href="<?php echo base_url(); ?>checkout/pay/<?php echo $inv->inv_id; ?>" data-toggle="ajaxModal" title="<?php echo lang('via_2checkout'); ?>"><?php echo lang('via_2checkout'); ?></a>
                                <?php }
                                    if ('Yes' == $inv->allow_stripe) { ?>

                                    <button id="customButton" class="btn btn-sm btn-<?php echo config_item('theme_color'); ?>" ><?php echo lang('via_stripe'); ?></button>


                                <?php }
                                    if ('Yes' == $inv->allow_bitcoin) { ?>
                                    <a class="btn btn-sm btn-<?php echo config_item('theme_color'); ?>" href="<?php echo base_url(); ?>bitcoin/pay/<?php echo $inv->inv_id; ?>" data-toggle="ajaxModal" title="<?php echo lang('via_bitcoin'); ?>"><?php echo lang('via_bitcoin'); ?></a>
                                <?php }
                                } ?>
                            <?php } ?>



                            <div class="btn-group">
                                <button class="btn btn-sm btn-<?php echo config_item('theme_color'); ?> dropdown-toggle" data-toggle="dropdown">
                                    <?php echo lang('more_actions'); ?>
                                    <span class="caret"></span></button>
                                <ul class="dropdown-menu">

                                    <?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'email_invoices')) { ?>
                                        <li>
                                            <a href="<?php echo base_url(); ?>invoices/send_invoice/<?php echo $inv->inv_id; ?>" data-toggle="ajaxModal" title="<?php echo lang('email_invoice'); ?>"><?php echo lang('email_invoice'); ?></a>
                                        </li>

                                    <?php } if (User::is_admin() || User::perm_allowed(User::get_id(), 'send_email_reminders')) { ?>
                                        <li>
                                            <a href="<?php echo base_url(); ?>invoices/remind/<?php echo $inv->inv_id; ?>" data-toggle="ajaxModal" title="<?php echo lang('send_reminder'); ?>"><?php echo lang('send_reminder'); ?></a>
                                        </li>
                                    <?php } ?>

                                    <li><a href="<?php echo base_url(); ?>invoices/timeline/<?php echo $inv->inv_id; ?>"><?php echo lang('invoice_history'); ?></a>
                                    </li>


                                    <li>
                                        <a href="<?php echo base_url(); ?>invoices/transactions/<?php echo $inv->inv_id; ?>">
                                            <?php echo lang('payments'); ?>
                                        </a>
                                    </li>




                                </ul>
                            </div>

                            <?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'edit_all_invoices')) { ?>

                                <a href="<?php echo base_url(); ?>invoices/edit/<?php echo $inv->inv_id; ?>" class="btn btn-sm btn-default" data-original-title="<?php echo lang('edit_invoice'); ?>" data-toggle="tooltip" data-placement="bottom">
                                    <i class="fa fa-pencil"></i>
                                </a>

                            <?php } ?>

                            <?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'delete_invoices')) { ?>
                                <a href="<?php echo base_url(); ?>invoices/delete/<?php echo $inv->inv_id; ?>" class="btn btn-sm btn-danger" title="<?php echo lang('delete_invoice'); ?>" data-toggle="ajaxModal">
                                    <i class="fa fa-trash"></i>
                                </a>
                            <?php } ?>



                        </div>
                        <div class="col-sm-3 m-b-xs pull-right">
                            <?php if ('invoicr' == config_item('pdf_engine')) { ?>
                                <a href="<?php echo base_url(); ?>fopdf/invoice/<?php echo $inv->inv_id; ?>" class="btn btn-sm btn-dark pull-right"><i class="fa fa-file-pdf-o"></i> <?php echo lang('pdf'); ?></a>
                            <?php } elseif ('mpdf' == config_item('pdf_engine')) { ?>
                                <a href="<?php echo base_url(); ?>invoices/pdf/<?php echo $inv->inv_id; ?>" class="btn btn-sm btn-dark pull-right"><i class="fa fa-file-pdf-o"></i> <?php echo lang('pdf'); ?></a>
                            <?php } ?>
                        </div>
                    </div>
                </header>



                <section class="scrollable">
                    <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">


                        <!-- Timeline START -->
                        <section class="panel panel-default">
                            <div class="panel-body">


                                <div  id="activity">
                                    <ul class="list-group no-radius m-b-none m-t-n-xxs list-group-lg no-border">
                                        <?php foreach ($activities as $key => $a) { ?>
                                            <li class="list-group-item">

                                                <a class="pull-left thumb-sm avatar">


                <img src="<?php echo User::avatar_url(User::get_id()); ?>" class="img-rounded radius_6">


                                                </a>

                <a href="#" class="clear">
                <small class="pull-right"><?php echo strftime('%b %d, %Y %H:%M:%S', strtotime($a->activity_date)); ?></small>
                                        <strong class="block m-l-xs"><?php echo ucfirst(User::displayName($a->user)); ?></strong>
                                                    <small class="m-l-xs">
                                                        <?php
                                                        if ('' != lang($a->activity)) {
                                                            if (!empty($a->value1)) {
                                                                if (!empty($a->value2)) {
                                                                    echo sprintf(lang($a->activity), '<em>'.$a->value1.'</em>', '<em>'.$a->value2.'</em>');
                                                                } else {
                                                                    echo sprintf(lang($a->activity), '<em>'.$a->value1.'</em>');
                                                                }
                                                            } else {
                                                                echo lang($a->activity);
                                                            }
                                                        } else {
                                                            echo $a->activity;
                                                        }
                                                        ?>
                                                    </small>
                                                </a>
                                            </li>
                                        <?php } ?>

                                    </ul>
                                </div>





                            </div>
                        </section>
                    </div>
                </section>
                <!-- End display details -->
            </section> </aside>
        
            <aside class="aside-md bg-white b-r hidden-print" id="subNav">
            <header class="dk header b-b">
                <?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'add_invoices')) { ?>
                    <a href="<?php echo base_url(); ?>invoices/add" data-original-title="<?php echo lang('new_invoice'); ?>" data-toggle="tooltip" data-placement="top" class="btn btn-icon btn-<?php echo config_item('theme_color'); ?> btn-sm pull-right"><i class="fa fa-plus"></i></a>
                <?php } ?>
                <p class="h4"><?php echo lang('all_invoices'); ?></p>
            </header>

            <section class="vbox">
                <section class="scrollable w-f">
                    <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">

                        <?php echo $this->load->view('sidebar/invoices', $invoices); ?>

                    </div></section>
            </section>
        </aside>
    
    </section> <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>
<?php if (!User::is_admin() && 'Yes' == $inv->allow_stripe) { ?>

    <script src="https://checkout.stripe.com/checkout.js"></script>
<?php } ?>

<!-- end -->
