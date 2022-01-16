<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header bg-danger"> 
		<button type="button" class="close" data-dismiss="modal">&times;</button> 
		<h4 class="modal-title"><?php echo lang('delete_slide'); ?></h4>
		</div><?php
            echo form_open(base_url().'sliders/delete_slide'); ?>
		<div class="modal-body">
			<p><?php echo lang('delete_slide_warning'); ?></p>
			
			<input type="hidden" name="slide_id" value="<?php echo $slide->slide_id; ?>">
          	<input type="hidden" name="current_image" value="<?php echo $slide->image; ?>">

		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a>
			<button type="submit" class="btn btn-<?php echo config_item('theme_color'); ?>"><?php echo lang('delete_button'); ?></button>
		</form>
	</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->