<?php declare(strict_types=1);
$options = intervals(); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><?php echo lang('promotion'); ?></h4>
        </div><?php
             $attributes = ['class' => 'bs-example form-horizontal'];
          echo form_open(base_url().'promotions/add_promotion', $attributes); ?>
        <div class="modal-body">


            <div class="form-group">
                <label class="col-lg-4 control-label"><?php echo lang('discount_type'); ?></label>
                <div class="col-lg-3">
                    <select name="type" id="select" type="select" class="form-control m-b">
                        <option value="1"><?php echo lang('amount'); ?></option>
                        <option value="2"><?php echo lang('percentage'); ?></option>
                    </select>
                </div> 
				<div class="col-lg-3">
                    <input type="text" class="form-control" name="value" placeholder="0.00" required>
                </div>
				<div class="col-lg-1" id="type"></div>
            </div>

 

            <div class="form-group">
                <label class="col-lg-4 control-label"><?php echo lang('code'); ?></label>
                <div class="col-lg-4">
                    <input type="text" class="form-control" name="code" id="code" required>
                </div>
                <div class="col-lg-4">
                    <span class="btn btn-sm btn-warning btn-block" id="generate"><?php echo lang('generate'); ?></span>
                </div>
            </div>


			<div class="form-group">
                <label class="col-lg-4 control-label"><?php echo lang('description'); ?></label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" name="description" required>
                </div>
            </div>


            <div class="form-group">
                <label class="col-lg-4 control-label"><?php echo lang('apply_to'); ?></label>
                <div class="col-lg-8">
                    <select class="select2" multiple="multiple" style="width: 100%;" name="apply_to[]">
                        <?php foreach (Item::get_items() as $item) {?>
                        <option value="<?php echo $item->item_id; ?>"><?php echo $item->item_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>


            <div class="form-group">
                <label class="col-lg-4 control-label"><?php echo lang('require'); ?> (<?php echo lang('optional'); ?>)</label>
                <div class="col-lg-8">
                    <select class="select2" multiple="multiple" style="width: 100%;" name="required[]">
                        <?php foreach (Item::get_items() as $item) {?>
                        <option value="<?php echo $item->item_id; ?>"><?php echo $item->item_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>


            <div class="form-group">
                <label class="col-lg-4 control-label"><?php echo lang('billing_cycle'); ?> (<?php echo lang('optional'); ?>)</label>
                <div class="col-lg-8">
                    <select class="select2options" multiple="multiple" style="width: 100%;" name="billing_cycle[]">
                        <?php foreach ($options as $key => $value) {?>
                        <option value="<?php echo $key; ?>"><?php echo ucfirst(str_replace('_', ' ', $key)); ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>



            <div class="form-group">
                <label class="col-lg-4 control-label"><?php echo lang('payment'); ?></label>
                <div class="col-lg-8">
                    <select class="form-control" name="payment">
                        <option value="1"><?php echo lang('apply_in_first_payment'); ?></option>
                        <option value="2"><?php echo lang('apply_in_payment_renewals'); ?></option>
                    </select>
                </div>
            </div>


            <div class="form-group">
                <label class="col-lg-4 control-label"><?php echo lang('once_per_order'); ?></label>
                <div class="col-lg-4">
                    <select class="form-control" name="per_order">
                        <option value="0"><?php echo lang('no'); ?></option>
                        <option value="1"><?php echo lang('yes'); ?></option>
                    </select>
                </div>
            </div>
 

            <div class="form-group">
                <label class="col-lg-4 control-label"><?php echo lang('new_customers_only'); ?></label>
                <div class="col-lg-4">
                    <select class="form-control" name="new_customers">
                        <option value="0"><?php echo lang('no'); ?></option>
                        <option value="1"><?php echo lang('yes'); ?></option>
                    </select>
                </div>
            </div>


            <div class="form-group">
                <label class="col-lg-4 control-label"><?php echo lang('use_start_end_date'); ?></label>
                <div class="col-lg-4">
                    <select class="form-control" name="use_date">
                        <option value="0"><?php echo lang('no'); ?></option>
                        <option value="1"><?php echo lang('yes'); ?></option>
                    </select>
                </div>
            </div>


            <div class="form-group">
                <label class="col-lg-4 control-label"><?php echo lang('start_date'); ?></label>
                <div class="col-lg-4">
                    <input class="input-sm input-s datepicker-input form-control" size="16" type="text"
                        value="<?php echo date('Y-m-d'); ?>" name="start_date"
                        data-date-format="<?php echo config_item('date_picker_format'); ?>">
                </div>
            </div>



            <div class="form-group">
                <label class="col-lg-4 control-label"><?php echo lang('end_date'); ?></label>
                <div class="col-lg-4">
                    <input class="input-sm input-s datepicker-input form-control" size="16" type="text"
                        value="<?php echo date('Y-m-d'); ?>" name="end_date"
                        data-date-format="<?php echo config_item('date_picker_format'); ?>">
                </div>
            </div>



        </div>
        <div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a>
            <button type="submit" class="btn btn-<?php echo config_item('theme_color'); ?>"><?php echo lang('add_promotion'); ?></button>
            </form>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->


<script type="text/javascript">
    
	var currency = '<?php echo config_item('default_currency'); ?>';
	var percent = '%';

	$('#type').text(currency);

	$('#select').on('change', function(){
		var option = $(this).find('option:selected');
		if(option.val() == 1) {
			$('#type').text(currency);
		}
		else
		{
			$('#type').text(percent);
		}
	});

	$('.select2, .select2domains, .select2options').select2();

	$('#generate').on('click', function() {
		$('#code').val(generate(8));
	});

	function generate(length) {
		var result = '';
		var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		var charactersLength = characters.length;
		for (var i = 0; i < length; i++) {
			result += characters.charAt(Math.floor(Math.random() * charactersLength));
		}
		return result;
	}
</script>