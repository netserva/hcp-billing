<div class="box">
    <div class="box-body">
        <div class="row">
            <?php
            $profile = User::profile_info(User::get_id());
            if ($profile->company > 0) {
                $comp = Client::view_by_id($profile->company);
            }

            if ($comp->affiliate < 1) { ?>

            <div class="col-md-6 col-sm-6 col-12">
                <div class="alert alert-info">
                    <h2><?php echo lang('refer_get_paid'); ?></h2>
                    <hr><?php echo lang('how_affiliates_work'); ?>
                    <hr>
                    <?php
                    $attributes = ['class' => 'bs-example form-horizontal'];
                    echo form_open(uri_string().'/activate', $attributes); ?>
                    <input type="hidden" value="<?php echo $profile->company; ?>" name="co_id">
                    <input class="btn btn-primary" type="submit" value="Activate">
                    </form>
                </div>
            </div>

            <?php } else { ?>
            <div class="col-md-4 col-sm-4 col-12">
                <div class="alert alert-warning center">
                    <h2><?php echo lang('clicks'); ?></h2>
                    <hr>
                    <h1 class="status_count"><?php echo $comp->affiliate_clicks; ?></h1>
                </div>
            </div>

            <div class="col-md-4 col-sm-4 col-12">
                <div class="alert alert-info center">
                    <h2><?php echo lang('signups'); ?></h2>
                    <hr>
                    <h1 class="status_count"><?php echo $comp->affiliate_signups; ?></h1>
                </div>
            </div>

            <div class="col-md-4 col-sm-4 col-12">
                <div class="alert alert-success center">
                    <h2><?php echo lang('commission_balance'); ?></h2>
                    <hr>
                    <h1 class="status_count">
                        <?php echo Applib::format_currency(config_item('default_currency'), $comp->affiliate_balance); ?></h1>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-info center">
                    <?php echo lang('withdrawal_minimum_message'); ?>
                    <?php echo Applib::format_currency(config_item('default_currency'), config_item('affiliates_payout')); ?>.
                    <?php if ($comp->affiliate_balance > config_item('affiliates_payout')) { ?> <a
                        href="<?php echo base_url(); ?>affiliates/withdraw" data-toggle="ajaxModal"
                        class="btn btn-primary btn-sm"><?php echo lang('withdraw'); ?></a> <?php } ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab1">
                            <h4><?php echo lang('signups'); ?></h4>
                        </a></li>
                    <li><a data-toggle="tab" href="#tab2">
                            <h4><?php echo lang('withdrawal_history'); ?></h4>
                        </a></li>
                </ul>

                <div class="tab-content">
                    <div id="tab1" class="tab-pane fade in active">
                        <div class="table-responsive">
                            <table id="table-templates-2" class="table table-striped b-t b-light text-sm AppendDataTables">
                                <thead>
                                    <tr>
                                        <th class="w_5 hidden"></th>
                                        <th class="col-date"><?php echo lang('date'); ?></th>
                                        <th class=""><?php echo lang('products_services'); ?></th>
                                        <th class=""><?php echo lang('amount'); ?></th>
                                        <th class=""><?php echo lang('commission'); ?></th>
                                        <th class=""><?php echo lang('payout'); ?></th>
                                        <th class=""><?php echo lang('status'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>


                                    <?php foreach (Affiliate::account($comp->affiliate_id) as $key => $aff) { ?>
                                    <tr>
                                        <td class="hidden"></td>
                                        <td><?php echo $aff->date; ?></td>
                                        <td><?php echo $aff->item_name; ?></td>
                                        <td><?php echo Applib::format_currency(config_item('default_currency'), $aff->amount); ?>
                                        </td>
                                        <td><?php echo Applib::format_currency(config_item('default_currency'), $aff->commission); ?>
                                        </td>
                                        <td><?php echo 'once' == $aff->type ? lang('once') : lang('recurring'); ?></td>
                                        <td><?php echo lang($aff->status); ?></td>
                                    </tr>
                                    <?php }  ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="tab2" class="tab-pane fade">
                    <div class="table-responsive">
                            <table id="table-templates-1"
                                class="table table-striped b-t b-light text-sm AppendDataTables">
                                <thead>
                                    <tr>
                                        <th class="w_5 hidden"></th>
                                        <th class="col-date"><?php echo lang('request_date'); ?></th> 
                                        <th><?php echo lang('payment_details'); ?></th>
                                        <th><?php echo lang('amount'); ?></th>
                                        <th class="col-date"><?php echo lang('payment_date'); ?></th>
                                        <th><?php echo lang('notes'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>


                                    <?php foreach (Affiliate::withdrawals($comp->affiliate_id) as $key => $aff) { ?>
                                    <tr>
                                        <td class="hidden"></td>
                                        <td><?php echo $aff->request_date; ?></td>
                                        <td><?php echo $aff->payment_details; ?></td>
                                        <td><?php echo Applib::format_currency(config_item('default_currency'), $aff->amount); ?>
                                        <td><?php echo $aff->payment_date; ?></td>
                                        <td><?php echo $aff->notes; ?></td>
                                        </td>                                       
                                    </tr>
                                    <?php }  ?>
                                </tbody>
                            </table>
                    </div>
                </div>


                <hr>
                <h2><?php echo lang('links'); ?></h2>
                <hr>
                <?php
                    $links = config_item('affiliates_links');
                    $links = str_replace('{AFFILIATE}', $comp->affiliate_id, $links);
                    $links = str_replace('[', '&lt;', $links);
                    $links = str_replace(']', '&gt;', $links);
                    echo $links;
                ?>
            </div>
            <?php } ?>
        </div>
    </div>
</div>


<!-- end -->