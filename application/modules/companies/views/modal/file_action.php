<?php declare(strict_types=1);
$action = (isset($action)) ? $action : ''; ?>

<?php if ('add_file' == $action) { ?>


<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button> <h4 class="modal-title"><?php echo lang('upload_file'); ?></h4>
		</div>

	<?php
             $attributes = ['class' => 'bs-example form-horizontal'];
          echo form_open_multipart(base_url().'companies/file/add', $attributes); ?>
          <input type="hidden" name="company" value="<?php echo $company; ?>">
		<div class="modal-body">

                <div class="form-group">
                    <label class="col-lg-3 control-label"><?php echo lang('file_title'); ?> <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                    <input name="title" class="form-control" required placeholder="<?php echo lang('file_title'); ?>"/>
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
                            <input type="file" name="clientfiles[]" required="">
                        </div>
                    </div>
                </div>

		<div class="modal-footer">
                    <a href="#" class="btn btn-<?php echo config_item('theme_color'); ?> pull-left" id="add-new-file"><?php echo lang('upload_another_file'); ?></a>
                    <a href="#" class="btn btn-default pull-left" id="clear-files"><?php echo lang('clear_files'); ?></a>
                    <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a>
                    <button type="submit" class="btn btn-<?php echo config_item('theme_color'); ?>"><?php echo lang('upload_file'); ?></button>
		</form>
		</div>
	        </div>
        </div>

    <script type="text/javascript">
        $('#clear-files').on('click', function(){
            $('#file_container').html(
                "<div class='form-group'>" +
                    "<div class='col-lg-offset-3 col-lg-9'>" +
                    "<input type='file' name='clientfiles[]'>" +
                    "</div></div>"
            );
        });

        $('#add-new-file').on('click', function(){
            $('#file_container').append(
                "<div class='form-group'>" +
                "<div class='col-lg-offset-3 col-lg-9'>" +
                "<input type='file' name='clientfiles[]'>" +
                "</div></div>"
            );
        });
    </script>
	<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->



<?php } ?>

<?php if ('delete_file' == $action) { ?>

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo lang('delete_file'); ?></h4>
        </div><?php
            echo form_open(base_url().'companies/file/delete'); ?>
        <div class="modal-body">
            <p><?php echo lang('delete_file_warning'); ?></p>

            <input type="hidden" name="file" value="<?php echo $file_id; ?>">

        </div>
        <div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a>
            <button type="submit" class="btn btn-danger"><?php echo lang('delete_button'); ?></button>
        </form>
    </div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->


<?php } ?>
