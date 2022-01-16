<?php declare(strict_types=1);
$info = Ticket::view_by_id($id); ?>
  <div class="box">
		<div class="box-header b-b clearfix">
		<?php echo lang('ticket_details'); ?> - <?php echo $info->ticket_code; ?>	 
		<a href="<?php echo base_url(); ?>tickets/view/<?php echo $info->id; ?>" data-original-title="<?php echo lang('view_details'); ?>" data-toggle="tooltip" data-placement="bottom" class="btn btn-<?php echo config_item('theme_color'); ?> btn-sm pull-right"><i class="fa fa-info-circle"></i> <?php echo lang('ticket_details'); ?></a>

	 </div> 
	<div class="box-body">
	
<!-- Start ticket form -->
<?php echo $this->session->flashdata('form_error'); ?>

	<?php $attributes = ['class' => 'bs-example form-horizontal'];
          echo form_open_multipart(base_url().'tickets/edit/', $attributes);
           ?>
			 
			 <input type="hidden" name="id" value="<?php echo $info->id; ?>">

			    <div class="form-group">
				<label class="col-lg-3 control-label"><?php echo lang('ticket_code'); ?> <span class="text-danger">*</span></label>
				<div class="col-lg-3">
					<input type="text" class="form-control" value="<?php echo $info->ticket_code; ?>" name="ticket_code">
				</div>
				</div>

				<div class="form-group">
				<label class="col-lg-3 control-label"><?php echo lang('subject'); ?> <span class="text-danger">*</span></label>
				<div class="col-lg-7">
					<input type="text" class="form-control" value="<?php echo $info->subject; ?>" name="subject">
				</div>
				</div>

				

			

				<div class="form-group">
				<label class="col-lg-3 control-label"><?php echo lang('priority'); ?> <span class="text-danger">*</span> </label>
				<div class="col-lg-6">
					<div class="m-b"> 
					<select name="priority" class="form-control" >
					<option value="<?php echo $info->priority; ?>"><?php echo lang('use_current'); ?></option>
					<?php $priorities = $this->db->get('priorities')->result();
                        foreach ($priorities as $p) { ?>
					<option value="<?php echo $p->priority; ?>"><?php echo lang(strtolower($p->priority)); ?></option>
					<?php } ?>
					</select> 
					</div> 
				</div>
			</div>

			 <div class="form-group">
				<label class="col-lg-3 control-label"><?php echo lang('department'); ?> </label>
				<div class="col-lg-6">
					<div class="m-b"> 
					<select name="department" class="form-control" >
					<?php $departments = App::get_by_where('departments', ['deptid >' => '0']);
                        foreach ($departments as $d) { ?>
					<option value="<?php echo $d->deptid; ?>"<?php echo ($info->department == $d->deptid ? ' selected="selected"' : ''); ?>><?php echo strtoupper($d->deptname); ?></option>
					<?php }  ?>
					</select> 
					</div> 
				</div>
			</div>


			<div class="form-group">
				<label class="col-lg-3 control-label"><?php echo lang('reporter'); ?> <span class="text-danger">*</span> </label>
				<div class="col-lg-6">
					<div class="m-b"> 
					<select class="select2-option w_260" name="reporter" >
					<optgroup label="<?php echo lang('users'); ?>"> 
					<?php foreach (User::all_users() as $user) { ?>
					<option value="<?php echo $user->id; ?>"<?php echo ($info->reporter == $user->id ? ' selected="selected"' : ''); ?>><?php echo User::displayName($user->id); ?></option>
					<?php } ?>
					</optgroup> 
					</select> 
					</div> 
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label"><?php echo lang('ticket_message'); ?> </label>
				<div class="col-lg-9">
				<textarea name="body" class="form-control textarea"><?php echo $info->body; ?></textarea>
				
				</div>
				</div>

			<div id="file_container">
				<div class="form-group">
				<label class="col-lg-3 control-label"><?php echo lang('attachment'); ?></label>
				<div class="col-lg-6">
					<input type="file" name="ticketfiles[]">
				</div>
				</div>

			</div>

<a href="#" class="btn btn-primary btn-xs" id="add-new-file"><?php echo lang('upload_another_file'); ?></a>
<a href="#" class="btn btn-default btn-xs" id="clear-files"><?php echo lang('clear_files'); ?></a>

<div class="line line-dashed line-lg pull-in"></div>

	<button type="submit" class="btn btn-sm btn-<?php echo config_item('theme_color'); ?>"><i class="fa fa-ticket"></i> <?php echo lang('edit_ticket'); ?></button>

				
</form>

		<!-- End ticket -->
		
</div>
</div>


<!-- End edit ticket -->
 

<script type="text/javascript">
	(function($){
    "use strict";
        $('#clear-files').on('click', function(){
            $('#file_container').html(
                "<div class='form-group'>" +
                    "<label class='col-lg-3 control-label'> <?php echo lang('attachment'); ?></label>" +
                    "<div class='col-lg-6'>" +
                    "<input type='file' name='ticketfiles[]'>" +
                    "</div></div>"
            );
        });

        $('#add-new-file').on('click', function(){
            $('#file_container').append(
                "<div class='form-group'>" +
                    "<label class='col-lg-3 control-label'> <?php echo lang('attachment'); ?></label>" +
                    "<div class='col-lg-6'>" +
                    "<input type='file' name='ticketfiles[]'>" +
                    "</div></div>"
            );
		});
	})(jQuery);  
  </script>

 


<!-- end -->