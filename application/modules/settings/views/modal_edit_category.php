<?php declare(strict_types=1);
$modules = $this->db->select('*')->where('parent', 0)->get('categories')->result();
$pricing_tables = ['one', 'two', 'three', 'four', 'five', 'six', 'seven'];
?>

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><?php echo lang('edit_currency'); ?></h4>
        </div>

                <?php
                $i = $this->db->where('id', $cat)->get('categories')->row();
                $attributes = ['class' => 'bs-example form-horizontal'];
                echo form_open(base_url().'settings/edit_category', $attributes); ?>
                <input type="hidden" name="id" value="<?php echo $i->id; ?>">
                <input type="hidden" name="module" value="items">
                    <div class="modal-body">

                <div class="form-group">
                            <label class="col-lg-4 control-label"><?php echo lang('cat_name'); ?> <span class="text-danger">*</span></label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" value="<?php echo $i->cat_name; ?>" name="cat_name">
                            </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-4 control-label"><?php echo lang('type'); ?></label>
                    <div class="col-lg-8">
                        <select class="select2-option form-control" name="parent" required>
                            <?php foreach ($modules as $m) { ?>
                    <option value="<?php echo $m->id; ?>" <?php echo ($m->id == $i->parent) ? 'selected="selected"' : ''; ?>><?php echo ucfirst($m->cat_name); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <?php if (9 == $i->parent || 10 == $i->parent) { ?>

                <div class="form-group">
                    <label class="col-lg-4 control-label"><?php echo lang('pricing_table'); ?></label>
                    <div class="col-lg-8">
                        <select class="select2-option form-control" name="pricing_table">
                            <?php foreach ($pricing_tables as $table) { ?>
                                <option value="<?php echo $table; ?>" <?php echo ($table == $i->pricing_table) ? 'selected' : ''; ?>><?php echo ucfirst($table); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

               <?php } ?>

                <div class="form-group">
                      <label class="col-lg-4 control-label"><?php echo lang('delete_category'); ?></label>
                      <div class="col-lg-8">
                        <label class="switch">
                          <input type="checkbox" name="delete_cat">
                          <span></span>
                        </label>
                      </div>
                    </div>


                    </div>
                    <div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a>
                        <button type="submit" class="btn btn-success"><?php echo lang('save_changes'); ?></button>
                    </div>
                </form>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
