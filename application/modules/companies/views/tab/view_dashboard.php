


                            <div class="row proj-summary-band">

                                <div class="col-md-3 text-center">
                                    <label class="text-muted"><?php echo lang('this_month'); ?></label>
                                    <h4 class="cursor-pointer text-open small"><?php echo lang('payments'); ?></h4>
                                    <h4><strong>
                            <?php echo Applib::format_currency($cur->code, Client::month_amount(date('Y'), date('m'), $i->co_id)); ?>
                        </strong>
                    </h4>
                                </div>

                                <div class="col-md-3 text-center">
                                <label class="text-muted"><?php echo lang('balance_due'); ?></label>
                                    <h4 class="cursor-pointer text-open small">- <?php echo lang('total'); ?></h4>
                                    <h4><strong><?php echo Applib::format_currency($cur->code, $due); ?></strong></h4>
                                </div>
 

                                <div class="col-md-3 text-center">
                                <label class="text-muted"><?php echo lang('received_amount'); ?></label>
                                    <h4 class="cursor-pointer text-success small"><?php echo lang('total_receipts'); ?></h4>
                                    <h4><strong><?php echo Applib::format_currency($cur->code, Client::amount_paid($i->co_id)); ?></strong></h4>
                                </div>

                            </div>



                            <div class="row mt_10">
                                <div class="col-lg-6">

                                    <section class="panel panel-default">
                                        <header class="panel-heading"><?php echo $i->company_name; ?> - <?php echo lang('details'); ?></header>



                                        <ul class="list-group no-radius">
                                            <li class="list-group-item">
                                                <span class="pull-right text"><?php echo $i->company_name; ?></span>
                                                <span class="text-muted">
                                                    <?php echo (0 == $i->individual) ? lang('company_name') : lang('full_name'); ?>
                                                </span>
                                            </li>

                                            <?php if (0 == $i->individual) { ?>
                                                <li class="list-group-item">
                                                    <span class="pull-right">
                                                    <?php echo ($i->primary_contact) ? User::displayName($i->primary_contact) : ''; ?>
                                                    </span>
                                                    <span class="text-muted">
                                                        <?php echo lang('contact_person'); ?>
                                                    </span>
                                            </li>
                                            <?php } ?>

                                            <li class="list-group-item">
                                                <span class="pull-right">
                                        <a href="mailto:<?php echo $i->company_email; ?>"><?php echo $i->company_email; ?></a>
                                                </span>
                                                <span class="text-muted"><?php echo lang('email'); ?></span>

                                            </li>


                                            <li class="list-group-item">
                                                <span class="pull-right">
                                        <a href="tel:<?php echo $i->company_phone; ?>"><?php echo $i->company_phone; ?></a>
                                                </span>
                                                <span class="text-muted"><?php echo lang('phone'); ?></span>

                                            </li>
                                            <li class="list-group-item">
                                                <span class="pull-right">
                                        <a href="tel:<?php echo $i->company_mobile; ?>"><?php echo $i->company_mobile; ?></a>
                                                </span>
                                                <span class="text-muted"><?php echo lang('mobile_phone'); ?></span>

                                            </li>

                                            <li class="list-group-item">
                                                <span class="pull-right">
                                        <a href="tel:<?php echo $i->company_fax; ?>"><?php echo $i->company_fax; ?></a>
                                                </span>
                                                <span class="text-muted"><?php echo lang('fax'); ?></span>

                                            </li>

                                            <li class="list-group-item">
                                                <span class="pull-right">
                                        <?php echo $i->VAT; ?>
                                                </span>
                                                <span class="text-muted"><?php echo lang('tax'); ?> <sup>No</sup></span>

                                            </li>

                                            <li class="list-group-item">
                                                <span class="pull-right">
                                        <?php echo nl2br($i->company_address); ?>
                                                </span>
                                                <span class="text-muted"><?php echo lang('address'); ?></span>

                                            </li>

                                            <li class="list-group-item">
                                                <span class="pull-right">
                                        <?php echo $i->city; ?>
                                                </span>
                                                <span class="text-muted"><?php echo lang('city'); ?></span>

                                            </li>

                                            <li class="list-group-item">
                                                <span class="pull-right">
                                        <?php echo $i->zip; ?>
                                                </span>
                                                <span class="text-muted"><?php echo lang('zip_code'); ?></span>

                                            </li>

                                            <li class="list-group-item">
                                                <span class="pull-right">
                                        <?php echo $i->state; ?>
                                                </span>
                                                <span class="text-muted"><?php echo lang('state_province'); ?></span>

                                            </li>

                                            <li class="list-group-item">
                                                <span class="pull-right">
                                        <?php echo $i->country; ?>
                                                </span>
                                                <span class="text-muted"><?php echo lang('country'); ?></span>

                                            </li>


                                        </ul>

                                    </section>

                                </div>
                                <!-- End details C1-->


                                <!-- start extra fields-->

                                <div class="col-sm-6">
                                    <section class="panel panel-default">
                                        <header class="panel-heading"><?php echo lang('additional_fields'); ?></header>


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

                                    </section>
                                </div>

                                <!-- end extra fields -->



                            </div>
                            <div class="line line-dashed line-lg pull-in"></div>

                            <div class="small text-muted panel-body m-sm">
                                <p><?php echo ('' == $i->notes) ? 'No Notes' : nl2br_except_pre($i->notes); ?></p>
                            </div>
