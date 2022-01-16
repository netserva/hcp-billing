    <!-- Start Form -->
    <?php
    $view = $_GET['view'] ?? '';
    $data['load_setting'] = $load_setting;

    switch ($view) {
        case 'currency':
            $this->load->view('currency', $data);

            break;

            default: ?>


        <?php echo $this->session->flashdata('form_error'); ?>
        <?php
        $attributes = ['class' => 'bs-example form-horizontal'];
        echo form_open('settings/update', $attributes); ?>
                 <input type="hidden" name="settings" value="<?php echo $load_setting; ?>">


          
                <img src="<?php echo base_url(); ?>resource/images/gateways/resellerclub.png" alt="ResellerClub" />

                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('resellerclub_live'); ?></label>
                        <div class="col-lg-4">
                            <label class="switch">
                                <input type="hidden" value="off" name="resellerclub_live" />
                                <input type="checkbox" <?php if ('TRUE' == config_item('resellerclub_live')) {
            echo 'checked="checked"';
        } ?> name="resellerclub_live">
                                <span></span>
                            </label>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('resellerclub_resellerid'); ?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" value="<?php echo config_item('resellerclub_resellerid'); ?>" name="resellerclub_resellerid">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('resellerclub_apikey'); ?></label>
                        <div class="col-lg-4">
                            <input type="<?php echo 'TRUE' == config_item('demo_mode') ? 'password' : 'text'; ?>" class="form-control" value="<?php echo config_item('resellerclub_apikey'); ?>" name="resellerclub_apikey">
                        </div>
                    </div>

                    <div class="line line-dashed line-lg pull-in"></div>
                   
                              
                    <div class="text-center">
                        <button type="submit" class="btn btn-sm btn-<?php echo config_item('theme_color'); ?>"><?php echo lang('save_changes'); ?></button>
                    </div>
                
        </form>

         <?php
            break;
    }
    ?>
 
    <!-- End Form -->
 