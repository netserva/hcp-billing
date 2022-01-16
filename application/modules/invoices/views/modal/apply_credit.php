<div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo lang('pay'); ?></h4>
        </div>
        <?php $client = Client::view_by_id(Invoice::view_by_id($invoice)->client);
            $due = Invoice::get_invoice_due_amount($invoice);
            $credit = $client->transaction_value;
            $client_cur = $client->currency;
            echo form_open(base_url().'invoices/apply_credit'); ?>
            <div class="modal-body">
            
                <div class="form-group">
                <label><?php echo lang('balance_due'); ?></label>
                <input type="text" value="<?php echo Applib::format_currency($client_cur, Applib::client_currency($client_cur, $due)); ?>" class="input-sm form-control" readonly="readonly">
                </div> 

                <hr>

                <input type="hidden" value="<?php echo $invoice; ?>" name="invoice">               
                <div class="form-group">
                <label><?php echo lang('credit_balance'); ?></label>
                <input type="text" value="<?php echo Applib::format_currency($client_cur, Applib::client_currency($client_cur, $credit)); ?>" class="input-sm form-control" readonly="readonly">                                            
                </div> 
            </div>
            <div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a>
                <button type="submit" class="btn btn-<?php echo config_item('theme_color'); ?>"><?php echo lang('pay'); ?></button>
            </div>
		</form>
    </div>
</div>
 