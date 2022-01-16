<?php declare(strict_types=1);
$attributes = ['class' => 'bs-example form-horizontal'];
          echo form_open(base_url().'settings/add_custom_field', $attributes); ?>

          <div class="form-group">
				<label class="col-lg-2 control-label"><?php echo lang('department'); ?> <span class="text-danger">*</span> </label>
				<div class="col-lg-6">
					<div class="m-b"> 
					<select name="targetdept" class="form-control" required >
					<?php $departments = $this->db->where(['deptid >' => '0'])->get('departments')->result();
                    if (!empty($departments)) {
                        foreach ($departments as $d) { ?>
                                            <option value="<?php echo $d->deptid; ?>"><?php echo ucfirst($d->deptname); ?></option>
					<?php }
                    } ?>
					</select> 
					</div> 
				</div>
			</div>
<button type="submit" class="btn btn-sm btn-info"><?php echo lang('select_department'); ?></button>

</form>