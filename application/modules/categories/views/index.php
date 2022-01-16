<div class="row" id="department_settings">
    <!-- Start Form -->
    <div class="col-lg-12">     
        <?php
        $attributes = ['class' => 'bs-example form-horizontal'];
        echo form_open_multipart('settings/departments', $attributes); ?>
      
             <div class="box-header">   <h2><?php echo lang('categories'); ?></h2> </div>
                <div class="box-body">
                    <input type="hidden" name="settings" value="<?php echo $load_setting; ?>">
                    <div class="form-group">
                    <a href="<?php echo base_url(); ?>settings/add_category" class="btn btn-<?php echo config_item('theme_color'); ?> btn-sm pull-right" data-toggle="ajaxModal" title="<?php echo lang('add_category'); ?>"><i class="fa fa-plus"></i> <?php echo lang('add_category'); ?></a>
               
                    </div>
                    <?php
                    $categories = $this->db->get('categories')->result();
                    $core_categories = [8, 9, 10];
                    if (!empty($categories)) {
                        foreach ($categories as $key => $d) {
                            if (!in_array($d->id, $core_categories)) { ?>
                             <a href="<?php echo base_url(); ?>settings/edit_category/<?php echo $d->id; ?>" data-toggle="ajaxModal" class="btn btn-warning" title = ""><?php echo $d->cat_name; ?></a> 
                        <?php }
                        }
                    } ?>

                </div>
  
        </form>
    </div>
    <!-- End Form -->
</div>

