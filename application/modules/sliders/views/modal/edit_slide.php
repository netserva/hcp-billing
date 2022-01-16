<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button> <h4 class="modal-title"><?php echo lang('edit_slide'); ?></h4>
		</div>

	<?php
             $attributes = ['class' => 'bs-example form-horizontal'];
          echo form_open_multipart(base_url().'sliders/edit_slide/', $attributes); ?>
          <input type="hidden" name="slide_id" value="<?php echo $slide->slide_id; ?>">
          <input type="hidden" name="current_image" value="<?php echo $slide->image; ?>">
		<div class="modal-body">

                <div class="form-group">
                    <label class="col-lg-3 control-label"><?php echo lang('title'); ?></label>
                    <div class="col-lg-9">
                    <input name="title" class="form-control" value="<?php echo $slide->title; ?>"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label"><?php echo lang('description'); ?> <br />

                    <?php if (!empty($slide->image)) {?>
                        <img src="<?php echo base_url(); ?>resource/uploads/<?php echo $slide->image; ?>" class="edit_thumb" />
                        <?php } ?>
                    
                    </label>
                    <div class="col-lg-9">
                    <textarea name="description" class="form-control ta"> <?php echo $slide->description; ?></textarea>
                    </div>
                </div>               

                <div id="file_container">
                    <div class="form-group">
                        <div class="col-lg-offset-3 col-lg-9">
                            <input type="file" name="images[]">
                        </div>
                    </div>
                </div>

		<div class="modal-footer"> 
                    <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a>
                    <button type="submit" class="btn btn-<?php echo config_item('theme_color'); ?>"><?php echo lang('save'); ?></button>
		</form>
		</div>
	        </div>
        </div>

 
	<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->

 