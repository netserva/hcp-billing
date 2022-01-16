<?php declare(strict_types=1);
$cur = App::currencies(config_item('default_currency'));
$customer = ($client > 0) ? Client::view_by_id($client) : [];
?>

<div class="box">
  <div class="box-header b-b"> 
             <?php echo $this->load->view('report_header'); ?>

             <?php if ($this->uri->segment(3) && isset($customer->co_id)) { ?>
              <a href="<?php echo base_url(); ?>reports/invoicespdf/<?php echo $customer->co_id; ?>" class="btn btn-dark btn-sm pull-right"><i class="fa fa-file-pdf-o"></i><?php echo lang('pdf'); ?>
              </a>
            <?php } ?>
             
             </div>


            <div class="box-body">


<div class="fill body reports-top rep-new-band">
<div class="criteria-container fill-container hidden-print">
  <div class="criteria-band">
    <address class="row">
     <?php echo form_open(base_url().'reports/view/invoicesbyclient'); ?>
    


        <div class="col-md-4">
          <label><?php echo lang('client_name'); ?> </label>
          <i class="fa fa-search"></i>&nbsp;
    <span></span> <b class="caret"></b>
          <select class="select2-option w_280" name="client" >
                                            <optgroup label="<?php echo lang('clients'); ?>">
                                                <?php foreach (Client::get_all_clients() as $c) { ?>
                                                    <option value="<?php echo $c->co_id; ?>" <?php echo ($client == $c->co_id) ? 'selected="selected"' : ''; ?>>
                                                    <?php echo ucfirst($c->company_name); ?></option>
                                                <?php }  ?>
                                            </optgroup>
                                        </select>
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
  <?php if (null != $client) { ?>
  <h5><span><?php echo lang('client_name'); ?>:</span>&nbsp;<?php echo $customer->company_name; ?>&nbsp;</h5>
  <?php } ?>
</div>

<table class="table zi-table table-hover norow-action small"><thead>
  <tr>
<th class="text-left">
  <div class="pull-left over-flow"><?php echo lang('status'); ?></div>
</th>
         <th class="text-left">
  <div class="pull-left over-flow"> <?php echo lang('invoice_date'); ?></div>
  
</th>
         <th class="sortable text-left">
  <div class="pull-left over-flow"> <?php echo lang('due_date'); ?></div>
</th>
         <th class="sortable text-left">
  <div class="pull-left over-flow"> <?php echo lang('invoice'); ?>#</div>
</th>
         
         <th class="sortable text-right">
  <div class=" over-flow"> <?php echo lang('invoice_amount'); ?></div>
</th>
         <th class="sortable text-right">
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
          <td colspan="4"><?php echo lang('total'); ?></td>
          <td class="text-right"><?php echo Applib::format_currency($cur->code, $invoice_total); ?></td>
          <td class="text-right"><?php echo Applib::format_currency($cur->code, $due_total); ?></td>
        </tr>


<!----></tbody>
</table>  </div>
    
 
</div>
</div>
