 <div class="box">
	<div class="box-header"> 			
			<span class="h3">&nbsp;  
			<?php echo lang('addons'); ?>
			</span>
   
			<a href="<?php echo base_url(); ?>addons/add" class="btn btn-sm btn-<?php echo config_item('theme_color'); ?> pull-right" data-toggle="ajaxModal"><i class="fa fa-plus"></i> <?php echo lang('new_addon'); ?></a>
 
	</div>
	 
	<div class="box-body">
	<div class="table-responsive">
		<table id="table-templates-2" class="table table-striped b-t b-light text-sm AppendDataTables">
			<thead>
				<tr>	
					<th><?php echo lang('item_name'); ?></th>					 
					<th><?php echo lang('add_to'); ?></th>
					<th><?php echo lang('require_domain'); ?></th>
					<th><?php echo lang('monthly'); ?></th>
					<th><?php echo lang('quarterly'); ?></th>
					<th><?php echo lang('semiannually'); ?></th>
					<th><?php echo lang('annually'); ?></th> 
					<th><?php echo lang('biennially'); ?></th>  
					<th><?php echo lang('triennially'); ?></th> 
					<th class="col-options no-sort"><?php echo lang('options'); ?></th>
				</tr> </thead> <tbody>
				<?php foreach ($addons as $key => $item) { ?>
				<tr> 
				<td><?php echo $item->item_name; ?></td>
				<td>
				
				<?php $packages = unserialize($item->apply_to);
                    if (is_array($packages)) {
                        foreach ($packages as $package) {
                            if (isset(Item::view_item($package)->item_name)) {
                                echo '<span class="label label-default">'.Item::view_item($package)->item_name.'</span>';
                            }
                        }
                    }
                ?>

				</td>
				<td><?php echo $item->require_domain; ?></td>
				<td><?php echo Applib::format_currency(config_item('default_currency'), $item->monthly); ?></td>
				<td><?php echo Applib::format_currency(config_item('default_currency'), $item->quarterly); ?></td>
				<td><?php echo Applib::format_currency(config_item('default_currency'), $item->semi_annually); ?></td>
				<td><?php echo Applib::format_currency(config_item('default_currency'), $item->annually); ?></td>
				<td><?php echo Applib::format_currency(config_item('default_currency'), $item->biennially); ?></td>  
				<td><?php echo Applib::format_currency(config_item('default_currency'), $item->triennially); ?></td> 
				<td><a href="<?php echo base_url(); ?>items/edit_addon/<?php echo $item->item_id; ?>" class="btn btn-primary btn-xs" data-toggle="ajaxModal">
					<i class="fa fa-edit"></i> <?php echo lang('edit'); ?></a>
					<a href="<?php echo base_url(); ?>items/package/<?php echo $item->item_id; ?>" class="btn btn-warning btn-xs">
					<i class="fa fa-edit"></i> <?php echo lang('package'); ?></a>
					<a href="<?php echo base_url(); ?>items/delete_addon/<?php echo $item->item_id; ?>" class="btn btn-danger btn-xs" data-toggle="ajaxModal">
					<i class="fa fa-trash-o"></i> <?php echo lang('delete'); ?></a>
				</td>
				</tr>
				<?php } ?>							
				
			</tbody>
		</table>
	</div>


</div>
<!-- End Invoice Items -->
