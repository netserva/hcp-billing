<div class="modal-dialog modal-lg">
	<div class="modal-content">
	<?php
         $attributes = ['class' => 'bs-example form-horizontal'];
          echo form_open(base_url().'blocks/configure', $attributes); ?>	
		<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button> 

		<div class="row">
			<div class="col-md-9"><h2 class="modal-title"><?php echo $_block->name; ?></h2></div>
			<div class="col-md-3">
			<?php if ('Module' == $_block->type) {
              if (!empty($_block->settings)) {
                  $settings = unserialize($_block->settings);
              } else {
                  $settings = ['title' => 'no'];
              } ?>
					<?php echo lang('display_title'); ?>&nbsp; &nbsp;
				 <input type='radio' name='title' value='no' <?php echo ('no' == $settings['title']) ? 'checked' : ''; ?>/> <?php echo lang('no'); ?> &nbsp;
				 <input type='radio' name='title' value='yes' <?php echo ('yes' == $settings['title']) ? 'checked' : ''; ?>/> <?php echo lang('yes'); ?>				
				<?php
          } ?>	
			</div>
			</div>				 
		</div> 
			  
		  <input type="hidden" value="<?php echo $_block->module; ?>" name="module">
		  <input type="hidden" value="<?php echo $_block->type; ?>" name="type">
		  <input type="hidden" value="<?php echo $_block->name; ?>" name="name">
		  <input type="hidden" value="<?php echo (isset($_block->param)) ? $_block->param : $_block->id; ?>" name="id">
		<div class="modal-body">
			  <div class="row">
			  	<div class="col-md-9">
				  <img class="img-responsive" src="<?php echo base_url(); ?>themes/<?php echo config_item('active_theme'); ?>/assets/images/sections.png" alt="Theme Sections" />
				  </div>

				  <div class="col-md-3">
				  	<h4><?php echo lang('display'); ?></h4>
				  	<select name="section" class="form-control">
					  <option value=""><?php echo lang('none'); ?></option>
					  <?php foreach ($blocks as $block) { ?>
						<option value="<?php echo $block->section; ?>" 
						<?php if (count($config) > 0) {
              foreach ($config as $conf) {
                  if ($conf->section == $block->section) {
                      echo 'selected';

                      break;
                  }
              }
          } ?>><?php echo $block->name; ?></option>
					  <?php } ?>
					  </select>

					  <hr>

					 
					  <h4><?php echo lang('pages'); ?></h4>	
					  <input type='radio' name='mode' value='show' required <?php echo (count($config) > 0 && 'show' == $config[0]->mode) ? 'checked' : ''; ?>/> <?php echo lang('show_in_selected'); ?><br />
					  <input type='radio' name='mode' value='hide' required <?php echo (count($config) > 0 && 'hide' == $config[0]->mode) ? 'checked' : ''; ?>/> <?php echo lang('hide_in_selected'); ?>				
					  <div id="page_selection">	 
						<?php $pages[] = (object) ['slug' => 'contact', 'title' => lang('contact')];
                        foreach ($pages as $key => $p) { ?>
							<div class="checkbox">
								<label class="checkbox-custom">
									<input type="hidden" value="off" name="<?php echo $p->slug; ?>" />
									<input <?php if (count($config) > 0) {
                            foreach ($config as $conf) {
                                if ($conf->page == $p->slug) {
                                    echo 'checked';
                                }
                            }
                        }
                                    ?>
									 name="pages[]" value="<?php echo $p->slug; ?>" type="checkbox">
									<?php echo $p->title; ?>
								</label>
							</div>
							<?php } ?>

							
						  </div>							

							<h4><?php echo lang('weight'); ?></h4>
							<select name="weight" class="form-control"> 
								<?php $weight = 0;
                                while ($weight < 11) { ?>
									<option value="<?php echo $weight; ?>" <?php if (count($config) > 0) {
                                    foreach ($config as $conf) {
                                        if ($conf->weight == $weight) {
                                            echo 'selected';

                                            break;
                                        }
                                    }
                                }
                                    ?>
									><?php echo $weight; ?></option>
								<?php ++$weight; } ?>
							</select>
						<hr>
			  </row>			
		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a> 
		<button type="submit" class="btn btn-<?php echo config_item('theme_color'); ?>"><?php echo lang('save_changes'); ?></button>
		</form>
		</div>
	</div>
	<!-- /.modal-content -->
</div>
 