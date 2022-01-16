
<div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button>
        <?php $withdrawal = Affiliate::withdrawal($id);
        if (!empty($withdrawal)) {
            ?>
        <h4 class="modal-title"><?php echo $withdrawal->company_name; ?></h4>
        </div>
        <?php
            echo form_open(base_url().'affiliates/pay_withdrawal'); ?>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="withdrawal_id" value="<?php echo $withdrawal->withdrawal_id; ?>">
            <div class="modal-body">

            <?php echo $withdrawal->payment_details; ?>
            <hr>
                <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label"><?php echo lang('amount'); ?></label>
                        <input type="text" value="<?php echo $withdrawal->amount; ?>" name="amount" class="input-sm form-control" readonly="readonly">                                            
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                    <label class="control-label"><?php echo lang('currency'); ?></label>
                    <input type="text" name="currency" value="<?php echo config_item('default_currency'); ?>" class="input-sm form-control" readonly> 
                    </div>
                </div>
            </div>  
            
            <div class="form-group">
            <label class="control-label"><?php echo lang('notes'); ?></label>
            <textarea class="form-control" name="notes"></textarea>
            </div>

            <?php
        } else { ?>
                <h4 class="modal-title"><?php echo lang('no_withdrawal_request'); ?></h4>
            <?php } ?>
            
        </div>
		<div class="modal-footer"> <a href="#" class="btn btn-default btn-sm" data-dismiss="modal"><?php echo lang('close'); ?></a>
			<button type="submit" class="btn btn-success btn-sm"><?php echo lang('pay_withdrawal'); ?></button>
		</form>
	</div>
</div>
</div>
 