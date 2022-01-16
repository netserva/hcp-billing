   <!-- Start Form -->
         <?php
        $attributes = ['class' => 'bs-example form-horizontal'];
        echo form_open_multipart('settings/update', $attributes); ?>
           
                    <input type="hidden" name="settings" value="<?php echo $load_setting; ?>">  

                            <div class="form-group">
                            <label class="col-lg-3 control-label"><?php echo lang('domain_checker'); ?></label>
                            <div class="col-lg-5">
                                
                                </div>
                                <div class="col-lg-9" id="default_registrar">
                                <input type ="radio" name="domain_checker" value="default" <?php echo ('default' == config_item('domain_checker')) ? 'checked="checked"' : ''; ?>> <span class="label label-default"><?php echo lang('basic_checker'); ?></span> <hr>
                                <?php $registrars = Plugin::domain_registrars();
                                 foreach ($registrars as $registrar) {?> <input type ="radio" name="domain_checker" value="<?php echo $registrar->system_name; ?>" <?php echo (config_item('domain_checker') == $registrar->system_name) ? 'checked="checked"' : ''; ?>> <span class="label label-default"><?php echo ucfirst($registrar->system_name); ?></span><hr>                                    
                                    <?php } if (Plugin::get_plugin('whoisxmlapi')) {?>
                                    <input type ="radio" name="domain_checker" value="whoisxmlapi" <?php echo ('whoisxmlapi' == config_item('domain_checker')) ? 'checked="checked"' : ''; ?>> <span class="label label-default">WhoisXMLApi</span> &nbsp; <small><?php echo lang('whoisxmlapi_signup'); ?></small><hr>
                                    <?php } ?>
                                </div>
                            </div>
                            
                                
                            <div class="form-group">
                                <label class="col-lg-3 control-label"><?php echo lang('whoisxmlapi_key'); ?></label>
                                <div class="col-lg-5">                                   
                                    <input type="<?php echo 'TRUE' == config_item('demo_mode') ? 'password' : 'text'; ?>" name="whoisxmlapi_key" class="form-control" value="<?php echo config_item('whoisxmlapi_key'); ?>">
                                    <p>
                                    <span class="help-block m-b-none small text-danger"><?php echo lang('whoisxmlapi_description'); ?> </span>
                                    </p>
                                </div>
                            </div>                   
                  
           
                    <div class="text-center">
                        <button type="submit" class="btn btn-sm btn-<?php echo config_item('theme_color'); ?>"><?php echo lang('save_changes'); ?></button>
                    </div>
                 
        </form>
 
    <!-- End Form -->
 
