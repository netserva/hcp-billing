<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><?php echo lang('edit_item'); ?></h4>
        </div>
        <?php $item = Item::view_item($id); ?>

        <?php
             $attributes = ['class' => 'bs-example form-horizontal'];
          echo form_open(base_url().'items/edit_item', $attributes); ?>
        <input type="hidden" name="r_url" value="<?php echo base_url(); ?>items?view=domains">
        <input type="hidden" name="item_id" value="<?php echo $item->item_id; ?>">
        <input type="hidden" name="quantity" value="1">
        <div class="modal-body">

            <div class="form-group">
                <label class="col-lg-4 control-label"><?php echo lang('category'); ?> <span class="text-danger">*</span></label>
                <div class="col-lg-5">
                    <select name="category" class="form-control m-b" required>
                        <?php foreach ($categories as $key => $cat) { ?>
                        <option value="<?php echo $cat->id; ?>" <?php echo ($item->category == $cat->id) ? 'selected' : ''; ?>>
                            <?php echo $cat->cat_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <a href="<?php echo base_url(); ?>settings/add_category" class="btn btn-<?php echo config_item('theme_color'); ?> btn-sm"
                    data-toggle="ajaxModal" title="<?php echo lang('add_category'); ?>"><i class="fa fa-plus"></i>
                    <?php echo lang('add_category'); ?></a>
            </div>


            <div class="form-group">
                <label class="col-lg-4 control-label"><?php echo lang('item_name'); ?> <span class="text-danger">*</span></label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" value="<?php echo $item->item_name; ?>" name="item_name" required>
                </div>
            </div>


            <div class="form-group">
                <label class="col-lg-4 control-label"><?php echo lang('registrar'); ?></label>
                <div class="col-lg-8">
                    <select class="form-control" name="default_registrar">
                        <option value=""><?php echo lang('none'); ?></option>
                        <?php $registrars = Plugin::domain_registrars();
                        foreach ($registrars as $registrar) {?>
                        <option value="<?php echo $registrar->system_name; ?>" <?php echo ($item->default_registrar == $registrar->system_name) ? 'selected' : ''; ?>><?php echo ucfirst($registrar->system_name); ?></option><?php } ?>
                    </select>
                </div>
            </div>


            <div class="form-group">
                <label class="col-lg-4 control-label"><?php echo lang('display'); ?></label>
                <div class="col-lg-8">
                    <label class="switch">
                        <input type="hidden" value="off" name="display" />
                        <input type="checkbox" <?php if ('Yes' == $item->display) {
                            echo 'checked="checked"';
                        } ?>
                            name="display">
                        <span></span>
                    </label>
                </div>
            </div>


            <div class="form-group">
                <label class="col-lg-4 control-label"><?php echo lang('registration'); ?></label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" value="<?php echo $item->registration; ?>" name="registration">
                </div>
            </div>


            <div class="form-group">
                <label class="col-lg-4 control-label"><?php echo lang('transfer'); ?></label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" value="<?php echo $item->transfer; ?>" name="transfer">
                </div>
            </div>


            <div class="form-group">
                <label class="col-lg-4 control-label"><?php echo lang('renewal'); ?></label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" value="<?php echo $item->renewal; ?>" name="renewal">
                </div>
            </div>


            <div class="form-group">
                <label class="col-lg-4 control-label"><?php echo lang('max_years'); ?></label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" value="<?php echo $item->max_years; ?>" name="max_years">
                </div>
            </div>


            <div class="form-group">
                <label class="col-lg-4 control-label"><?php echo lang('tax_rate'); ?> </label>
                <div class="col-lg-8">
                    <select name="item_tax_rate" class="form-control m-b">
                        <option value="<?php echo $item->item_tax_rate; ?>"><?php echo $item->item_tax_rate; ?></option>
                        <option value="0.00"><?php echo lang('none'); ?></option>
                        <?php foreach ($rates as $key => $tax) { ?>
                        <option value="<?php echo $tax->tax_rate_percent; ?>"><?php echo $tax->tax_rate_name; ?></option>
                        <?php } ?>
                    </select>
                </div>


                <div class="form-group">
                    <label class="col-lg-4 control-label"><?php echo lang('order'); ?></label>
                    <div class="col-lg-8">
                        <input type="text" id="order_by" class="form-control" value="<?php echo $item->order_by; ?>"
                            name="order_by">
                    </div>
                </div>


            </div>
            <div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a>
                <button type="submit"
                    class="btn btn-<?php echo config_item('theme_color'); ?>"><?php echo lang('save_changes'); ?></button>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    <script>
    $(this).showCategoryFields($('#item_category')[0]);
    </script>