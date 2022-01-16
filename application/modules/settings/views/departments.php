<div class="row" id="department_settings">
    <!-- Start Form -->
    <div class="col-lg-12">
        <?php
        $attributes = ['class' => 'bs-example form-horizontal'];
        echo form_open_multipart('settings/departments', $attributes); ?>
            <section class="box">

            <?php
            $view = $_GET['view'] ?? '';
            $data['load_setting'] = $load_setting;

            switch ($view) {
                case 'categories':
                        $this->load->view('categories', $data);

                        break;

                default: ?> 
                
                <div class="box-body">
                    <input type="hidden" name="settings" value="<?php echo $load_setting; ?>">
                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?php echo lang('department_name'); ?> <span class="text-danger">*</span></label>
                        <div class="col-lg-7">
                            <input type="text" name="deptname" class="form-control w_260" placeholder="<?php echo lang('department_name'); ?>" required>
                        </div>
                    </div>
                    <?php
                    $departments = $this->db->get('departments')->result();
                    if (!empty($departments)) {
                        foreach ($departments as $key => $d) { ?>
                            <label class="label label-primary"><a href="<?php echo base_url(); ?>settings/edit_dept/<?php echo $d->deptid; ?>" data-toggle="ajaxModal" title = ""><?php echo $d->deptname; ?></a></label>
                        <?php }
                    } ?>

                </div>
                <div class="box-footer">
                    <div class="text-center">
                        <button type="submit" class="btn btn-sm btn-<?php echo config_item('theme_color'); ?>"><?php echo lang('save_changes'); ?></button>
                    </div>
                </div>

                
            <?php
            break;
    }
    ?>
    
            </section>
        </form>
    </div>
    <!-- End Form -->
</div>

