<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title"><?=lang('add_plugin')?></h4>
		</div><?php
			 $attributes = array('class' => 'bs-example form-horizontal', 'enctype' => 'multipart/form-data');
          echo form_open(base_url().'plugins/upload',$attributes); ?>
		<div class="modal-body">   
					
			<div class="form-group">
				<label class="col-lg-4 control-label"><?=lang('upload')?></label>
				<div class="col-lg-8">
				<input type="file" name="plugin_file">
				</div>
			</div>

		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a>
		<button type="submit" class="btn btn-<?=config_item('theme_color');?>"><?=lang('upload')?></button>
		</form>
		</div>
	</div>
	<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
