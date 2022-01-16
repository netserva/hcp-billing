<div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo lang('change_balance'); ?></h4>
        </div>
        <?php
            echo form_open(base_url().'affiliates/change_balance'); ?>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="modal-body">
                <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label"><?php echo lang('amount'); ?></label>
                        <input type="text" placeholder="0.00" name="amount" class="input-sm form-control" required>                                            
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                    <label class="control-label"><?php echo lang('currency'); ?></label>
                    <input type="text" name="currency" value="<?php echo config_item('default_currency'); ?>" class="input-sm form-control" readonly> 
                    </div>
                </div>
            </div>          

        </div>
		<div class="modal-footer"> <a href="#" class="btn btn-default btn-sm" data-dismiss="modal"><?php echo lang('close'); ?></a>
			<button type="submit" class="btn btn-success btn-sm"><?php echo lang('change_balance'); ?></button>
		</form>
	</div>
</div>
</div>
 