<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><?php echo lang('new_item'); ?></h4>
        </div><?php
             $attributes = ['class' => 'bs-example form-horizontal'];
          echo form_open(base_url().'items/add_item', $attributes); ?>
        <div class="modal-body">
            <input type="hidden" name="r_url" value="<?php echo base_url(); ?>items?view=hosting">
            <input type="hidden" name="quantity" value="1">
            <div class="form-group">
                <label class="col-lg-4 control-label"><?php echo lang('category'); ?> <span class="text-danger">*</span></label>
                <div class="col-lg-5">
                    <select name="category" class="form-control m-b" required>
                        <?php foreach ($categories as $key => $cat) { ?>
                        <option value="<?php echo $cat->id; ?>"><?php echo $cat->cat_name; ?></option>
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
                    <input type="text" class="form-control" placeholder="<?php echo lang('item_name'); ?>" name="item_name"
                        required>
                </div>
            </div>


            <div class="form-group">
                <label class="col-lg-4 control-label"><?php echo lang('features'); ?> </label>
                <div class="col-lg-8">
                    <textarea class='form-control ta' name='item_features'
                        placeholder='<?php echo lang('features_example'); ?>'></textarea>
                </div>
            </div>


            <div class="form-group">
                <label class="col-lg-4 control-label"><?php echo lang('monthly'); ?></label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" placeholder="0.00" name="monthly">
                </div>
            </div>


            <div class="form-group">
                <label class="col-lg-4 control-label"><?php echo lang('quarterly'); ?></label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" placeholder="0.00" name="quarterly">
                </div>
            </div>


            <div class="form-group">
                <label class="col-lg-4 control-label"><?php echo lang('semiannually'); ?></label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" placeholder="0.00" name="semi_annually">
                </div>
            </div>


            <div class="form-group">
                <label class="col-lg-4 control-label"><?php echo lang('annually'); ?></label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" placeholder="0.00" name="annually">
                </div>
            </div>


            <div class="form-group">
                <label class="col-lg-4 control-label"><?php echo lang('biennially'); ?></label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" placeholder="0.00" name="biennially">
                </div>
            </div>


            <div class="form-group">
                <label class="col-lg-4 control-label"><?php echo lang('triennially'); ?></label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" placeholder="0.00" name="triennially">
                </div>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-lg-8 control-label"><?php echo lang('order'); ?></label>
                        <div class="col-lg-4">
                            <input type="text" id="order_by" class="form-control" placeholder="1" name="order_by">
                        </div>
                    </div>
                </div>



                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-lg-7 control-label"><?php echo lang('require_domain'); ?></label>
                        <div class="col-lg-5">
                            <label class="switch">
                                <input type="hidden" value="off" name="require_domain" />
                                <input type="checkbox" name="require_domain">
                                <span></span>
                            </label>
                        </div>
                    </div>
                </div>

            </div>



            <div class="row">
                <div class="col-md-7">
                    <div class="form-group">
                        <label class="col-lg-7 control-label"><?php echo lang('tax_rate'); ?></label>
                        <div class="col-lg-5">
                            <select name="item_tax_rate" class="form-control m-b">
                                <option value="0.00"><?php echo lang('none'); ?></option>
                                <?php foreach ($rates as $key => $tax) { ?>
                                <option value="<?php echo $tax->tax_rate_percent; ?>"><?php echo $tax->tax_rate_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="form-group">
                        <label class="col-lg-6 control-label"><?php echo lang('display'); ?></label>
                        <div class="col-lg-6">
                            <label class="switch">
                                <input type="hidden" value="off" name="display" />
                                <input type="checkbox" name="display">
                                <span></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-md-4"></div>

                <div class="col-md-8">
                    <div class="form-group">
                        <label class="col-lg-8 control-label"><?php echo lang('reseller_package'); ?></label>
                        <div class="col-lg-4">
                            <label class="switch">
                                <input type="hidden" value="off" name="reseller_package" />
                                <input type="checkbox" name="reseller_package">
                                <span></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-md-4"></div>

                <div class="col-md-8">
                    <div class="form-group">
                        <label class="col-lg-8 control-label"><?php echo lang('allow_upgrade'); ?></label>
                        <div class="col-lg-4">
                            <label class="switch">
                                <input type="hidden" value="off" name="allow_upgrade" />
                                <input type="checkbox" name="allow_upgrade">
                                <span></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-4"></div>

                <div class="col-md-8">
                    <div class="form-group">
                        <label class="col-lg-8 control-label"><?php echo lang('create'); ?></label>
                        <div class="col-lg-4">
                            <label class="switch">
                                <input type="hidden" value="off" name="create_account" />
                                <input type="checkbox" name="create_account" checked>
                                <span></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>



            <div class="row"> 
                <div class="form-group">
                    <label class="col-lg-9 control-label"><?php echo lang('price_change'); ?></label>
                    <div class="col-lg-3">&nbsp;
                        <label class="switch">
                            <input type="hidden" value="off" name="price_change" />
                            <input type="checkbox" name="price_change">
                            <span></span>
                        </label>
                    </div>
                </div>
            </div>

        </div>
        <div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a>
            <button type="submit" class="btn btn-<?php echo config_item('theme_color'); ?>"><?php echo lang('add_item'); ?></button>
            </form>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->