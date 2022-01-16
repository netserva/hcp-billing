<?php declare(strict_types=1);
$deptid = $_GET['dept'] ?? '';
?>

<?php
$attributes = ['class' => 'bs-example form-horizontal'];
echo form_open(base_url().'settings/add_custom_field', $attributes); ?>
  <input type="hidden" name="deptid" value="<?php echo $deptid; ?>">
    <div class="form-group">
      <label class="col-lg-3 control-label"><?php echo lang('custom_field_name'); ?> <span class="text-danger">*</span></label>
      <div class="col-lg-8">
        <input type="text" class="form-control" placeholder="<?php echo lang('eg'); ?> <?php echo lang('user_placeholder_username'); ?>" name="name" required>
      </div>
    </div>
    <div class="form-group">
      <label class="col-lg-3 control-label"><?php echo lang('field_type'); ?> <span class="text-danger">*</span> </label>
      <div class="col-lg-8">
        <select name="type" class="form-control">
          <option value="text"><?php echo lang('text_field'); ?></option>
        </select> 
      </div>
    </div>
    <button type="submit" class="btn btn-sm btn-primary"><?php echo lang('button_add_field'); ?></button>          
</form>
<div class="line line-dashed line-lg pull-in"></div> 
<?php
$fields = $this->db->where(['deptid' => $deptid])->get('fields')->result();
  if (!empty($fields)) {
      foreach ($fields as $key => $f) { ?>
<label class="label label-danger"><a class="text-white" href="<?php echo base_url(); ?>settings/edit_custom_field/<?php echo $f->id; ?>" data-toggle="ajaxModal" title = ""><?php echo $f->name; ?></a></label>
<?php }
  } ?>