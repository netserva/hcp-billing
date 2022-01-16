<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><?php echo lang('edit_item'); ?> - <?php echo lang('affiliates'); ?></h4>
        </div>
        <?php $item = Item::view_item($id); ?>

        <?php
             $attributes = ['class' => 'bs-example form-horizontal'];
          echo form_open(base_url().'items/affiliates', $attributes); ?>
        <input type="hidden" name="r_url" value="<?php echo base_url(); ?>items?view=hosting">
        <input type="hidden" name="item_id" value="<?php echo $item->item_id; ?>">
        <div class="modal-body">

            <div class="form-group">
                <label class="col-lg-4 control-label">Commission</label>
                <div class="col-lg-3">
                    <select name="commission" class="form-control m-b" id="type"> 
                        <option value="default" <?php echo ('default' == $item->commission) ? 'selected' : ''; ?>>Default</option>
                        <option value="amount" <?php echo ('amount' == $item->commission) ? 'selected' : ''; ?>>Amount</option>
                        <option value="percentage" <?php echo ('percentage' == $item->commission) ? 'selected' : ''; ?>>Percentage</option>
                        <option value="none" <?php echo ('none' == $item->commission) ? 'selected' : ''; ?>>None</option>
                    </select>
                </div>               
            </div>

            <div class="form-group" id="amount">
                <label class="col-lg-4 control-label">Commission Amount</label>
                <div class="col-lg-3">                    
                    <div class="input-group">                        
                        <input type="text" class="form-control" value="<?php echo $item->commission_amount; ?>" name="commission_amount">
                        <span class="input-group-addon">%</span>                        
                    </div>                    
                </div>               
            </div>

            <div class="form-group">
                <label class="col-lg-4 control-label">Payout</label>
                <div class="col-lg-3">
                    <select name="commission_payout" class="form-control m-b"> 
                        <option value="default" <?php echo ('default' == $item->commission_payout) ? 'selected' : ''; ?>>Default</option>
                        <option value="once" <?php echo ('once' == $item->commission_payout) ? 'selected' : ''; ?>>Once Off</option>
                        <option value="recurring" <?php echo ('recurring' == $item->commission_payout) ? 'selected' : ''; ?>>Recurring</option> 
                    </select>
                </div>               
            </div>

        </div>
        <div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a>
            <button type="submit" class="btn btn-<?php echo config_item('theme_color'); ?>"><?php echo lang('save_changes'); ?></button>
            </form>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
<script>
    <?php if ('percentage' != $item->commission && 'amount' != $item->commission) { ?>
        $('#amount').hide();
    <?php } ?>

    $('#type').on('change', function() {
        var selected = $(this).find('option:selected').val();
        if(selected == 'percentage' || selected == 'amount')
        {
            $('#amount').show(500);
        }
        else
        {
            $('#amount').hide(500);
        }

        if(selected == 'percentage')
        {
            $('.input-group-addon').show(500);
        }
        else
        {
            $('.input-group-addon').hide(500);
        }
    });
    
    $(this).showCategoryFields($('#item_category')[0]);
</script>