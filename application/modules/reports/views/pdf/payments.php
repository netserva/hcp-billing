<link rel="stylesheet" href="<?php echo base_url(); ?>resource/css/app.css" type="text/css" />
<style type="text/css">
  .pure-table td, .pure-table th {
    border-bottom: 1px solid #cbcbcb;
    border-width: 0 0 0 1px;
    margin: 0;
    overflow: visible;
    padding: .5em 1em;
}
.pure-table .table td {
    vertical-align: middle !important;
}
</style>
<?php ini_set('memory_limit', '-1');
$cur = App::currencies(config_item('default_currency'));
$start_date = date('F d, Y', strtotime($range[0]));
$end_date = date('F d, Y', strtotime($range[1]));
?>


<div class="rep-container">
  <div class="page-header text-center">
  <h3 class="reports-headerspacing"><?php echo lang('payments_report'); ?></h3>
  <h5><span>From</span>&nbsp;<?php echo $start_date; ?>&nbsp;<span>To</span>&nbsp;<?php echo $end_date; ?></h5>
</div>

<table class="table  pure-table"><thead>
  <tr>
<th><?php echo lang('trans_id'); ?></th>
<th><?php echo lang('date'); ?></th>
<th><?php echo lang('client_name'); ?></th>
<th><?php echo lang('payment_method'); ?></th>
<th><?php echo lang('invoice'); ?>#</th>
<th class="text-right"><?php echo lang('amount'); ?></th>
  </tr>
</thead>

<tbody>

<?php $total_received = 0;
foreach ($payments as $key => $tr) { ?>
        <tr>
        <td><?php echo $tr->trans_id; ?></td>
        <td><?php echo format_date($tr->payment_date); ?></td>
        <td><?php echo Client::view_by_id($tr->paid_by)->company_name; ?></td>
        <td><?php echo App::get_method_by_id($tr->payment_method); ?></td>
        <td><?php echo Invoice::view_by_id($tr->invoice)->reference_no; ?></td>

        <td class="text-right">
        <?php if ($tr->currency != config_item('default_currency')) {
    $converted = Applib::convert_currency($tr->currency, $tr->amount);
    echo Applib::format_currency($cur->code, $converted);
    $total_received += $converted;
} else {
    $total_received += $tr->amount;
    echo Applib::format_currency($cur->code, $tr->amount);
}
        ?></td>
      </tr>
<?php } ?>

        <tr class="hover-muted">
          <td colspan="5"><strong><?php echo lang('total'); ?></strong></td>
          <td class="text-right"><strong><?php echo Applib::format_currency($cur->code, $total_received); ?></strong></td>
        </tr>


<!----></tbody>
</table>  </div>