<ul class="nav">
<?php foreach ($invoices as $key => $invoice) {
    $label = 'default';
    $status = 'draft';
    $status = Invoice::payment_status($invoice->inv_id);
    if ('fully_paid' == $status) {
        $label = 'success';
        $status = 'fully_paid';
    } elseif ('Yes' == $invoice->emailed) {
        $status = 'sent';
        $label = 'info';
    } ?>

        <li class="b-b b-light <?php if ($invoice->inv_id == $this->uri->segment(3)) {
        echo 'bg-light dk';
    } ?>">

        <?php
        $page = $this->uri->segment(2);

    switch ($page) {
                case 'transactions':
                        $inv_url = base_url().'invoices/transactions/'.$invoice->inv_id;

                        break;

                case 'timeline':
                        $inv_url = base_url().'invoices/timeline/'.$invoice->inv_id;

                        break;

                default:
                        $inv_url = base_url().'invoices/view/'.$invoice->inv_id;

                        break;
        } ?>

                <a href="<?php echo $inv_url; ?>">

                        <?php echo ucfirst(Client::view_by_id($invoice->client)->company_name); ?>
                        <div class="pull-right">
                        <?php echo Applib::format_currency($invoice->currency, Invoice::get_invoice_due_amount($invoice->inv_id)); ?>
                        </div> <br>
                        <small class="block small text-muted"><?php echo $invoice->reference_no; ?> 
                        <span class="label label-<?php echo $label; ?>"><?php echo lang($status); ?>
                        </span>
                        </small>
                </a> 

        </li>
<?php
} ?>
        </ul>