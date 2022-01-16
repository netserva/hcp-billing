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

    //print_r($cart); die;
?>
<div class="box"> 	
<div class="container inner">
        <div class="row">  
 
        <div class="col-sm-10"> 
      
        <table class="table table-bordered shopping_cart" id="shopping_cart">
            <thead>
                <tr>
                    <th><?php echo lang('item'); ?></th>
                    <th><?php echo lang('domain'); ?></th>
                    <th><?php echo lang('billed'); ?></th>
                    <th><?php echo lang('amount'); ?></th>
                    <?php if ($tax) { ?>
                    <th><?php echo lang('tax'); ?></th>
                    <?php } ?>
                    <th class="w_100"><?php echo lang('action'); ?></th>
                </tr>
            </thead>
            <tbody id="domains">
                
                <?php foreach ($cart as $row) {
    $total += $row->price; ?>
            <tr>
                <td><?php echo $row->name; ?></td>
                <td><?php echo $row->domain; ?></td>
                <td><?php echo lang($row->renewal); ?></td>
                <td><?php echo Applib::format_currency(config_item('default_currency'), $row->price); ?></td>
                <?php if ($tax) { ?>
                    <td><?php echo Applib::format_currency(config_item('default_currency'), $row->tax); ?></td>
                    <?php } ?>
                <td><a class="btn btn-block btn-sm btn-default" href="<?php echo base_url(); ?>cart/remove/<?php echo $row->cart_id; ?>"><?php echo lang('remove'); ?></a></td>
            <tr>
                <?php
} ?>
            <tr>
                <td colspan="3"><span class="pull-right"><strong><?php echo lang('total'); ?></strong></span></td>
                <td><strong><?php echo Applib::format_currency(config_item('default_currency'), $total); ?></strong></td>
                <?php if ($tax) { ?>
                    <td><?php echo Applib::format_currency(config_item('default_currency'), $tax_total); ?></td>
                    <?php } ?>
                <td><a class="btn btn-danger btn-sm btn-block" href="<?php echo base_url(); ?>cart/remove_all"><?php echo lang('remove_all'); ?></a></td>
            </tr>
            <tr>
                <td colspan="<?php echo ($tax) ? '5' : '4'; ?>"><a class="btn btn-primary btn-sm" href="<?php echo (!User::is_logged_in()) ? base_url().'cart/hosting_packages' : base_url().'orders/add_order'; ?>"><?php echo lang('continue_shopping'); ?></a></td>
                <td><a href="<?php echo base_url(); ?>cart/checkout" class="btn btn-success btn-sm btn-block" id="submitOrder"><?php echo lang('submit_order'); ?></a></td>
            </tr>
        </tbody>
    </table>
    </div> 
    </div>
</div>	 
 </div>