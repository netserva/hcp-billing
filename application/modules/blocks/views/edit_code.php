<?php declare(strict_types=1);
$block = $block[0]; ?>
<div class="box"> 
    <div class="box-body"> 
    <div class="container"> 
		<?php
             $attributes = ['class' => 'bs-example form-horizontal'];
          echo form_open(base_url().'blocks/edit', $attributes); ?>   

		  		<input type="hidden" name="id" value="<?php echo $block->id; ?>">

          		<div class="form-group">
				<label class="control-label"><?php echo lang('name'); ?> <span class="text-danger">*</span></label>
		 			<input type="text" class="form-control" name="name" value="<?php echo $block->name; ?>">
				</div> 

				<div class="form-group">
				<label class="control-label"><?php echo lang('type'); ?> <span class="text-danger">*</span></label>
					<select type="text" class="form-control" name="format">
						<option value="js" class="form-control" <?php echo ('js' == $block->format) ? 'selected' : ''; ?>>HTML & Javascript - <?php echo lang('including_tags'); ?></option>
						<option value="php" class="form-control" <?php echo ('php' == $block->format) ? 'selected' : ''; ?>>PHP - <?php echo lang('excluding_tags'); ?></option>	
					</select>
				</div>

				<div class="form-group">
				<label class="control-label"><?php echo lang('content'); ?> <span class="text-danger">*</span></label>
						<textarea class="form-control" name="content" rows="10" cols="50"><?php echo $block->code; ?></textarea>
				</div>
				 
		<div class="box-footer"><button type="submit" class="btn btn-<?php echo config_item('theme_color'); ?> pull-right"><?php echo lang('update'); ?></button>		
    </div>
    </form>
    </div>
  </div>
</div>