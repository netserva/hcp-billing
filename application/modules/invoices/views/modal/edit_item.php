<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title"><?php echo lang('edit_item'); ?></h4>
		</div>
		<?php $item = Invoice::view_item($id); ?>

		<?php
             $attributes = ['class' => 'bs-example form-horizontal'];
          echo form_open(base_url().'invoices/items/edit', $attributes); ?>
          <input type="hidden" name="item_id" value="<?php echo $item->item_id; ?>">
          <input type="hidden" name="item_order" value="<?php echo $item->item_order; ?>">
           <input type="hidden" name="invoice_id" value="<?php echo $item->invoice_id; ?>">
		<div class="modal-body">

          				<div class="form-group">
				<label class="col-lg-4 control-label"><?php echo lang('item_name'); ?> <span class="text-danger">*</span></label>
				<div class="col-lg-8">
					<input type="text" class="form-control" value="<?php echo $item->item_name; ?>" name="item_name">
				</div>
				</div>

				<div class="form-group">
				<label class="col-lg-4 control-label"><?php echo lang('item_description'); ?> </label>
				<div class="col-lg-8">
				<textarea class="form-control ta" name="item_desc"><?php echo $item->item_desc; ?></textarea>
				</div>
				</div>

				<div class="form-group">
				<label class="col-lg-4 control-label"><?php echo lang('quantity'); ?> <span class="text-danger">*</span></label>
				<div class="col-lg-8">
					<input type="text" class="form-control" value="<?php echo $item->quantity; ?>" name="quantity">
				</div>
				</div>

				<div class="form-group">
				<label class="col-lg-4 control-label"><?php echo lang('unit_price'); ?> <span class="text-danger">*</span></label>
				<div class="col-lg-8">
					<input type="text" class="form-control" value="<?php echo $item->unit_cost; ?>" name="unit_cost">
				</div>
				</div>

				<div class="form-group">
				<label class="col-lg-4 control-label"><?php echo lang('tax_rate'); ?> <span class="text-danger">*</span></label>
				<div class="col-lg-8">
					<select name="item_tax_rate" class="form-control m-b">
						<option value="<?php echo $item->item_tax_rate; ?>"><?php echo $item->item_tax_rate; ?></option>
						<option value="0.00"><?php echo lang('none'); ?></option>
						<?php foreach (Invoice::get_tax_rates() as $key => $tax) { ?>
                          <option value="<?php echo $tax->tax_rate_percent; ?>"><?php echo $tax->tax_rate_name; ?></option>
                          <?php } ?>
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
