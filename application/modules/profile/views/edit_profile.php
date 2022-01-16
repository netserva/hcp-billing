<div class="box">
<div class="box-body">

    <div class="row">
      <div class="col-lg-6">
         <!-- Profile Form -->
        <section class="panel panel-default">
      <header class="panel-heading font-bold"><?php echo lang('profile_details'); ?></header>
      <div class="panel-body">
      <?php
      $profile = User::profile_info(User::get_id());
      $login = User::login_info(User::get_id());
        $attributes = ['class' => 'bs-example form-horizontal'];
         echo form_open(uri_string(), $attributes); ?>
         <?php echo validation_errors(); ?>

        <div class="form-group">
          <label class="col-lg-4 control-label"><?php echo lang('full_name'); ?> <span class="text-danger">*</span></label>
          <div class="col-lg-8">
          <input type="text" class="form-control" name="fullname" value="<?php echo $profile->fullname; ?>" required>
          </div>
        </div>

        <?php if (User::is_staff()) { ?>

          <div class="form-group">
          <label class="col-lg-4 control-label"><?php echo lang('hourly_rate'); ?> <span class="text-danger">*</span></label>
          <div class="col-lg-8">
          <input type="text" class="form-control" name="hourly_rate" value="<?php echo $profile->hourly_rate; ?>" required>
          </div>
        </div>

        <?php } ?>
        <input type="hidden" value="<?php echo $profile->company; ?>" name="co_id">

        <?php
        if ($profile->company > 0) {
            $comp = Client::view_by_id($profile->company); ?>  
         <div class="form-group">
          <label class="col-lg-4 control-label"><?php echo lang('company'); ?> </label>
          <div class="col-lg-8">
          <input type="text" class="form-control" name="company_data[company_name]" value="<?php echo (isset($comp->company_name)) ? $comp->company_name : ''; ?>" required>
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-4 control-label"><?php echo lang('company_email'); ?> </label>
          <div class="col-lg-8">
          <input type="text" class="form-control" name="company_data[company_email]" value="<?php echo (isset($comp->company_email)) ? $comp->company_email : ''; ?>" required>
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-4 control-label"><?php echo lang('company_address'); ?> </label>
          <div class="col-lg-8">
          <input type="text" class="form-control" name="company_data[company_address]" value="<?php echo (isset($comp->company_address)) ? $comp->company_address : ''; ?>" required>
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-4 control-label"><?php echo lang('company_vat'); ?> </label>
          <div class="col-lg-8">
          <input type="text" class="form-control" name="company_data[vat]" value="<?php echo (isset($comp->VAT)) ? $comp->VAT : ''; ?>">
          </div>
        </div>
        <?php
        } ?>
        <div class="form-group">
          <label class="col-lg-4 control-label"><?php echo lang('phone'); ?></label>
          <div class="col-lg-8">
          <input type="text" class="form-control" name="phone" value="<?php echo $profile->phone; ?>">
          </div>
        </div>

        <div class="form-group">
            <label class="col-lg-4 control-label"><?php echo lang('language'); ?></label>
            <div class="col-lg-8">
                <select name="language" class="form-control">
                <?php foreach (App::languages() as $lang) { ?>
          <option value="<?php echo $lang->name; ?>"<?php echo ($profile->language == $lang->name ? ' selected="selected"' : ''); ?>>
          <?php echo ucfirst($lang->name); ?></option>
                <?php } ?>
                </select>
            </div>
        </div>

        
        <div class="form-group">
                <label class="col-lg-4 control-label"><?php echo lang('locale'); ?></label>
                <div class="col-lg-8">
                        <select class="select2-option form-control" name="locale">
                        <?php foreach (App::locales() as $loc) { ?>
          <option value="<?php echo $loc->locale; ?>"<?php echo ($profile->locale == $loc->locale ? ' selected="selected"' : ''); ?>>
          <?php echo $loc->name; ?></option>
                        <?php } ?>
                        </select>
                </div>
        </div>
        
       
        <?php $currency = App::currencies($comp->currency); ?>
        <div class="form-group">
        <label class="col-lg-4 control-label"><?php echo lang('currency'); ?></label>
        <div class="col-lg-8">
            <select name="company_data[currency]" class="form-control">
            <?php foreach (App::currencies() as $cur) { ?>
            <option value="<?php echo $cur->code; ?>"<?php echo ($comp->currency == $cur->code ? ' selected="selected"' : ''); ?>><?php echo $cur->name; ?></option>
            <?php } ?>
            </select>
        </div>
        </div>

        <?php $fields = $this->db->order_by('order', 'DESC')->where('module', 'clients')->get('fields')->result(); ?>
        <?php foreach ($fields as $f) { ?>
            <?php $val = App::field_meta_value($f->name, $profile->company); ?>
            <?php $options = json_decode($f->field_options, true); ?>
            <?php if ('dropdown' == $f->type) { ?>

            <div class="form-group">
            <label class="col-lg-4 control-label"><?php echo $f->label; ?> <?php echo ($f->required) ? '<span class="text-danger">*</span>' : ''; ?></label>
            <div class="col-lg-8">
            <select class="form-control" name="<?php echo 'cust_'.$f->name; ?>" <?php echo ($f->required) ? 'required' : ''; ?> >
                <option value="<?php echo $val; ?>"><?php echo $val; ?></option>
                <?php foreach ($options['options'] as $opt) { ?>
                <option value="<?php echo $opt['label']; ?>" <?php echo ($opt['checked']) ? 'selected="selected"' : ''; ?>><?php echo $opt['label']; ?></option>
                <?php } ?>
            </select>
            <span class="help-block"><?php echo $options['description'] ?? ''; ?></span>
              </div>
            </div>

            <?php } elseif ('text' == $f->type) { ?>

                <div class="form-group">
                <label class="col-lg-4 control-label"><?php echo $f->label; ?> <?php echo ($f->required) ? '<span class="text-danger">*</span>' : ''; ?></label>
                <div class="col-lg-8">
                        <input type="text" name="<?php echo 'cust_'.$f->name; ?>" class="form-control" value="<?php echo $val; ?>" <?php echo ($f->required) ? 'required' : ''; ?>>
            <span class="help-block"><?php echo $options['description'] ?? ''; ?></span>
            </div>
                </div>

            <?php } elseif ('paragraph' == $f->type) { ?>

                <div class="form-group">
                <label class="col-lg-4 control-label"><?php echo $f->label; ?> <?php echo ($f->required) ? '<span class="text-danger">*</span>' : ''; ?></label>
                <div class="col-lg-8">
                    <textarea name="<?php echo 'cust_'.$f->name; ?>" class="form-control ta" <?php echo ($f->required) ? 'required' : ''; ?>><?php echo $val; ?></textarea>
            <span class="help-block"><?php echo $options['description'] ?? ''; ?></span>
            </div>
                </div>

            <?php } elseif ('radio' == $f->type) { ?>
                <div class="form-group">
                <label class="col-lg-4 control-label"><?php echo $f->label; ?> <?php echo ($f->required) ? '<span class="text-danger">*</span>' : ''; ?></label>
                <div class="col-lg-8">
                    <?php foreach ($options['options'] as $opt) { ?>
                        <?php $sel_val = json_decode($val); ?>
            <label class="radio-custom">
                <input type="radio" name="<?php echo 'cust_'.$f->name; ?>[]" <?php echo ($opt['checked'] || $sel_val[0] == $opt['label']) ? 'checked="checked"' : ''; ?> value="<?php echo $opt['label']; ?>" <?php echo ($f->required) ? 'required' : ''; ?>> <?php echo $opt['label']; ?> </label>
                    <?php } ?>
            <span class="help-block"><?php echo $options['description'] ?? ''; ?></span>
            </div>
        </div>

            <?php } elseif ('checkboxes' == $f->type) { ?>
            <div class="form-group">
            <label class="col-lg-4 control-label"><?php echo $f->label; ?> <?php echo ($f->required) ? '<span class="text-danger">*</span>' : ''; ?></label>
            <div class="col-lg-8">
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
            </div>

            <?php } elseif ('email' == $f->type) { ?>

                <div class="form-group">
                <label class="col-lg-4 control-label"><?php echo $f->label; ?> <?php echo ($f->required) ? '<span class="text-danger">*</span>' : ''; ?></label>
                <div class="col-lg-8">
                        <input type="email" name="<?php echo 'cust_'.$f->name; ?>" value="<?php echo $val; ?>" class="input-sm form-control" <?php echo ($f->required) ? 'required' : ''; ?>>
            <span class="help-block"><?php echo $options['description'] ?? ''; ?></span>
                </div>
              </div>
            <?php } elseif ('section_break' == $f->type) { ?>
                <hr />
            <?php } ?>
        <?php } ?> 
        
        <button type="submit" class="btn btn-sm btn-dark"><?php echo lang('update_profile'); ?></button>
      </form>


      <h4 class="page-header"><?php echo lang('change_email'); ?></h4>

       <?php
       $attributes = ['class' => 'bs-example form-horizontal'];
        echo form_open(base_url().'auth/change_email', $attributes); ?>
        <input type="hidden" name="r_url" value="<?php echo uri_string(); ?>">

        <div class="form-group">
          <label class="col-lg-4 control-label"><?php echo lang('current_email'); ?></label>
          <div class="col-lg-8">
          <input type="text" class="form-control" name="" value="<?php echo User::login_info(User::get_id())->email; ?>" readonly="readonly">
          </div>
        </div>


     <div class="form-group">
          <label class="col-lg-4 control-label"><?php echo lang('password'); ?></label>
          <div class="col-lg-8">
          <input type="password" class="form-control" name="password" placeholder="<?php echo lang('password'); ?>" required>
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-4 control-label"><?php echo lang('new_email'); ?></label>
          <div class="col-lg-8">
          <input type="email" class="form-control" name="email" placeholder="<?php echo lang('new_email'); ?>" required>
          </div>
        </div>
        
        <button type="submit" class="btn btn-sm btn-success"><?php echo lang('change_email'); ?></button>
      </form>


    </div>
  </section>
  <!-- /profile form -->
</div>
<div class="col-lg-6">
      
        <!-- Account Form -->
        <section class="panel panel-default">
      <header class="panel-heading font-bold"><?php echo lang('account_details'); ?></header>
      <div class="panel-body">
        <?php
        echo form_open(base_url().'auth/change_password'); ?>
        <input type="hidden" name="r_url" value="<?php echo uri_string(); ?>">
        <div class="form-group">
          <label><?php echo lang('old_password'); ?> <span class="text-danger">*</span></label>
          <input type="password" class="form-control" name="old_password" placeholder="<?php echo lang('old_password'); ?>" required>
        </div>
        <div class="form-group">
          <label><?php echo lang('new_password'); ?> <span class="text-danger">*</span></label>
          <input type="password" class="form-control" name="new_password" placeholder="<?php echo lang('new_password'); ?>" required>
        </div>
         <div class="form-group">
          <label><?php echo lang('confirm_password'); ?> <span class="text-danger">*</span></label>
          <input type="password" class="form-control" name="confirm_new_password" placeholder="<?php echo lang('confirm_password'); ?>" required>
        </div>
        
        <button type="submit" class="btn btn-sm btn-dark"><?php echo lang('change_password'); ?></button>
      </form>

<h4 class="page-header"><?php echo lang('avatar_image'); ?></h4>

       <?php
       $attributes = ['class' => 'bs-example form-horizontal'];
        echo form_open_multipart(base_url().'profile/changeavatar', $attributes); ?>
        <input type="hidden" name="r_url" value="<?php echo uri_string(); ?>">

        <div class="form-group">
                      <label class="col-lg-3 control-label"><?php echo lang('use_gravatar'); ?></label>
                      <div class="col-lg-8">
                        <label class="switch">
                          <input type="checkbox" <?php if ('Y' == $profile->use_gravatar) {
            echo 'checked="checked"';
        } ?> name="use_gravatar">
                          <span></span>
                        </label>
                      </div>
        </div>

       <div class="form-group">
        <label class="col-lg-3 control-label"><?php echo lang('avatar_image'); ?></label>
        <div class="col-lg-9">
          <input type="file" class="filestyle" data-buttonText="<?php echo lang('choose_file'); ?>" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline input-s" name="userfile">
        </div>
      </div>
        <button type="submit" class="btn btn-sm btn-success"><?php echo lang('change_avatar'); ?></button>
      </form>

      <h4 class="page-header"><?php echo lang('change_username'); ?></h4>

       <?php
       $attributes = ['class' => 'bs-example form-horizontal'];
        echo form_open(base_url().'auth/change_username', $attributes); ?>
        <input type="hidden" name="r_url" value="<?php echo uri_string(); ?>">
     
        <div class="form-group">
          <label class="col-lg-4 control-label"><?php echo lang('new_username'); ?></label>
          <div class="col-lg-7">
          <input type="text" class="form-control" name="username" placeholder="<?php echo lang('new_username'); ?>" required>
          </div>
        </div>
        
        <button type="submit" class="btn btn-sm btn-danger"><?php echo lang('change_username'); ?></button>
      </form>


    </div>
  </section>
  <!-- /Account form -->
  </div>
    </div>
  </div> 