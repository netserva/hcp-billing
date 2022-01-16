<?php declare(strict_types=1);
$cart = $this->session->userdata('cart');
    $total = 0;
    $tax = false;
    $tax_total = 0;
    foreach ($cart as $row) {
        if (floatval($row->tax) > 0) {
            $tax_total += $row->tax;
            $tax = true;
        }
    }
?>

<section id="pricing" class="bg-silver-light">
    <div class="container inner">

        <div class="section-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid box-default">
                        <div class="box-body">

                            <table class="table table-bordered shopping_cart" id="shopping_cart">
                                <thead>
                                    <tr>
                                        <th><?php echo lang('item'); ?></th>
                                        <th><?php echo lang('description'); ?></th>
                                        <th><?php echo lang('billed'); ?></th>
                                        <th><?php echo lang('amount'); ?></th>
                                        <?php if ($tax) { ?>
                                        <th><?php echo lang('tax'); ?></th>
                                        <?php } ?>
                                        <th><?php echo lang('total'); ?></th>
                                        <th class="w_100"><?php echo lang('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody id="domains">

                                    <?php foreach ($cart as $row) {
    $total += ($tax) ? $row->price + $row->tax : $row->price; ?>
                                    <tr>
                                        <td><?php echo $row->name; ?></td>
                                        <td><?php echo ('promo' == $row->domain) ? $row->item : $row->domain; ?></td>
                                        <td><?php echo isset($row->years) ? $row->years.lang('years') : lang($row->renewal); ?>
                                        </td>
                                        <td><?php echo ('promo' != $row->domain) ? Applib::format_currency(config_item('default_currency'), $row->price) : ''; ?>
                                        </td>
                                        <?php if ($tax) { ?>
                                        <td><?php echo ('promo' != $row->domain) ? Applib::format_currency(config_item('default_currency'), $row->tax) : ''; ?>
                                        </td>
                                        <?php } ?>
                                        <td><?php echo Applib::format_currency(config_item('default_currency'), ($tax) ? $row->price + $row->tax : $row->price); ?>
                                        </td>
                                        <td><a class="btn btn-block btn-sm btn-default"
                                                href="<?php echo base_url(); ?>cart/remove/<?php echo $row->cart_id; ?>"><?php echo lang('remove'); ?></a>
                                        </td>
                                    </tr>
                                    <?php
} ?>
                                    <tr>
                                        <td colspan="<?php echo ($tax) ? '5' : '4'; ?>"><span
                                                class="pull-right"><strong><?php echo lang('total'); ?></strong></span></td>
                                        <td><?php echo Applib::format_currency(config_item('default_currency'), $total); ?></strong>
                                        </td>
                                        <td><a class="btn btn-danger btn-sm btn-block"
                                                href="<?php echo base_url(); ?>cart/remove_all"><?php echo lang('remove_all'); ?></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="<?php echo ($tax) ? '6' : '5'; ?>"><a class="btn btn-sm btn-primary"
                                                href="<?php echo (!User::is_logged_in()) ? base_url().'cart/hosting_packages' : base_url().'orders/add_order'; ?>"><?php echo lang('continue_shopping'); ?></a>
                                            <form class="pull-right" action="<?php echo base_url().'cart/validate_code'; ?>"
                                                method="post">
                                                <label class="labels"><?php echo lang('discount_code'); ?></label> <input
                                                    type="text" name="code"><button
                                                    class="btn btn-sm btn-info"><?php echo lang('validate'); ?></button>
                                            </form>
                                        </td>
                                        <td><a href="<?php echo base_url(); ?>cart/checkout"
                                                class="btn btn-success btn-sm btn-block"
                                                id="submitOrder"><?php echo lang('submit_order'); ?></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>