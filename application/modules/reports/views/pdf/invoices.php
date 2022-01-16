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


  <div class="page-header text-center">
  <h3 class="reports-headerspacing"><?php echo lang('invoices_report'); ?></h3>
  <h5><span>From</span>&nbsp;<?php echo $start_date; ?>&nbsp;<span>To</span>&nbsp;<?php echo $end_date; ?></h5>
</div>


<table class="table pure-table">

<thead>
  <tr>
<th><?php echo lang('status'); ?></th>
<th class="<?php echo ('InvoiceDate' == $report_by) ? 'text-primary' : ''; ?>"><?php echo lang('invoice_date'); ?></th>
<th class="<?php echo ('InvoiceDueDate' == $report_by) ? 'text-primary' : ''; ?>"><?php echo lang('due_date'); ?></th>
<th><?php echo lang('invoice'); ?>#</th>
<th><?php echo lang('client_name'); ?></th>
<th class="text-right"><?php echo lang('amount'); ?></th>
<th class="text-right"><?php echo lang('due_amount'); ?></th>
  </tr>
</thead>

<tbody>

<?php $due_total = 0;
$invoice_total = 0;
foreach ($invoices as $key => $invoice) {
    $status = Invoice::payment_status($invoice->inv_id);
    $text_color = 'info';

    switch ($status) {
    case 'fully_paid':
      $text_color = 'success';

      break;

    case 'not_paid':
      $text_color = 'danger';

      break;
  } ?>
        <tr>
        <td><div class="text-<?php echo $text_color; ?>"><?php echo lang($status); ?></div></td>
        <td><?php echo format_date($invoice->date_saved); ?></td>
        <td><?php echo format_date($invoice->due_date); ?></td>
        <td><?php echo $invoice->reference_no; ?></td>
        <td><?php echo Client::view_by_id($invoice->client)->company_name; ?></td>

        <td class="text-right">
        <?php if ($invoice->currency != config_item('default_currency')) {
      $payable = Applib::convert_currency($invoice->currency, Invoice::payable($invoice->inv_id));
      echo Applib::format_currency($cur->code, $payable);
      $invoice_total += $payable;
  } else {
      $invoice_total += Invoice::payable($invoice->inv_id);
      echo Applib::format_currency($cur->code, Invoice::payable($invoice->inv_id));
  } ?></td>
        <td class="text-right">
        <?php if ($invoice->currency != config_item('default_currency')) {
      $due = Applib::convert_currency($invoice->currency, Invoice::get_invoice_due_amount($invoice->inv_id));
      $due_total += $due;
      echo Applib::format_currency($cur->code, $due);
  } else {
      $due_total += Invoice::get_invoice_due_amount($invoice->inv_id);
      echo Applib::format_currency($cur->code, Invoice::get_invoice_due_amount($invoice->inv_id));
  } ?></td>
      </tr>
<?php
} ?>

        <tr>
          <td colspan="5"><strong><?php echo lang('total'); ?></strong></td>
          <td class="text-right"><strong><?php echo Applib::format_currency($cur->code, $invoice_total); ?></strong></td>
          <td class="text-right"><strong><?php echo Applib::format_currency($cur->code, $due_total); ?></strong></td>
        </tr>


<!----></tbody>
</table>  
    


