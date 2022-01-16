<?php declare(strict_types=1);
$company_ref = config_item('company_id_prefix').$this->applib->generate_string();
while (1 == $this->db->where('company_ref', $company_ref)->get('companies')->num_rows()) {
    $company_ref = config_item('company_id_prefix').$this->applib->generate_string();
} ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo lang('new_client'); ?></h4>
        </div><?php
            echo form_open(base_url().'companies/create'); ?>
        <div class="modal-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li><a class="active" data-toggle="tab" href="#tab-client-general"><?php echo lang('details'); ?></a></li>
                        <li><a data-toggle="tab" href="#tab-client-contact"><?php echo lang('address'); ?></a></li>
                        <li><a data-toggle="tab" href="#tab-client-custom"><?php echo lang('custom_fields'); ?></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab-client-general">

			 <input type="hidden" name="company_ref" value="<?php echo $company_ref; ?>">
                         <div class="row">
                                <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?php echo lang('company_name'); ?> / <?php echo lang('full_name'); ?><span class="text-danger">*</span></label>
                                            <input type="text" name="company_name" value="" class="input-sm form-control" required>
                                        </div>

                                        <div class="form-group">
                                                <label><?php echo lang('email'); ?> <span class="text-danger">*</span></label>
                                                <input type="email" name="company_email" value="" class="input-sm form-control" required>
                                        </div>

                                        <div class="form-group">
                                                <label><?php echo lang('username'); ?> <span class="text-danger">*</span></label>
                                                <input type="text" name="username" value="" class="input-sm form-control" required>
                                        </div>

                                        <div class="form-group">
                                                <label><?php echo lang('password'); ?> </label>
                                                <input type="password" value="" name="password"  class="input-sm form-control">
                                        </div>


                                        <div class="form-group">
                                                <label><?php echo lang('confirm_password'); ?> </label>
                                                <input type="password" value="" name="confirm_password"  class="input-sm form-control">
                                        </div>
                               
                                        
                                </div>

                                <div class="col-md-6">
                                        <div class="form-group">
                                                <label><?php echo lang('vat'); ?> <?php echo lang('number'); ?> </label>
                                                <input type="text" value="" name="VAT" class="input-sm form-control">
                                        </div>

                                        <div class="form-group">
                                                <label><?php echo lang('mobile_phone'); ?> </label>
                                                <input type="text" value="" name="company_mobile"  class="input-sm form-control">
                                        </div>
                                         

                                        <div class="form-group">
                                            <label><?php echo lang('phone'); ?> </label>
                                            <input type="text" value="" name="company_phone"  class="input-sm form-control">
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo lang('fax'); ?> </label>
                                            <input type="text" value="" name="company_fax"  class="input-sm form-control">
                                        </div>

                                        <div class="form-group">
                                        <label><?php echo lang('currency'); ?></label>
                                        <select name="currency" class="form-control">
                                        <?php foreach (App::currencies() as $cur) { ?>
                                        <option value="<?php echo $cur->code; ?>"<?php echo (config_item('default_currency') == $cur->code ? ' selected="selected"' : ''); ?>><?php echo $cur->name; ?></option>
                                        <?php } ?>
                                        </select>
                                     </div>

                                </div>
                         </div>                                                      
                            

                            <div class="form-group">
                                <label><?php echo lang('notes'); ?></label>
                                <textarea name="notes" class="form-control ta" placeholder="<?php echo lang('notes'); ?>" ></textarea>
                            </div>

                        </div>
                        <div class="tab-pane fade in" id="tab-client-contact">
                                
                             
                        
                                <div class="form-group">
                                        <label><?php echo lang('address'); ?></label>
                                        <textarea name="company_address" class="form-control"></textarea>
                                </div>
                                <div class="form-group col-md-6 no-gutter-left">
                                        <label><?php echo lang('city'); ?> </label>
                                        <input type="text" value="" name="city" class="input-sm form-control">
                                </div>
                                <div class="form-group col-md-6 no-gutter-right">
                                        <label><?php echo lang('zip_code'); ?> </label>
                                        <input type="text" value="" name="zip" class="input-sm form-control">
                                </div>
                            <div class="row">
                            <div class="form-group col-md-6">
                                    <label><?php echo lang('state_province'); ?> </label>
                                    <input type="text" value="" name="state" class="input-sm form-control">
                            </div>
                                <div class="form-group col-md-6">

                     
                                        <label><?php echo lang('language'); ?></label>
                                        <select name="language" class="form-control">
                                        <?php foreach (App::languages() as $lang) { ?>
                                        <option value="<?php echo $lang->name; ?>"<?php echo (config_item('default_language') == $lang->name ? ' selected="selected"' : ''); ?>><?php echo ucfirst($lang->name); ?></option>
                                        <?php } ?>
                                        </select>

                                                               
                                        <label><?php echo lang('country'); ?> </label>
                                        <select class="form-control w_180" name="country" >
                                                <optgroup label="<?php echo lang('selected_country'); ?>">
                                                        <option value="<?php echo config_item('company_country'); ?>"><?php echo config_item('company_country'); ?></option>
                                                </optgroup>
                                                <optgroup label="<?php echo lang('other_countries'); ?>">
                                                        <?php foreach (App::countries() as $country) { ?>
                                                        <option value="<?php echo $country->value; ?>"><?php echo $country->value; ?></option>
                                                        <?php } ?>
                                                </optgroup>
                                        </select>
                                </div>
                            </div>
                        </div>
                        

                        <!-- START CUSTOM FIELDS -->
                        <div class="tab-pane fade in" id="tab-client-custom">
                        <?php $fields = $this->db->order_by('order', 'DESC')->where('module', 'clients')->get('fields')->result(); ?>
                            <?php foreach ($fields as $f) { ?>
                                <?php $options = json_decode($f->field_options, true); ?>
                                <!-- check if dropdown -->
                                <?php if ('dropdown' == $f->type) { ?>

                                <div class="form-group">
                                <label><?php echo $f->label; ?> <?php echo ($f->required) ? '<abbr title="required">*</abbr>' : ''; ?></label>
                                <select class="form-control" name="<?php echo 'cust_'.$f->name; ?>" <?php echo ($f->required) ? 'required' : ''; ?> >
                                    <?php foreach ($options['options'] as $opt) { ?>
                                    <option value="<?php echo $opt['label']; ?>" <?php echo ($opt['checked']) ? 'selected="selected"' : ''; ?>><?php echo $opt['label']; ?></option>
                                    <?php } ?>
                                </select>
                                <span class="help-block"><?php echo $options['description'] ?? ''; ?></span>

                                </div>

                                <!-- Text field -->
                                <?php } elseif ('text' == $f->type) { ?>

                                    <div class="form-group">
                                    <label><?php echo $f->label; ?> <?php echo ($f->required) ? '<abbr title="required">*</abbr>' : ''; ?></label>
                                            <input type="text" name="<?php echo 'cust_'.$f->name; ?>" class="input-sm form-control" <?php echo ($f->required) ? 'required' : ''; ?>>
                                <span class="help-block"><?php echo $options['description'] ?? ''; ?></span>
                                    </div>

                                <!-- Textarea field -->
                                <?php } elseif ('paragraph' == $f->type) { ?>

                                    <div class="form-group">
                                        <label><?php echo $f->label; ?> <?php echo ($f->required) ? '<abbr title="required">*</abbr>' : ''; ?></label>
                                        <textarea name="<?php echo 'cust_'.$f->name; ?>" class="form-control ta" <?php echo ($f->required) ? 'required' : ''; ?>></textarea>
                                <span class="help-block"><?php echo $options['description'] ?? ''; ?></span>
                                    </div>

                                <!-- Radio buttons -->
                                <?php } elseif ('radio' == $f->type) { ?>
                                    <div class="form-group">
                                        <label><?php echo $f->label; ?> <?php echo ($f->required) ? '<abbr title="required">*</abbr>' : ''; ?></label>
                                        <?php foreach ($options['options'] as $opt) { ?>
                                <label class="radio-custom">
                                    <input type="radio" name="<?php echo 'cust_'.$f->name; ?>[]" <?php echo ($opt['checked']) ? 'checked="checked"' : ''; ?> value="<?php echo $opt['label']; ?>" <?php echo ($f->required) ? 'required' : ''; ?>> <?php echo $opt['label']; ?> </label>
                                        <?php } ?>
                                <span class="help-block"><?php echo $options['description'] ?? ''; ?></span>
                            </div>

                                <!-- Checkbox field -->
                                <?php } elseif ('checkboxes' == $f->type) { ?>
                                <div class="form-group">
                                        <label><?php echo $f->label; ?> <?php echo ($f->required) ? '<abbr title="required">*</abbr>' : ''; ?></label>

                                <?php foreach ($options['options'] as $opt) { ?>
                                    <div class="checkbox">
                                  <label class="checkbox-custom">
                                          <input type="checkbox" name="<?php echo 'cust_'.$f->name; ?>[]" <?php echo ($opt['checked']) ? 'checked="checked"' : ''; ?> value="<?php echo $opt['label']; ?>">
                                     <?php echo $opt['label']; ?>
                                </label>
                                    </div>
                                 <?php } ?>
                                  <span class="help-block"><?php echo $options['description'] ?? ''; ?></span>

                                </div>
                                <!-- Email Field -->
                                <?php } elseif ('email' == $f->type) { ?>

                                    <div class="form-group">
                                    <label><?php echo $f->label; ?> <?php echo ($f->required) ? '<abbr title="required">*</abbr>' : ''; ?></label>
                                            <input type="email" name="<?php echo 'cust_'.$f->name; ?>" class="input-sm form-control" <?php echo ($f->required) ? 'required' : ''; ?>>
                                <span class="help-block"><?php echo $options['description'] ?? ''; ?></span>
                                    </div>

                                <?php } elseif ('section_break' == $f->type) { ?>
                                    <hr />
                                <?php } ?>


                            <?php } ?>
                        </div>
                        <!-- End custom fields -->


                    </div>
        </div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a>
			<button type="submit" class="btn btn-<?php echo config_item('theme_color'); ?>"><?php echo lang('save_changes'); ?></button>
		</form>
	</div>
</div>
</div>
<script type="text/javascript">
    $('.nav-tabs li a').first().tab('show');
</script>
