<!-- Client Payments -->
<?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'view_all_payments')) { ?>
<table id="table-payments" class="table table-striped b-t b-light AppendDataTables">
    <thead>
        <tr>
            <th class="w_5 hidden"></th>
            <th><?php echo lang('date'); ?></th>
            <th><?php echo lang('invoice'); ?></th>
            <th class=""><?php echo lang('payment_method'); ?></th>
            <th><?php echo lang('amount'); ?> </th>
            <th><?php echo lang('options'); ?> </th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach (Payment::client_payments($company) as $key => $p) {
            $cur = Client::client_currency($p->paid_by); ?>
        <tr>
            <td class="hidden"><?php echo $p->p_id; ?></td>
            <td>
                <a class="text-info" href="<?php echo base_url(); ?>payments/view/<?php echo $p->p_id; ?>">
                    <?php echo strftime(config_item('date_format'), strtotime($p->created_date)); ?>
                </a>
            </td>
            <td><a class="text-info" href="<?php echo base_url(); ?>invoices/view/<?php echo $p->invoice; ?>">
                    <?php echo Invoice::view_by_id($p->invoice)->reference_no; ?>
                </a>
            </td>
            <td>
                <label class="label label-default">
                    <?php echo App::get_method_by_id($p->payment_method); ?>
                </label>
            </td>
            <td>
                <strong><?php echo Applib::format_currency($cur->code, Applib::client_currency($cur->code, $p->amount)); ?></strong>
            </td>

            <td>
                <a class="btn btn-xs btn-primary" href="<?php echo base_url(); ?>payments/view/<?php echo $p->p_id; ?>"
                    data-toggle="tooltip" data-original-title="<?php echo lang('view_payment'); ?>" data-placement="top"><i
                        class="fa fa-eye"></i></a>

                <a class="btn btn-xs btn-warning" href="<?php echo base_url(); ?>payments/pdf/<?php echo $p->p_id; ?>" data-toggle="tooltip"
                    data-original-title="<?php echo lang('pdf'); ?> <?php echo lang('receipt'); ?>" data-placement="top"><i
                        class="fa fa-file-pdf-o"></i></a>


                <?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'edit_payments')) { ?>
                <a class="btn btn-xs btn-success" data-toggle="tooltip" data-original-title="<?php echo lang('edit_payment'); ?>"
                    data-placement="top" href="<?php echo base_url(); ?>payments/edit/<?php echo $p->p_id; ?>"><i
                        class="fa fa-pencil"></i></a>
                <?php if ('No' == $p->refunded) { ?>
                <span data-toggle="tooltip" data-original-title="<?php echo lang('refund'); ?>" data-placement="top"><a
                        class="btn btn-xs btn-twitter" href="<?php echo base_url(); ?>payments/refund/<?php echo $p->p_id; ?>"
                        data-toggle="ajaxModal"><i class="fa fa-warning"></i></a></span>

                <?php } } ?>
                <a class="btn btn-xs btn-google" href="<?php echo base_url(); ?>payments/delete/<?php echo $p->p_id; ?>"
                    data-toggle="ajaxModal"><i class="fa fa-trash"></i></a>

            </td>

        </tr>
        <?php
        } ?>



    </tbody>
</table>
<?php } ?>