<!-- Include Required Prerequisites -->
<script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
 
<!-- Include Date Range Picker -->
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<?php $cur = App::currencies(config_item('default_currency'));
$start_date = date('F d, Y', strtotime($range[0]));
$end_date = date('F d, Y', strtotime($range[1]));
?>

<div class="box">

          <div class="box-header b-b">
          <?php echo $this->load->view('report_header'); ?>

          <?php if ($this->uri->segment(3)) { ?>
              <a href="<?php echo base_url(); ?>reports/paymentspdf/<?php echo strtotime($start_date); ?>/<?php echo strtotime($end_date); ?>" class="btn btn-dark btn-sm pull-right"><i class="fa fa-file-pdf-o"></i><?php echo lang('pdf'); ?>
              </a>
            <?php } ?>
             
          </div>


            <div class="box-body">

 

<div class="fill body reports-top rep-new-band">
<div class="criteria-container fill-container hidden-print">
  <div class="criteria-band">
    <address class="row">

    <?php echo form_open(base_url().'reports/view/paymentsreport'); ?>
      
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
  <h3 class="reports-headerspacing"><?php echo lang('payments_report'); ?></h3>
  <h5><span>From</span>&nbsp;<?php echo $start_date; ?>&nbsp;<span>To</span>&nbsp;<?php echo $end_date; ?></h5>
</div>

<table class="table zi-table table-hover norow-action small"><thead>
  <tr>
<th class="text-left">
  <div class="pull-left over-flow"><?php echo lang('transaction_id'); ?></div>
</th>
         <th class="text-left">
  <div class="pull-left over-flow"> <?php echo lang('date'); ?></div>
  
</th>
         <th class="sortable text-left">
  <div class="pull-left over-flow"> <?php echo lang('client_name'); ?></div>
</th>
         <th class="sortable text-left">
  <div class="pull-left over-flow"> <?php echo lang('payment_method'); ?></div>
</th>
         
         <th class="sortable text-left">
  <div class="pull-left over-flow"> <?php echo lang('invoice'); ?>#</div>
</th>
        
         <th class="sortable text-right">
  <div class=" over-flow"> <?php echo lang('amount'); ?></div>
</th>
  </tr>
</thead>

<tbody>

<?php $total_received = 0;
foreach ($payments as $key => $tr) { ?>
        <tr>
        <td><a href="<?php echo base_url(); ?>payments/view/<?php echo $tr->p_id; ?>"><?php echo $tr->trans_id; ?></a></td>
        <td><?php echo format_date($tr->payment_date); ?></td>
        <td><a href="<?php echo base_url(); ?>companies/view/<?php echo $tr->paid_by; ?>">
        <?php echo Client::view_by_id($tr->paid_by)->company_name; ?></a>
        </td>
        <td><?php echo App::get_method_by_id($tr->payment_method); ?></td>
        <td><a href="<?php echo base_url(); ?>invoices/view/<?php echo $tr->invoice; ?>"><?php echo Invoice::view_by_id($tr->invoice)->reference_no; ?></a></td>

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

        <tr class="hover-muted bt">
          <td colspan="5"><?php echo lang('total'); ?></td>
          <td class="text-right"><?php echo Applib::format_currency($cur->code, $total_received); ?></td>
        </tr>


<!----></tbody>
</table>  </div>
    

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