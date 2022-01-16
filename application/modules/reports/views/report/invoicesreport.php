<!-- Include Required Prerequisites -->
<script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
 
<!-- Include Date Range Picker -->
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

<?php $cur = App::currencies(config_item('default_currency'));
$start_date = date('F d, Y', strtotime($range[0]));
$end_date = date('F d, Y', strtotime($range[1]));
$report_by = (isset($report_by)) ? $report_by : 'InvoiceDate';
?>

<div class="box">
          <div class="box-header b-b">
            <?php echo $this->load->view('report_header'); ?>

            <?php if ($this->uri->segment(3)) { ?>
              <a href="<?php echo base_url(); ?>reports/invoicespdf/<?php echo strtotime($start_date); ?>/<?php echo strtotime($end_date); ?>/<?php echo $report_by; ?>" class="btn btn-dark btn-sm pull-right"><i class="fa fa-file-pdf-o"></i><?php echo lang('pdf'); ?>
              </a>
            <?php } ?>
             
            </div>

            <div class="box-body">
  


<div class="fill body reports-top rep-new-band">
<div class="criteria-container fill-container hidden-print">
  <div class="criteria-band">
    <address class="row">
    <?php echo form_open(base_url().'reports/view/invoicesreport'); ?>
    
        <div class="col-md-2">
          <label><?php echo lang('report_by'); ?></label>
          <select class="form-control" name="report_by"><!---->
          <option value="InvoiceDate"><?php echo lang('invoice_date'); ?></option>
          <option value="InvoiceDueDate" <?php echo ('InvoiceDueDate' == $report_by) ? 'selected="selected"' : ''; ?>><?php echo lang('invoice'); ?> <?php echo lang('due_date'); ?></option>
</select>
        </div>
      
<div class="col-md-4">
  <label><?php echo lang('date_range'); ?></label>
  <input type="text" name="range" id="reportrange" class="pull-right form-control">
    <i class="fa fa-calendar"></i>&nbsp;
    <span></span> <b class="caret"></b>


</div>


      <div class="col-md-2">  
  <button class="btn btn-<?php echo config_item('theme_color'); ?>" type="submit">
    <?php echo lang('run_report'); ?>
  </button>
</div>



    </address>


  </div>
</div>


</form>

<div class="rep-container">
  <div class="page-header text-center">
  <h3 class="reports-headerspacing"><?php echo lang('invoices_report'); ?></h3>
  <h5><span>From</span>&nbsp;<?php echo $start_date; ?>&nbsp;<span>To</span>&nbsp;<?php echo $end_date; ?></h5>
</div>

  <div class="fill-container">
<table class="table zi-table table-hover norow-action small"><thead>
  <tr>
<th class="text-left">
  <div class="pull-left over-flow"><?php echo lang('status'); ?></div>
</th>
         <th class="text-left <?php echo ('InvoiceDate' == $report_by) ? 'text-primary' : ''; ?>">
  <div class="pull-left over-flow"> <?php echo lang('invoice_date'); ?></div>
  
</th>
         <th class="text-left <?php echo ('InvoiceDueDate' == $report_by) ? 'text-primary' : ''; ?>">
  <div class="pull-left over-flow"> <?php echo lang('due_date'); ?></div>
</th>
         <th class="text-left">
  <div class="pull-left over-flow"> <?php echo lang('invoice'); ?>#</div>
<!----></div>
</th>
         
         <th class="text-left">
  <div class="pull-left over-flow"> <?php echo lang('client_name'); ?></div>
</th>
         <th class="text-right">
  <div class=" over-flow"> <?php echo lang('invoice_amount'); ?></div>
</th>
         <th class="text-right">
  <div class=" over-flow"> <?php echo lang('balance_due'); ?></div>
</th>
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
        <td><a href="<?php echo base_url(); ?>invoices/view/<?php echo $invoice->inv_id; ?>"><?php echo $invoice->reference_no; ?></a></td>
        <td><a href="<?php echo base_url(); ?>companies/view/<?php echo $invoice->client; ?>"><?php echo Client::view_by_id($invoice->client)->company_name; ?></a></td>

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

        <tr class="hover-muted bt">
          <td colspan="5"><?php echo lang('total'); ?></td>
          <td class="text-right"><?php echo Applib::format_currency($cur->code, $invoice_total); ?></td>
          <td class="text-right"><?php echo Applib::format_currency($cur->code, $due_total); ?></td>
        </tr>


<!----></tbody>
</table>  </div>
    

</div>


</div>
</div>
 </div>

<script type="text/javascript">
    $('#reportrange').daterangepicker({
      locale: {
            format: 'MMMM D, YYYY'
        },
        startDate: '<?php echo $start_date; ?>',
        endDate: '<?php echo $end_date; ?>',
        "opens": "right",
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    });
</script>