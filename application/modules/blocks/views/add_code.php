<div class="box"> 
    <div class="box-body"> 
    <div class="container"> 
    <h2><?php echo lang('custom_block'); ?> <a href="<?php echo base_url(); ?>blocks/add" class="btn btn-info pull-right"><?php echo lang('rict_text_format'); ?></a></h2>
		<?php
             $attributes = ['class' => 'bs-example form-horizontal'];
          echo form_open(base_url().'blocks/add', $attributes); ?>   

          		<div class="form-group">
				<label class="control-label"><?php echo lang('name'); ?> <span class="text-danger">*</span></label>
		 			<input type="text" class="form-control" name="name">
				</div> 

				<div class="form-group">
				<label class="control-label"><?php echo lang('type'); ?> <span class="text-danger">*</span></label>
					<select type="text" class="form-control" name="format">
						<option value="js" class="form-control">HTML & Javascript - <?php echo lang('including_tags'); ?></optopn>
						<option value="php" class="form-control">PHP - <?php echo lang('excluding_tags'); ?></optopn>						
					</select>
				</div>

				<div class="form-group">
				<label class="control-label"><?php echo lang('content'); ?> <span class="text-danger">*</span></label>
						<textarea class="form-control" name="content" rows="10" cols="50"></textarea>
				</div>
				 
		<div class="box-footer"><button type="submit" class="btn btn-<?php echo config_item('theme_color'); ?> pull-right"><?php echo lang('save'); ?></button>		
    </div>
    </form>
    </div>
  </div>
</div>