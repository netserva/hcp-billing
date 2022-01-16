<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><?php echo lang('add_currency'); ?></h4>
        </div>

                <?php
                $attributes = ['class' => 'bs-example form-horizontal'];
                echo form_open(base_url().'settings/add_currency', $attributes); ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-lg-4 control-label"><?php echo lang('currency_code'); ?> <span class="text-danger">*</span></label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" placeholder="e.g USD" name="code">
                            </div>
                        </div>

                         <div class="form-group">
                            <label class="col-lg-4 control-label"><?php echo lang('currency_name'); ?> <span class="text-danger">*</span></label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" placeholder="e.g Mexican Peso" name="name">
                            </div>
                        </div>

                         <div class="form-group">
                            <label class="col-lg-4 control-label"><?php echo lang('currency_symbol'); ?> <span class="text-danger">*</span></label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" placeholder="e.g $" name="symbol">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-4 control-label"><?php echo lang('xrate'); ?> <span class="text-danger">*</span></label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" placeholder="e.g 200" name="xrate">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a>
                        <button type="submit" class="btn btn-<?php echo config_item('theme_color'); ?>"><?php echo lang('save_changes'); ?></button>
                    </div>
                </form>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
