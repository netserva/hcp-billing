<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button> 
		<h4 class="modal-title"><?php echo lang('new_slider'); ?></h4>
		</div>

		<?php
             $attributes = ['class' => 'bs-example form-horizontal'];
          echo form_open(base_url().'sliders/add', $attributes); ?>
		<div class="modal-body">
			 
          		<div class="form-group">
				<label class="col-lg-4 control-label"><?php echo lang('name'); ?> <span class="text-danger">*</span></label>
				<div class="col-lg-8">
					<input type="text" class="form-control" name="name">
				</div>
				</div> 
			
		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a> 
		<button type="submit" class="btn btn-<?php echo config_item('theme_color'); ?>"><?php echo lang('save'); ?></button>
		</form>
		</div>
	</div>
	<!-- /.modal-content -->
</div>
 