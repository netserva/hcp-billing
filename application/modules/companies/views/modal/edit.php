<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo lang('edit_client'); ?></h4>
        </div><?php $i = Client::view_by_id($company); ?>

<?php echo form_open(base_url().'companies/update'); ?>
        <input class="hidden">
        <input type="password" class="hidden">
        <div class="modal-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li><a class="active" data-toggle="tab" href="#tab-client-general"><?php echo lang('details'); ?></a></li>
                        <li><a data-toggle="tab" href="#tab-client-contact"><?php echo lang('address'); ?></a></li> 
                        <li><a data-toggle="tab" href="#tab-client-custom"><?php echo lang('custom_fields'); ?></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab-client-general">
                            <input type="hidden" name="company_ref" value="<?php echo $i->company_ref; ?>">
                            <input type="hidden" name="co_id" value="<?php echo $i->co_id; ?>">
                            <div class="row">
                                <div class="col-md-6">

                                        <div class="form-group">
                                            <label><?php if (0 == $i->individual) {
    echo lang('company_name');
} else {
    echo lang('full_name');
} ?><span class="text-danger">*</span></label>
                                            <input type="text" name="company_name" value="<?php echo $i->company_name; ?>" class="input-sm form-control" required>
                                        </div>

                                        <div class="form-group">
                                                <label><?php echo lang('email'); ?> <span class="text-danger">*</span></label>
                                                <input type="email" name="company_email" value="<?php echo $i->company_email; ?>" class="input-sm form-control" required>
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo lang('phone'); ?> </label>
                                            <input type="text" value="<?php echo $i->company_phone; ?>" name="company_phone"  class="input-sm form-control">
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo lang('credit_balance'); ?> (<?php echo config_item('default_currency'); ?>)</label>
                                            <input type="text" value="<?php echo $i->transaction_value; ?>" name="transaction_value"  class="input-sm form-control">
                                        </div>
                                </div>

                                <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?php echo lang('vat'); ?> </label>
                                            <input type="text" value="<?php echo $i->VAT; ?>" name="VAT" class="input-sm form-control">
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo lang('mobile_phone'); ?> </label>
                                            <input type="text" value="<?php echo $i->company_mobile; ?>" name="company_mobile"  class="input-sm form-control">
                                        </div>

                                        <div class="form-group">
                                                <label><?php echo lang('fax'); ?> </label>
                                                <input type="text" value="<?php echo $i->company_fax; ?>" name="company_fax"  class="input-sm form-control">
                                        </div>

                                            
                                    <?php $currency = App::currencies($i->currency); ?>
                                <div class="form-group">
                                    <label><?php echo lang('client'); ?> <?php echo lang('currency'); ?></label>
                                    <select name="currency" class="form-control">
                                    <?php foreach (App::currencies() as $cur) { ?>
                                    <option value="<?php echo $cur->code; ?>"<?php echo ($currency->code == $cur->code ? ' selected="selected"' : ''); ?>><?php echo $cur->name; ?></option>
                                    <?php } ?>
                                    </select>
                                </div>
                                        
                                        
                                </div>
                            </div>

                            <div class="form-group">
                                <label><?php echo lang('notes'); ?></label>
                    <textarea name="notes" class="form-control ta"><?php echo $i->notes; ?></textarea>
                            </div>

                        </div>
                        <div class="tab-pane fade in" id="tab-client-contact">                          
                            
                            <div class="clearfix"></div>
                            <div class="form-group">
                                    <label><?php echo lang('address'); ?></label>
                                    <textarea name="company_address" class="form-control ta"><?php echo $i->company_address; ?></textarea>
                            </div>
                            <div class="form-group col-md-6 no-gutter-left">
                                    <label><?php echo lang('city'); ?> </label>
                                    <input type="text" value="<?php echo $i->city; ?>" name="city" class="input-sm form-control">
                            </div>
                            <div class="form-group col-md-6 no-gutter-right">
                                    <label><?php echo lang('zip_code'); ?> </label>
                                    <input type="text" value="<?php echo $i->zip; ?>" name="zip" class="input-sm form-control">
                            </div>
                            <div class="row">
                            <div class="form-group col-md-6">
                                    <label><?php echo lang('state_province'); ?> </label>
                                    <input type="text" value="<?php echo $i->state; ?>" name="state" class="input-sm form-control">
                            </div>
                            <div class="form-group col-md-6 no-gutter-right">

                                <label><?php echo lang('language'); ?></label>
                                <select name="language" class="form-control">
                                <?php foreach (App::languages() as $lang) { ?>
                                <option value="<?php echo $lang->name; ?>"<?php echo ($i->language == $lang->name ? ' selected="selected"' : ''); ?>><?php echo ucfirst($lang->name); ?></option>
                                <?php } ?>
                                </select>

                                <label><?php echo lang('country'); ?> </label>
                                <select class="form-control w_180" name="country" >
                                        <optgroup label="<?php echo lang('selected_country'); ?>">
                                                <option value="<?php echo $i->country; ?>"><?php echo $i->country; ?></option>
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
                                <?php $val = App::field_meta_value($f->name, $company); ?>
                                <?php $options = json_decode($f->field_options, true); ?>
                                <!-- check if dropdown -->
                                <?php if ('dropdown' == $f->type) { ?>

                                <div class="form-group">
                                <label><?php echo $f->label; ?> <?php echo ($f->required) ? '<abbr title="required">*</abbr>' : ''; ?></label>
                                <select class="form-control" name="<?php echo 'cust_'.$f->name; ?>" <?php echo ($f->required) ? 'required' : ''; ?> >
                                    <option value="<?php echo $val; ?>"><?php echo $val; ?></option>
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
                                            <input type="text" name="<?php echo 'cust_'.$f->name; ?>" class="input-sm form-control" value="<?php echo $val; ?>" <?php echo ($f->required) ? 'required' : ''; ?>>
                                <span class="help-block"><?php echo $options['description'] ?? ''; ?></span>
                                    </div>

                                <!-- Textarea field -->
                                <?php } elseif ('paragraph' == $f->type) { ?>

                                    <div class="form-group">
                                        <label><?php echo $f->label; ?> <?php echo ($f->required) ? '<abbr title="required">*</abbr>' : ''; ?></label>
                                        <textarea name="<?php echo 'cust_'.$f->name; ?>" class="form-control ta" <?php echo ($f->required) ? 'required' : ''; ?>><?php echo $val; ?></textarea>
                                <span class="help-block"><?php echo $options['description'] ?? ''; ?></span>
                                    </div>

                                <!-- Radio buttons -->
                                <?php } elseif ('radio' == $f->type) { ?>
                                    <div class="form-group">
                                        <label><?php echo $f->label; ?> <?php echo ($f->required) ? '<abbr title="required">*</abbr>' : ''; ?></label>
                                        <?php foreach ($options['options'] as $opt) { ?>
                                            <?php $sel_val = json_decode($val); ?>
                                <label class="radio-custom">
                                    <input type="radio" name="<?php echo 'cust_'.$f->name; ?>[]" <?php echo ($opt['checked'] || $sel_val[0] == $opt['label']) ? 'checked="checked"' : ''; ?> value="<?php echo $opt['label']; ?>" <?php echo ($f->required) ? 'required' : ''; ?>> <?php echo $opt['label']; ?> </label>
                                        <?php } ?>
                                <span class="help-block"><?php echo $options['description'] ?? ''; ?></span>
                            </div>

                                <!-- Checkbox field -->
                                <?php } elseif ('checkboxes' == $f->type) { ?>
                                <div class="form-group">
                                        <label><?php echo $f->label; ?> <?php echo ($f->required) ? '<abbr title="required">*</abbr>' : ''; ?></label>

                                <?php foreach ($options['options'] as $opt) { ?>
                                    <?php $sel_val = json_decode($val); ?>
                                    <div class="checkbox">
                                  <label class="checkbox-custom">
                                      <?php if (is_array($sel_val)) { ?>
                                          <input type="checkbox" name="<?php echo 'cust_'.$f->name; ?>[]" <?php echo ($opt['checked'] || in_array($opt['label'], $sel_val)) ? 'checked="checked"' : ''; ?> value="<?php echo $opt['label']; ?>">
                                      <?php } else { ?>
                                          <input type="checkbox" name="<?php echo 'cust_'.$f->name; ?>[]" <?php echo ($opt['checked']) ? 'checked="checked"' : ''; ?> value="<?php echo $opt['label']; ?>">
                                      <?php } ?>
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
                                            <input type="email" name="<?php echo 'cust_'.$f->name; ?>" value="<?php echo $val; ?>" class="input-sm form-control" <?php echo ($f->required) ? 'required' : ''; ?>>
                                <span class="help-block"><?php echo $options['description'] ?? ''; ?></span>
                                    </div>

                                <?php } elseif ('section_break' == $f->type) { ?>
                                    <hr />
                                <?php } ?>


                            <?php } ?>
                        </div>

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
