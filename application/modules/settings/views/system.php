    <!-- Start Form -->
        <?php
        $attributes = ['class' => 'bs-example form-horizontal'];
        echo form_open_multipart('settings/update', $attributes); ?>
                       <?php echo validation_errors(); ?>
                    <input type="hidden" name="settings" value="<?php echo $load_setting; ?>">

                    
                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?php echo lang('automatic_updates'); ?></label>
                        <div class="col-lg-3">
                            <label class="switch">
                                <input type="hidden" value="off" name="automatic_updates" />
                                <input type="checkbox" <?php if ('TRUE' == config_item('automatic_updates')) {
            echo 'checked="checked"';
        } ?> name="automatic_updates">
                                <span></span>
                            </label>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?php echo lang('automatic_bug_fixes'); ?></label>
                        <div class="col-lg-3">
                            <label class="switch">
                                <input type="hidden" value="off" name="automatic_bug_fixes" />
                                <input type="checkbox" <?php if ('TRUE' == config_item('automatic_bug_fixes')) {
            echo 'checked="checked"';
        } ?> name="automatic_bug_fixes">
                                <span></span>
                            </label>
                        </div>
                    </div>
                    

                 <div class="form-group">
                        <label class="col-lg-3 control-label"><?php echo lang('default_language'); ?></label>
                        <div class="col-lg-3">
                            <select name="default_language" class="form-control">
                                <?php foreach ($languages as $lang) { ?>
                                    <option lang="<?php echo $lang->code; ?>" value="<?php echo $lang->name; ?>"<?php echo (config_item('default_language') == $lang->name ? ' selected="selected"' : ''); ?>><?php echo ucfirst($lang->name); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

       
                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?php echo lang('locale'); ?></label>
                        <div class="col-lg-3">
                            <select class="select2-option form-control" name="locale" required>
                                <?php foreach ($locales as $loc) { ?>
                                    <option lang="<?php echo $loc->code; ?>" value="<?php echo $loc->locale; ?>"<?php echo (config_item('locale') == $loc->locale ? ' selected="selected"' : ''); ?>><?php echo $loc->name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                       </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?php echo lang('timezone'); ?></label>
                        <div class="col-lg-3">
                            <select class="select2-option" name="timezone" class="form-control" required>
                                <?php foreach ($timezones as $timezone => $description) { ?>
                                    <option value="<?php echo $timezone; ?>"<?php echo (config_item('timezone') == $timezone ? ' selected="selected"' : ''); ?>><?php echo $description; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>



                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?php echo lang('default_currency'); ?></label>
                        <div class="col-lg-3">
                            <select name="default_currency" class="form-control">
                                <?php foreach ($currencies as $cur) { ?>
                                    <option value="<?php echo $cur->code; ?>"<?php echo (config_item('default_currency') == $cur->code ? ' selected="selected"' : ''); ?>><?php echo $cur->name; ?></option>
                                <?php } ?>
                            </select>

                        </div>
                        <a class="btn btn-success btn-sm" data-toggle="ajaxModal" href="<?php echo base_url(); ?>settings/add_currency"><?php echo lang('add_currency'); ?></a>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?php echo lang('default_currency_symbol'); ?></label>
                        <div class="col-lg-3">
                            <select name="default_currency_symbol" class="form-control">
                                <?php $cur = App::currencies(config_item('default_currency')); ?>
                                <?php foreach ($currencies as $cur) { ?>
                                    <option value="<?php echo $cur->symbol; ?>" <?php echo (config_item('default_currency_symbol') == $cur->symbol ? ' selected="selected"' : ''); ?>><?php echo $cur->symbol; ?> - <?php echo $cur->name; ?></option>
                                <?php } ?>
                            </select>
                        </div>                    
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?php echo lang('currency_position'); ?></label>
                        <div class="col-lg-3">
                            <select name="currency_position" class="form-control">
                                    <option value="before"<?php echo ('before' == config_item('currency_position') ? ' selected="selected"' : ''); ?>><?php echo lang('before_amount'); ?></option>
                                    <option value="after"<?php echo ('after' == config_item('currency_position') ? ' selected="selected"' : ''); ?>><?php echo lang('after_amount'); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?php echo lang('currency_decimals'); ?></label>
                        <div class="col-lg-2">
                            <select name="currency_decimals" class="form-control">
                                    <option value="0"<?php echo (0 == config_item('currency_decimals') ? ' selected="selected"' : ''); ?>>0</option>
                                    <option value="1"<?php echo (1 == config_item('currency_decimals') ? ' selected="selected"' : ''); ?>>1</option>
                                    <option value="2"<?php echo (2 == config_item('currency_decimals') ? ' selected="selected"' : ''); ?>>2</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?php echo lang('decimal_separator'); ?></label>
                        <div class="col-lg-2">
                            <input type="text" class="form-control" value="<?php echo config_item('decimal_separator'); ?>" name="decimal_separator">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?php echo lang('thousand_separator'); ?></label>
                        <div class="col-lg-2">
                            <input type="text" class="form-control" value="<?php echo config_item('thousand_separator'); ?>" name="thousand_separator">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?php echo lang('tax'); ?> %</label>
                        <div class="col-lg-2">
                            <input type="text" class="form-control money" value="<?php echo config_item('default_tax'); ?>" name="default_tax">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Tax Name</label>
                        <div class="col-lg-2">
                            <input type="text" class="form-control" value="<?php echo config_item('tax_name'); ?>" name="tax_name">
                        </div>
                    </div>

                     
                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?php echo lang('tax_decimals'); ?></label>
                        <div class="col-lg-2">
                            <select name="tax_decimals" class="form-control">
                                    <option value="0"<?php echo (0 == config_item('tax_decimals') ? ' selected="selected"' : ''); ?>>0</option>
                                    <option value="1"<?php echo (1 == config_item('tax_decimals') ? ' selected="selected"' : ''); ?>>1</option>
                                    <option value="2"<?php echo (2 == config_item('tax_decimals') ? ' selected="selected"' : ''); ?>>2</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?php echo lang('quantity_decimals'); ?></label>
                        <div class="col-lg-2">
                            <select name="quantity_decimals" class="form-control">
                                    <option value="0"<?php echo (0 == config_item('quantity_decimals') ? ' selected="selected"' : ''); ?>>0</option>
                                    <option value="1"<?php echo (1 == config_item('quantity_decimals') ? ' selected="selected"' : ''); ?>>1</option>
                                    <option value="2"<?php echo (2 == config_item('quantity_decimals') ? ' selected="selected"' : ''); ?>>2</option>
                            </select>
                        </div>
                    </div>
                    
                    <?php $date_format = config_item('date_format'); ?>
                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?php echo lang('date_format'); ?></label>
                        <div class="col-lg-3">
                            <select name="date_format" class="form-control">
                                <option value="%d-%m-%Y"<?php echo ('%d-%m-%Y' == $date_format ? ' selected="selected"' : ''); ?>><?php echo strftime('%d-%m-%Y', time()); ?></option>
                                <option value="%m-%d-%Y"<?php echo ('%m-%d-%Y' == $date_format ? ' selected="selected"' : ''); ?>><?php echo strftime('%m-%d-%Y', time()); ?></option>
                                <option value="%Y-%m-%d"<?php echo ('%Y-%m-%d' == $date_format ? ' selected="selected"' : ''); ?>><?php echo strftime('%Y-%m-%d', time()); ?></option>
                                <option value="%Y.%m.%d"<?php echo ('%Y.%m.%d' == $date_format ? ' selected="selected"' : ''); ?>><?php echo strftime('%Y.%m.%d', time()); ?></option>
                                <option value="%d.%m.%Y"<?php echo ('%d.%m.%Y' == $date_format ? ' selected="selected"' : ''); ?>><?php echo strftime('%d.%m.%Y', time()); ?></option>
                                <option value="%m.%d.%Y"<?php echo ('%m.%d.%Y' == $date_format ? ' selected="selected"' : ''); ?>><?php echo strftime('%m.%d.%Y', time()); ?></option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?php echo lang('allow_js_php_blocks'); ?></label>
                        <div class="col-lg-3">
                            <label class="switch">
                                <input type="hidden" value="off" name="allow_js_php_blocks" />
                                <input type="checkbox" <?php if ('TRUE' == config_item('allow_js_php_blocks')) {
            echo 'checked="checked"';
        } ?> name="allow_js_php_blocks">
                                <span></span>
                            </label>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?php echo lang('enable_languages'); ?></label>
                        <div class="col-lg-3">
                            <label class="switch">
                                <input type="hidden" value="off" name="enable_languages" />
                                <input type="checkbox" <?php if ('TRUE' == config_item('enable_languages')) {
            echo 'checked="checked"';
        } ?> name="enable_languages">
                                <span></span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?php echo lang('allow_client_registration'); ?></label>
                        <div class="col-lg-3">
                            <label class="switch">
                                <input type="hidden" value="off" name="allow_client_registration" />
                                <input type="checkbox" <?php if ('TRUE' == config_item('allow_client_registration')) {
            echo 'checked="checked"';
        } ?> name="allow_client_registration">
                                <span></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?php echo lang('captcha_registration'); ?></label>
                        <div class="col-lg-3">
                            <label class="switch">
                                <input type="hidden" value="off" name="captcha_registration" />
                                <input type="checkbox" <?php if ('TRUE' == config_item('captcha_registration')) {
            echo 'checked="checked"';
        } ?> name="captcha_registration">
                                <span></span>
                            </label>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?php echo lang('auto_backup_db'); ?></label>
                        <div class="col-lg-3">
                            <label class="switch">
                                <input type="hidden" value="off" name="auto_backup_db" />
                                <input type="checkbox" <?php if ('TRUE' == config_item('auto_backup_db')) {
            echo 'checked="checked"';
        } ?> name="auto_backup_db">
                                <span></span>
                            </label>
                        </div>
                    </div>
                  
                    
                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?php echo lang('captcha_login'); ?></label>
                        <div class="col-lg-3">
                            <label class="switch">
                                <input type="hidden" value="off" name="captcha_login" />
                                <input type="checkbox" <?php if ('TRUE' == config_item('captcha_login')) {
            echo 'checked="checked"';
        } ?> name="captcha_login">
                                <span></span>
                            </label>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?php echo lang('use_recaptcha'); ?></label>
                        <div class="col-lg-2">
                            <label class="switch">
                                <input type="hidden" value="off" name="use_recaptcha" />
                                <input type="checkbox" <?php if ('TRUE' == config_item('use_recaptcha')) {
            echo 'checked="checked"';
        } ?> name="use_recaptcha">
                                <span></span>
                            </label>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?php echo lang('recaptcha_sitekey'); ?></label>
                        <div class="col-lg-3">
                            <input type="text" class="form-control" value="<?php echo config_item('recaptcha_sitekey'); ?>" name="recaptcha_sitekey">
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?php echo lang('recaptcha_secretkey'); ?></label>
                        <div class="col-lg-3">
                            <input type="text" class="form-control" value="<?php echo config_item('recaptcha_secretkey'); ?>" name="recaptcha_secretkey">
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?php echo lang('file_max_size'); ?> <span class="text-danger">*</span> </label>
                        <div class="col-lg-3">
                            <input type="text" class="form-control" value="<?php echo config_item('file_max_size'); ?>" name="file_max_size" data-type="digits" data-required="true">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?php echo lang('allowed_files'); ?></label>
                        <div class="col-lg-3">
                            <input type="text" class="form-control" value="<?php echo config_item('allowed_files'); ?>" name="allowed_files">
                        </div>
                    </div>                  

                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?php echo lang('auto_close_ticket'); ?></label>
                        <div class="col-lg-3">
                            <input type="text" class="form-control" value="<?php echo config_item('auto_close_ticket'); ?>" name="auto_close_ticket">

                        </div>
                        <span class="help-block m-b-none small text-danger"><?php echo lang('auto_close_ticket_after'); ?></span>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?php echo lang('ticket_start_number'); ?></label>
                        <div class="col-lg-3">
                            <input type="text" name="ticket_start_no" class="form-control" value="<?php echo config_item('ticket_start_no'); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?php echo lang('default_department'); ?></label>
                        <div class="col-lg-2">
                            <select name="ticket_default_department" class="form-control">
                            <?php foreach (App::get_by_where('departments', []) as $key => $d) { ?>
                            <option value="<?php echo $d->deptid; ?>"<?php echo (config_item('ticket_default_department') == $d->deptid ? ' selected="selected"' : ''); ?>><?php echo $d->deptname; ?></option>
                            <?php } ?>
                                    
                            </select>

                        </div>
                <span class="help-block m-b-none small text-danger"><?php echo lang('default_ticket_department'); ?></span>
                    </div>

                   
                
                    <div class="text-center">
                        <button type="submit" class="btn btn-sm btn-success pull-right"><?php echo lang('save_changes'); ?></button>
                    </div>             
            
        </form>
 
    <!-- End Form -->
 
