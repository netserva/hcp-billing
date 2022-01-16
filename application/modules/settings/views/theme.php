	<!-- Start Form -->
		<?php
        $attributes = ['class' => 'bs-example form-horizontal'];
        echo form_open_multipart('settings/update', $attributes); ?>
			 
					<?php echo validation_errors(); ?>
					<input type="hidden" name="settings" value="<?php echo $load_setting; ?>">

					<input type="hidden" name="top_bar-color" value="<?php echo config_item('top_bar_color'); ?>">


					<div class="form-group">
						<label class="col-lg-3 control-label"><?php echo lang('skin'); ?></label>
						<div class="col-lg-3">
							 <ul id="skins" class="list-unstyled clearfix"></ul>
						</div>
					</div>


					<div class="form-group">
						<label class="col-lg-3 control-label"><?php echo lang('website_theme'); ?> </label>
					<div class="col-lg-3">
							<select name="active_theme" class="form-control">
								<option value="original" <?php echo ('original' == config_item('active_theme')) ? 'selected' : ''; ?>>Original</option>
								<option value="custom" <?php echo ('custom' == config_item('active_theme')) ? 'selected' : ''; ?>>Custom</option>
							</select>
						</div> 
					</div>
				
				
					<div class="form-group">
						<label class="col-lg-3 control-label"><?php echo lang('system_font'); ?> </label>
						<div class="col-lg-3">
							<?php $font = config_item('system_font'); ?>
							<select name="system_font" class="form-control">
								<option value="open_sans"<?php echo ('open_sans' == $font ? ' selected="selected"' : ''); ?>>Open Sans</option>
								<option value="open_sans_condensed"<?php echo ('open_sans_condensed' == $font ? ' selected="selected"' : ''); ?>>Open Sans Condensed</option>
								<option value="roboto"<?php echo ('roboto' == $font ? ' selected="selected"' : ''); ?>>Roboto</option>
								<option value="roboto_condensed"<?php echo ('roboto_condensed' == $font ? ' selected="selected"' : ''); ?>>Roboto Condensed</option>
								<option value="ubuntu"<?php echo ('ubuntu' == $font ? ' selected="selected"' : ''); ?>>Ubuntu</option>
								<option value="lato"<?php echo ('lato' == $font ? ' selected="selected"' : ''); ?>>Lato</option>
								<option value="oxygen"<?php echo ('oxygen' == $font ? ' selected="selected"' : ''); ?>>Oxygen</option>
								<option value="pt_sans"<?php echo ('pt_sans' == $font ? ' selected="selected"' : ''); ?>>PT Sans</option>
								<option value="source_sans"<?php echo ('source_sans' == $font ? ' selected="selected"' : ''); ?>>Source Sans Pro</option>
							</select>
						</div>
					</div>
			 
					<div class="form-group">
						<label class="col-lg-3 control-label"><?php echo lang('theme_color'); ?></label>
						<div class="col-lg-3">
							<?php $theme = config_item('theme_color'); ?>
							<select name="theme_color" class="form-control">
								<option value="success" <?php echo ('success' == $theme ? ' selected="selected"' : ''); ?>>Success</option>
								<option value="info" <?php echo ('info' == $theme ? ' selected="selected"' : ''); ?>>Info</option>
								<option value="danger" <?php echo ('danger' == $theme ? ' selected="selected"' : ''); ?>>Danger</option>
								<option value="warning" <?php echo ('warning' == $theme ? ' selected="selected"' : ''); ?>>Warning</option>
								<option value="dark" <?php echo ('dark' == $theme ? ' selected="selected"' : ''); ?>>Dark</option>
								<option value="primary" <?php echo ('primary' == $theme ? ' selected="selected"' : ''); ?>>Primary</option>
							</select>
						</div>
					</div>

				

					<div class="form-group">
						<label class="col-lg-3 control-label"><?php echo lang('logo_or_icon'); ?></label>
						<div class="col-lg-3">
							<select name="logo_or_icon" class="form-control">
								<?php $logoicon = config_item('logo_or_icon'); ?>
								<option value="icon_title"<?php echo ('icon_title' == $logoicon ? ' selected="selected"' : ''); ?>><?php echo lang('icon'); ?> & <?php echo lang('site_name'); ?></option>
								<option value="icon"<?php echo ('icon' == $logoicon ? ' selected="selected"' : ''); ?>><?php echo lang('icon'); ?></option>
								<option value="logo_title"<?php echo ('logo_title' == $logoicon ? ' selected="selected"' : ''); ?>><?php echo lang('logo'); ?> & <?php echo lang('site_name'); ?></option>
								<option value="logo"<?php echo ('logo' == $logoicon ? ' selected="selected"' : ''); ?>><?php echo lang('logo'); ?></option>
							</select>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-lg-3 control-label"><?php echo lang('site_icon'); ?></label>
                                                        <div class="input-group iconpicker-container col-lg-3">
                                                        <span class="input-group-addon"><i class="fa <?php echo config_item('site_icon'); ?>"></i></span>
                                                        <input id="site-icon" name="site_icon" type="text" value="<?php echo config_item('site_icon'); ?>" class="form-control icp icp-auto iconpicker-element iconpicker-input" data-placement="bottomRight">
						</div>
					</div>


					<div class="form-group">
						<label class="col-lg-3 control-label"><?php echo lang('company_logo'); ?></label>
						<div class="col-lg-2">
							<input type="file" class="filestyle" data-buttonText="<?php echo lang('choose_file'); ?>" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline input-s" name="logofile">
						</div>
						<div class="col-lg-7">
							<?php if ('' != config_item('company_logo')) { ?>
							<div class="settings-image"><img src="<?php echo base_url(); ?>resource/images/<?php echo config_item('company_logo'); ?>" /></div>
							<?php } ?>
						</div>
					</div>
		


					<div class="form-group">
						<label class="col-lg-3 control-label"><?php echo lang('favicon'); ?></label>
						<div class="col-lg-2">
							<input type="file" class="filestyle" data-buttonText="<?php echo lang('choose_file'); ?>" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline input-s" name="iconfile">
						</div>
						<div class="col-lg-7">
							<?php if ('' != config_item('site_favicon')) { ?>
							<div class="settings-image"><img src="<?php echo base_url(); ?>resource/images/<?php echo config_item('site_favicon'); ?>" /></div>
							<?php } ?>
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-3 control-label"><?php echo lang('apple_icon'); ?></label>
						<div class="col-lg-2">
							<input type="file" class="filestyle" data-buttonText="<?php echo lang('choose_file'); ?>" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline input-s" name="appleicon">
						</div>
						<div class="col-lg-7">
							<?php if ('' != config_item('site_appleicon')) { ?>
							<div class="settings-image"><img src="<?php echo base_url(); ?>resource/images/<?php echo config_item('site_appleicon'); ?>" /></div>
							<?php } ?>
						</div>
					</div>

			  
	 
					<div class="text-center">
						<button type="submit" class="btn btn-sm btn-<?php echo config_item('theme_color'); ?>"><?php echo lang('save_changes'); ?></button>
					</div>
		 
		</form>
 
	<!-- End Form -->
 