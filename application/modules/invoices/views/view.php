
 <?php $client = User::is_client(); ?>  
        <div class="box">
                <div class="box-header clearfix hidden-print">
                    
                    <?php $inv = Invoice::view_by_id($id); ?>
                    <?php $l = Client::view_by_id($inv->client)->language; ?>
                    <?php $client_cur = Client::view_by_id($inv->client)->currency; ?>
                    <?php $use_modal = ['bitcoin', 'paypal', 'coinpayments', 'checkout']; ?>
                    <?php $colors = ['btn-google', 'btn-twitter', 'btn-default', 'btn-primary',
                        'btn-google', 'btn-twitter', 'btn-linkedin', 'btn-warning', 'btn-foursquare',
                        'btn-dropbox', 'btn-google', 'btn-twitter', 'btn-default', 'btn-primary', 'btn-google',
                        'btn-twitter', 'btn-linkedin', 'btn-warning', 'btn-foursquare', 'btn-dropbox', ];
                    ?>

                    <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-11">
                    <div class="btn-group pull-right">

                    <div class="btn-group">

                    <button class="btn btn-sm btn-<?php echo config_item('theme_color'); ?>  btn-responsive dropdown-toggle"
                            data-toggle="dropdown"><?php echo lang('options'); ?> <span class="caret"></span>
                    </button>

                    <ul class="dropdown-menu">

                        <?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'email_invoices')) { ?>

                            <li>
                                <a href="<?php echo base_url(); ?>invoices/send_invoice/<?php echo $inv->inv_id; ?>" data-toggle="ajaxModal"
                                title="<?php echo lang('email_invoice'); ?>"><i class="fa fa-paper-plane-o"></i> <?php echo lang('email_invoice'); ?>
                                </a>
                            </li>
                        <?php } ?>


                        <?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'send_email_reminders')) { ?>

                            <li>
                                <a href="<?php echo base_url(); ?>invoices/remind/<?php echo $inv->inv_id; ?>" data-toggle="ajaxModal"
                                title="<?php echo lang('send_reminder'); ?>"><i class="fa fa-envelope-o"></i> <?php echo lang('send_reminder'); ?>
                                </a>
                            </li>
                        <?php } ?>
                    

                        <li>
                            <a href="<?php echo base_url(); ?>invoices/transactions/<?php echo $inv->inv_id; ?>">
                            <i class="fa fa-credit-card"></i> <?php echo lang('payments'); ?>
                            </a>
                        </li>

                        <?php if (User::is_admin() && Invoice::get_invoice_due_amount($inv->inv_id) > 0) { ?>

                            <li>
                                <a href="<?php echo base_url(); ?>invoices/mark_as_paid/<?php echo $inv->inv_id; ?>" data-toggle="ajaxModal">
                                <i class="fa fa-money"></i> <?php echo lang('mark_as_paid'); ?>
                                </a>
                            </li>

                            <li>
                                <a href="<?php echo base_url(); ?>invoices/cancel/<?php echo $inv->inv_id; ?>" data-toggle="ajaxModal">
                                <i class="fa fa-ban"></i> <?php echo lang('cancelled'); ?>
                                </a>
                            </li>

                        <?php } ?>
                        
                        <?php if ('Yes' == $inv->recurring) { ?>
                                <?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'edit_all_invoices')) { ?>
                                    <li>
                                    <a href="<?php echo base_url(); ?>invoices/stop_recur/<?php echo $inv->inv_id; ?>"
                                    title="<?php echo lang('stop_recurring'); ?>" data-toggle="ajaxModal">
                                        <i class="fa fa-retweet"></i> <?php echo lang('stop_recurring'); ?>
                                    </a>
                                    </li>
                                <?php }  } ?>


                                <?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'edit_all_invoices')) { ?>
                              <li>
                                <a href="<?php echo base_url(); ?>invoices/edit/<?php echo $inv->inv_id; ?>"
                                data-original-title="<?php echo lang('edit_invoice'); ?>"
                                data-toggle="tooltip" data-placement="bottom"><i class="fa fa-pencil"></i> <?php echo lang('edit'); ?>
                                </a>
                                </li>

                                <li>
                                <a href="<?php echo base_url(); ?>invoices/items/insert/<?php echo $inv->inv_id; ?>"
                                title="<?php echo lang('item_quick_add'); ?>" data-toggle="ajaxModal">
                                    <i class="fa fa-plus"></i> <?php echo lang('add_item'); ?>
                                </a>
                                </li>

                                <li>
                                <?php } if (User::is_admin() || User::perm_allowed(User::get_id(), 'delete_invoices')) { ?>

                                <a href="<?php echo base_url(); ?>invoices/delete/<?php echo $inv->inv_id; ?>" 
                                title="<?php echo lang('delete_invoice'); ?>" data-toggle="ajaxModal"><i class="fa fa-trash"></i> <?php echo lang('delete'); ?>
                                </a>
                                </li>

                                <?php }  if (User::is_admin() || User::perm_allowed(User::get_id(), 'edit_all_invoices')) { ?>

                            <?php if ('Yes' == $inv->show_client) { ?>
                                <li>
                                <a href="<?php echo base_url(); ?>invoices/hide/<?php echo $inv->inv_id; ?>"> <i class="fa fa-eye-slash"></i> <?php echo lang('hide_to_client'); ?></a>
                                </li>

                            <?php } else { ?>
                                <li>
                                <a href="<?php echo base_url(); ?>invoices/show/<?php echo $inv->inv_id; ?>"
                                data-toggle="tooltip" data-original-title="<?php echo lang('show_to_client'); ?>" data-placement="bottom">
                                    <i class="fa fa-eye"></i> <?php echo lang('show_to_client'); ?>
                                </a>
                                </li>
                            <?php } ?>

                            <?php } ?>

                                                
                            </ul>
                            </div>
 

                            <?php if (Invoice::get_invoice_due_amount($inv->inv_id) > 0) { ?>

                            <?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'pay_invoice_offline')
                                && (Invoice::get_invoice_due_amount($inv->inv_id) > 0)) { ?>

                                <a class="btn btn-sm bg-green btn-responsive"
                                href="<?php echo base_url(); ?>invoices/pay/<?php echo $inv->inv_id; ?>" data-toggle="tooltip"
                                data-original-title="<?php echo lang('pay_invoice'); ?>" data-placement="bottom">
                                    <i class="fa fa-money"></i> <?php echo lang('add_payment'); ?>
                                </a>

                            <?php }

                            if (User::is_client()) {
                                $credit = Client::view_by_id($inv->client)->transaction_value;
                                if ($credit > 0) { ?>
                                        <a class="btn btn-sm btn-success btn-responsive"
                                        href="<?php echo base_url(); ?>invoices/apply_credit/<?php echo $inv->inv_id; ?>" data-toggle="ajaxModal">
                                            <?php echo lang('credit_balance').' ('.Applib::format_currency($client_cur, Applib::client_currency($client_cur, $credit)).') '.lang('pay'); ?>
                                        </a>
                               <?php }
                            }

                            foreach (Plugin::payment_gateways() as $k => $gateway) { ?>
                            <a class="btn btn-sm <?php echo $colors[$k]; ?> btn-responsive" <?php if (in_array($gateway->system_name, $use_modal)) {
                                echo 'data-toggle="ajaxModal"';
                            } ?>
                                href="<?php echo base_url().$gateway->system_name; ?>/pay/<?php echo $inv->inv_id; ?>"> <?php echo $gateway->name; ?>
                            </a> 
                            <?php } } ?>

                            <?php if ('invoicr' == config_item('pdf_engine')) { ?>
                                <a href="<?php echo base_url(); ?>invoices/pdf/<?php echo $inv->inv_id; ?>" class="btn btn-sm btn-<?php echo config_item('theme_color'); ?> btn-responsive">
                                    <i class="fa fa-file-pdf-o"></i> <?php echo lang('pdf'); ?>
                                </a> 
                            </div>
                            <?php } ?> 
                        </div>
                    </div>
                  </div>



                <div class="box-body ie-details">
                    <?php if ('fully_paid' == Invoice::payment_status($inv->inv_id)) { ?>
                        <div id="ember2686" disabled="false" class="ribbon ember-view popovercontainer" data-original-title="" title="">  
                            <div class="ribbon-inner ribbon-success">
                            <?php echo lang('paid'); ?>
                        </div>
                        </div>
                        <?php } ?>

                        <?php if ('fully_paid' != Invoice::payment_status($inv->inv_id) && 'Cancelled' != $inv->status) { ?>
                        <div id="ember2686" disabled="false" class="ribbon ember-view popovercontainer" data-original-title="" title="">  
                            <div class="ribbon-inner ribbon-danger">
                            <?php echo lang('unpaid'); ?>
                        </div>
                        </div>
                        <?php } ?>

                        <!-- Start Display Details -->
                        <?php if ('Cancelled' != $inv->status) { ?>
                        <?php
                        if (!$this->session->flashdata('message')) {
                            if (strtotime($inv->due_date) < time() && Invoice::get_invoice_due_amount($inv->inv_id) > 0) {
                                ?>
                                <div class="alert alert-warning hidden-print">
                                    <button type="button" class="close" data-dismiss="alert">×</button> <i class="fa fa-warning"></i>
                                    <?php echo lang('invoice_overdue'); ?>
                                </div>
                            <?php
                            } ?>
                        <?php
                        } ?>
                        <?php } else { ?>
                            <div class="alert alert-danger hidden-print">
                                <button type="button" class="close" data-dismiss="alert">×</button> <i class="fa fa-warning"></i>
                                This Invoice is Cancelled!
                            </div>

                        <?php } ?>

                    
                        <div class="row">
                            <div class="col-xs-6">
                                <div style="height: <?php echo config_item('invoice_logo_height'); ?>px">
                                    <img class="ie-logo img-responsive" src="<?php echo base_url(); ?>resource/images/logos/<?php echo config_item('invoice_logo'); ?>">
                                </div>
                            </div>
                            <div class="col-xs-6 text-right">

                              
                                <div>
                                    <?php echo lang('reference'); ?>
                                    <span class="col-xs-2 no-gutter-right pull-right">
                                    <strong>
                                        <?php echo $inv->reference_no; ?>
                                    </strong>
                                    </span>
                                </div>


                                <div>
                                    <?php echo lang('invoice_date'); ?>
                                    <span class="col-xs-2 no-gutter-right pull-right">
                                    <strong>
                                        <?php echo strftime(config_item('date_format'), strtotime($inv->date_saved)); ?>
                                    </strong>
                                    </span>
                                </div>

                                <?php if ('Yes' == $inv->recurring) { ?>
                                    <div>
                                        <?php echo lang('recur_next_date'); ?>
                                        <span class="col-xs-2 no-gutter-right pull-right">
                                    <strong>
                                        <?php echo strftime(config_item('date_format'), strtotime($inv->recur_next_date)); ?>
                                    </strong>
                                    </span>
                                    </div>
                                <?php } ?>

                                <div>
                                    <?php echo lang('payment_due'); ?>
                                    <span class="col-xs-2 no-gutter-right pull-right">
                                        <strong>
                                            <?php echo strftime(config_item('date_format'), strtotime($inv->due_date)); ?>
                                        </strong>
                                        </span>
                                </div>


                                <div>
                                    <?php echo lang('payment_status'); ?>
                                    <span class="col-xs-2 no-gutter-right pull-right">
                                        <span class="label bg-success">
                                        <?php echo lang(Invoice::payment_status($inv->inv_id)); ?>
                                        </span></span>
                                </div>
                            </div>
                        </div>
 

                        <div class="m-t">
                            <div class="row">

                                   <div class="col-xs-6">
                                  
                                        <h4>
                                            <?php echo (config_item('company_legal_name_'.$l)
                                                ? config_item('company_legal_name_'.$l)
                                                : config_item('company_legal_name'));
                                            ?>
                                        </h4>
                                        <p>

                                 

                                <span class="col-xs-12 no-gutter">
                                <?php echo (config_item('company_address_'.$l)
                                    ? config_item('company_address_'.$l)
                                    : config_item('company_address'));
                                ?><br>

                                    <?php echo (config_item('company_city_'.$l)
                                        ? config_item('company_city_'.$l)
                                        : config_item('company_city'));
                                    ?>

                                    <?php if ('' != config_item('company_zip_code_'.$l) || '' != config_item('company_zip_code')) { ?>
                                        , <?php echo (config_item('company_zip_code_'.$l)
                                            ? config_item('company_zip_code_'.$l)
                                            : config_item('company_zip_code'));
                                        ?>
                                    <?php } ?><br>

                                    <?php if ('' != config_item('company_state_'.$l) || '' != config_item('company_state')) { ?>

                                        <?php echo (config_item('company_state_'.$l)
                                            ? config_item('company_state_'.$l)
                                            : config_item('company_state')); ?>,
                                    <?php } ?>

                                    <?php echo (config_item('company_country_'.$l)
                                        ? config_item('company_country_'.$l)
                                        : config_item('company_country')); ?>
                            </span>
                            <br>
                                 
                                <span class="col-xs-12 no-gutter">
                                <?php echo lang('phone'); ?>: 
                                <a href="tel:<?php echo (config_item('company_phone_'.$l)
                                    ? config_item('company_phone_'.$l)
                                    : config_item('company_phone')); ?>">

                                    <?php echo (config_item('company_phone_'.$l)
                                        ? config_item('company_phone_'.$l)
                                        : config_item('company_phone')); ?>
                                </a><br>

                                    <?php if ('' != config_item('company_phone_2_'.$l) || '' != config_item('company_phone_2')) { ?>
                                        , <a href="tel:<?php echo (config_item('company_phone_2_'.$l)
                                            ? config_item('company_phone_2_'.$l)
                                            : config_item('company_phone_2')); ?>">

                                            <?php echo (config_item('company_phone_2_'.$l)
                                                ? config_item('company_phone_2_'.$l)
                                                : config_item('company_phone_2')); ?>
                                        </a><br>
                                    <?php } ?>
                            </span>
                           

                                            <?php if ('' != config_item('company_fax_'.$l) || '' != config_item('company_fax')) { ?>
                                              <span class="col-xs-12 no-gutter"><?php echo lang('fax'); ?>: 
                                <a href="tel:<?php echo (config_item('company_fax_'.$l) ? config_item('company_fax_'.$l) : config_item('company_fax')); ?>">
                                    <?php echo (config_item('company_fax_'.$l)
                                        ? config_item('company_fax_'.$l)
                                        : config_item('company_fax')); ?>
                                </a>
                            </span>
                                            <?php } ?>
                                            <?php if ('' != config_item('company_registration_'.$l) || '' != config_item('company_registration')) { ?>
                                             
                                                <span class="col-xs-12 no-gutter">
                                                <?php echo lang('company_registration'); ?>: 

                                <a href="tel:<?php echo (config_item('company_registration_'.$l) ? config_item('company_registration_'.$l) : config_item('company_registration')); ?>">
                                    <?php echo (config_item('company_registration_'.$l)
                                        ? config_item('company_registration_'.$l)
                                        : config_item('company_registration')); ?>
                                </a>
                            </span>
                            <?php } ?>

                            <?php if ('' != config_item('company_vat_'.$l) || '' != config_item('company_vat')) { ?>

                            <span class="col-xs-12 no-gutter">
                            <?php echo lang('company_vat'); ?>: 
                            <?php echo (config_item('company_vat_'.$l)
                                ? config_item('company_vat_'.$l)
                                : config_item('company_vat')); ?><br>
                            <span>                           

                            <?php } ?>
                                        </p>
                                    </div>
                                

                                <div class="col-xs-6" id="invoice_client">
                                    
                                    <h4><?php echo Client::view_by_id($inv->client)->company_name; ?></h4>
                                      <span>
                                        <?php echo Client::view_by_id($inv->client)->company_address; ?><br>
                                                <?php echo Client::view_by_id($inv->client)->city; ?>
                                                <?php if ('' != Client::view_by_id($inv->client)->zip) {
                                    echo ', '.Client::view_by_id($inv->client)->zip;
                                } ?><br>

                                                <?php if ('' != Client::view_by_id($inv->client)->state) {
                                    echo Client::view_by_id($inv->client)->state.', ';
                                } ?>
                                                <?php echo Client::view_by_id($inv->client)->country; ?>
                                    </span>
                                        <br>
                                            <span>
                                            <?php echo lang('phone'); ?>: 
                                        <a href="tel:<?php echo Client::view_by_id($inv->client)->company_phone; ?>">
                                            <?php echo ucfirst(Client::view_by_id($inv->client)->company_phone); ?>
                                        </a>&nbsp;
                                    </span>
                                    <br>

                                        <?php if ('' != Client::view_by_id($inv->client)->company_fax) { ?>
                                            <span>
                                            <?php echo lang('fax'); ?>: 
                                        <a href="tel:<?php echo Client::view_by_id($inv->client)->company_fax; ?>">
                                            <?php echo ucfirst(Client::view_by_id($inv->client)->company_fax); ?>
                                        </a>&nbsp;
                                    </span><br>
                                        <?php } ?>

                                        <?php if ('' != Client::view_by_id($inv->client)->VAT) { ?>
                                            <span>
                                            <?php echo lang('company_vat'); ?>: 
                                            <?php echo Client::view_by_id($inv->client)->VAT; ?>
                                    </span>
                                        <?php } ?>

                                   
                                </div>
                               
                            </div>
                        </div>
                        <?php $showtax = 'TRUE' == config_item('show_invoice_tax') ? true : false; ?>
                        <div class="line"></div>
                        <table id="inv-details" class="table sorted_table small" type="invoices"><thead>
                            <tr>
                                <th></th>
                                <?php if ($showtax) { ?>
                                    <th width="20%"><?php echo lang('item_name'); ?> </th>
                                    <th width="25%"><?php echo lang('description'); ?> </th>
                                    <th width="7%" class="text-right"><?php echo lang('qty'); ?> </th>
                                    <th width="10%" class="text-right"><?php echo lang('tax_rate'); ?> </th>
                                    <th width="12%" class="text-right"><?php echo lang('unit_price'); ?> </th>
                                    <th width="12%" class="text-right"><?php echo lang('tax'); ?> </th>
                                    <th width="12%" class="text-right"><?php echo lang('total'); ?> </th>
                                <?php } else { ?>
                                    <th width="25%"><?php echo lang('item_name'); ?> </th>
                                    <th width="35%"><?php echo lang('description'); ?> </th>
                                    <th width="7%" class="text-right"><?php echo lang('qty'); ?> </th>
                                    <th width="12%" class="text-right"><?php echo lang('unit_price'); ?> </th>
                                    <th width="12%" class="text-right"><?php echo lang('total'); ?> </th>
                                <?php } ?>
                                <th class="text-right inv-actions"></th>
                            </tr> </thead> <tbody>
                            <?php foreach (Invoice::has_items($inv->inv_id) as $key => $item) { ?>
                                <tr class="sortable" data-name="<?php echo $item->item_name; ?>" data-id="<?php echo $item->item_id; ?>">
                                    <td class="drag-handle"><i class="fa fa-reorder"></i></td>
                                    <td>

                                        <?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'edit_all_invoices')) { ?>
                                            <a class="text-info" href="<?php echo base_url(); ?>invoices/items/edit/<?php echo $item->item_id; ?>" data-toggle="ajaxModal"><?php echo $item->item_name; ?>
                                            </a>
                                        <?php } else { ?>
                                            <?php echo $item->item_name; ?>
                                        <?php } ?>
                                    </td>
                                    <td class="text-muted"><?php echo nl2br($item->item_desc); ?></td>

                                    <td class="text-right"><?php echo Applib::format_quantity($item->quantity); ?></td>
                                    <?php if ($showtax) { ?>
                                        <td class="text-right"><?php echo Applib::format_tax($item->item_tax_rate).'%'; ?></td>
                                    <?php } ?>
                                    <td class="text-right">
                                    <?php if (!User::is_admin() && !User::is_staff()) {
                                    echo Applib::format_currency($client_cur, Applib::client_currency($client_cur, $item->unit_cost));
                                } else {
                                            echo Applib::format_currency($inv->currency, $item->unit_cost);
                                        }
                                    ?>                                     
                                    </td>
                                    <?php if ($showtax) { ?>
                                        <td class="text-right">
                                        <?php if (!User::is_admin() && !User::is_staff()) {
                                        echo Applib::format_currency($client_cur, Applib::client_currency($client_cur, $item->item_tax_total));
                                    } else {
                                            echo Applib::format_currency($inv->currency, $item->item_tax_total);
                                        }
                                       ?>   
                                     </td>
                                    <?php } ?>
                                    <td class="text-right">
                                    <?php if (!User::is_admin() && !User::is_staff()) {
                                           echo Applib::format_currency($client_cur, Applib::client_currency($client_cur, $item->total_cost));
                                       } else {
                                            echo Applib::format_currency($inv->currency, $item->total_cost);
                                        }
                                       ?>   
                                      </td>

                                    <td>
                                        <?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'edit_all_invoices')) { ?>
                                            <a class="hidden-print"
                                               href="<?php echo base_url(); ?>invoices/items/delete/<?php echo $item->item_id; ?>/<?php echo $item->invoice_id; ?>" data-toggle="ajaxModal"><i class="fa fa-trash-o text-danger"></i>
                                            </a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>

                            <?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'edit_all_invoices')) { ?>

                                <?php if ('Paid' != $inv->status) { ?>
                                    <tr class="hidden-print">
                                        <?php $attributes = ['class' => 'bs-example form-horizontal'];
                                        echo form_open(base_url().'invoices/items/add', $attributes);
                                        ?>
                                        <input type="hidden" name="invoice_id" value="<?php echo $inv->inv_id; ?>">
                                        <input type="hidden" name="item_order" value="<?php echo count(Invoice::has_items($inv->inv_id)) + 1; ?>">
                                        <input id="hidden-item-name" type="hidden" name="item_name">
                                        <td></td>
                                        <td><input id="auto-item-name" data-scope="invoices" type="text" placeholder="<?php echo lang('item_name'); ?>" class="typeahead form-control"></td>

                                         <td><textarea id="auto-item-desc" rows="1" name="item_desc" placeholder="<?php echo lang('item_description'); ?>" class="form-control js-auto-size"></textarea></td>

                                        <td><input id="auto-quantity" type="text" name="quantity" value="1" class="form-control"></td>
                                        <?php if ($showtax) { ?>
                                            <td>
                                                <select name="item_tax_rate" class="form-control m-b">
                                                    <option value="0.00"><?php echo lang('none'); ?></option>
                                                    <?php
                                                    foreach (Invoice::get_tax_rates() as $key => $tax) {
                                                        ?>
                                                        <option value="<?php echo $tax->tax_rate_percent; ?>" <?php echo config_item('default_tax') == $tax->tax_rate_percent ? ' selected="selected"' : ''; ?>><?php echo $tax->tax_rate_name; ?></option>
                                                    <?php
                                                    } ?>
                                                </select>
                                            </td>
                                        <?php } ?>
                                        <td><input id="auto-unit-cost" type="text" name="unit_cost" required placeholder="50.56" class="form-control"></td>
                                        <?php if ($showtax) { ?>
                                            <td><input type="text" name="tax" placeholder="0.00" readonly="" class="form-control"></td>
                                        <?php } ?>
                                        <td></td>
                                        <td><button type="submit" class="btn btn-<?php echo config_item('theme_color'); ?>"><i class="fa fa-check"></i> <?php echo lang('save'); ?></button></td>
                                        </form>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                            <tr>
                                <td colspan="<?php echo $showtax ? '7' : '5'; ?>" class="text-right no-border"><strong><?php echo lang('sub_total'); ?></strong></td>
                                <td class="text-right">
                                    <?php if (!User::is_admin() && !User::is_staff()) {
                                                        echo Applib::format_currency($client_cur, Applib::client_currency($client_cur, Invoice::get_invoice_subtotal($inv->inv_id)));
                                                    } else {
                                            echo Applib::format_currency($inv->currency, Invoice::get_invoice_subtotal($inv->inv_id));
                                        }
                                     ?>  
                                </td>

                                <td></td>
                            </tr>
                            <?php if ($inv->tax > 0.00) { ?>
                                <tr>
                                    <td colspan="<?php echo $showtax ? '7' : '5'; ?>" class="text-right no-border">
                                        <strong><?php echo config_item('tax_name'); ?> (<?php echo Applib::format_tax($inv->tax); ?>%)</strong></td>
                                    <td class="text-right">
                                    <?php if (!User::is_admin() && !User::is_staff()) {
                                         echo Applib::format_currency($client_cur, Applib::client_currency($client_cur, Invoice::get_invoice_tax($inv->inv_id)));
                                     } else {
                                            echo Applib::format_currency($inv->currency, Invoice::get_invoice_tax($inv->inv_id));
                                        }
                                     ?>                                     
                                    </td>

                                    <td></td>

                                </tr>
                            <?php } ?>

                             <?php if ($inv->tax2 > 0.00) { ?>
                                <tr>
                                    <td colspan="<?php echo $showtax ? '7' : '5'; ?>" class="text-right no-border">
                                        <strong><?php echo lang('tax'); ?> 2 (<?php echo Applib::format_tax($inv->tax2); ?>%)</strong></td>
                                    <td class="text-right">
                                    <?php if (!User::is_admin() && !User::is_staff()) {
                                         echo Applib::format_currency($client_cur, Applib::client_currency($client_cur, Invoice::get_invoice_tax($inv->inv_id, 'tax2')));
                                     } else {
                                            echo Applib::format_currency($inv->currency, Invoice::get_invoice_tax($inv->inv_id, 'tax2'));
                                        }
                                     ?>                                        
                                    </td>

                                    <td></td>

                                </tr>
                            <?php } ?>

                            <?php if ($inv->discount > 0) { ?>
                                <tr>
                                    <td colspan="<?php echo $showtax ? '7' : '5'; ?>" class="text-right no-border">
                                        <strong><?php echo lang('discount'); ?> - <?php echo Applib::format_tax($inv->discount); ?>%</strong></td>
                                    <td class="text-right">
                                    <?php if (!User::is_admin() && !User::is_staff()) {
                                         echo Applib::format_currency($client_cur, Applib::client_currency($client_cur, Invoice::get_invoice_discount($inv->inv_id)));
                                     } else {
                                            echo Applib::format_currency($inv->currency, Invoice::get_invoice_discount($inv->inv_id));
                                        }
                                     ?> 
                                    </td>

                                    <td></td>

                                </tr>
                            <?php } ?>

                            <?php if ($inv->extra_fee > 0) { ?>
                                <tr>
                                    <td colspan="<?php echo $showtax ? '7' : '5'; ?>" class="text-right no-border">
                                        <strong><?php echo lang('extra_fee'); ?> - <?php echo $inv->extra_fee; ?>%</strong></td>
                                    <td class="text-right">
                                    <?php if (!User::is_admin() && !User::is_staff()) {
                                         echo Applib::format_currency($client_cur, Applib::client_currency($client_cur, Invoice::get_invoice_fee($inv->inv_id)));
                                     } else {
                                            echo Applib::format_currency($inv->currency, Invoice::get_invoice_fee($inv->inv_id));
                                        }
                                     ?>  
                                    </td>

                                    <td></td>

                                </tr>
                            <?php } ?>

                             <?php if (Invoice::get_invoice_paid($inv->inv_id) > 0) {
                                         ?>
                                <tr>
                                    <td colspan="<?php echo $showtax ? '7' : '5'; ?>" class="text-right no-border"><strong><?php echo lang('payment_made'); ?></strong></td>
                                    <td class="text-right text-danger">
                                        (-) 
                                     <?php if (!User::is_admin() && !User::is_staff()) {
                                             echo Applib::format_currency($client_cur, Applib::client_currency($client_cur, Invoice::get_invoice_paid($inv->inv_id)));
                                         } else {
                                             echo Applib::format_currency($inv->currency, Invoice::get_invoice_paid($inv->inv_id));
                                         } ?>                                         
                                        
                                    </td>
                                    <td></td>
                                </tr>
                            <?php
                                     } ?>


                            <tr>
                                <td colspan="<?php echo $showtax ? '7' : '5'; ?>" class="text-right no-border"><strong>
                                        <?php echo lang('due_amount'); ?></strong></td>
                                <td class="text-right">
                                <?php if (!User::is_admin() && !User::is_staff()) {
                                         echo Applib::format_currency($client_cur, Applib::client_currency($client_cur, Invoice::get_invoice_due_amount($inv->inv_id)));
                                     } else {
                                            echo Applib::format_currency($inv->currency, Invoice::get_invoice_due_amount($inv->inv_id));
                                        }
                                     ?> 
                                    
                                </td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                 
                    <p><blockquote><?php echo $inv->notes; ?></blockquote></p>
 
                </div>
           </div> 

 