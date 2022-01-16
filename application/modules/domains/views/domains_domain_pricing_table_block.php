<?php declare(strict_types=1);
/**
 * Name: Domain Pricing
 * Description: A table of domain extensions and prices.
 */
$domains = modules::run('domains/domain_pricing', '');
?>
<table class="table table-striped table-bordered AppendDataTables">
<thead><tr><th><?php echo lang('extension'); ?></th><th><?php echo lang('registration'); ?></th><th><?php echo lang('transfer'); ?></th></tr></thead>
<tbody>
    <?php foreach (Item::get_domains() as $domain) { ?>
        <tr>
            <td><?php echo $domain->item_name; ?></td>
            <td><?php echo Applib::format_currency(config_item('default_currency'), $domain->registration); ?></td>
            <td><?php echo Applib::format_currency(config_item('default_currency'), $domain->transfer); ?></td>
        </tr>
    <?php } ?>
</tbody>
</table>