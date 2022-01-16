<div class="box"> 
    <div class="box-body"> 
    <div class="container"> 
	<h2><?php echo lang('custom_block'); ?>
	<?php if ('TRUE' == config_item('allow_js_php_blocks')) { ?>
	 <a href="<?php echo base_url(); ?>blocks/add_code" class="btn btn-warning pull-right"><?php echo lang('code_format'); ?></a>
	<?php } ?>
	</h2> 
		<?php
             $attributes = ['class' => 'bs-example form-horizontal'];
          echo form_open(base_url().'blocks/add', $attributes); ?>
                 <input type="hidden" name="format" value="rich_text">
                 
          		<div class="form-group">
				<label class="control-label"><?php echo lang('name'); ?> <span class="text-danger">*</span></label>
		 			<input type="text" class="form-control" name="name">
				</div> 

				<div class="form-group">
				<label class="control-label"><?php echo lang('content'); ?> <span class="text-danger">*</span></label>
						<textarea class="form-control foeditor" name="content"></textarea>
				</div>
				 
		<div class="box-footer"><button type="submit" class="btn btn-<?php echo config_item('theme_color'); ?> pull-right"><?php echo lang('save'); ?></button>		
    </div>
    </form>
    </div>
  </div>
</div>