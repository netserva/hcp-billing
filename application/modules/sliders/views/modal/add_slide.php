<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button> <h4 class="modal-title"><?php echo lang('new_slide'); ?></h4>
		</div>

	<?php
             $attributes = ['class' => 'bs-example form-horizontal'];
          echo form_open_multipart(base_url().'sliders/add_slide/', $attributes); ?>
          <input type="hidden" name="slider" value="<?php echo $slider_id; ?>">
		<div class="modal-body">

                <div class="form-group">
                    <label class="col-lg-3 control-label"><?php echo lang('title'); ?></label>
                    <div class="col-lg-9">
                    <input name="title" class="form-control" placeholder="<?php echo lang('title'); ?>"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label"><?php echo lang('description'); ?></label>
                    <div class="col-lg-9">
                    <textarea name="description" class="form-control ta" placeholder="<?php echo lang('description'); ?>" ></textarea>
                    </div>
                </div>

                <div id="file_container">
                    <div class="form-group">
                        <div class="col-lg-offset-3 col-lg-9">
                            <input type="file" name="images[]" required="">
                        </div>
                    </div>
                </div>

		<div class="modal-footer"> 
                    <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a>
                    <button type="submit" class="btn btn-<?php echo config_item('theme_color'); ?>"><?php echo lang('add_slide'); ?></button>
		</form>
		</div>
	        </div>
        </div>

 
	<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->

 