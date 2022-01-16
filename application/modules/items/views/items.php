 <div class="box">
	<div class="box-header"> 			
			<span class="h3">&nbsp;  
			<?php
                $view = $_GET['view'] ?? null;
                $path = '';

                switch ($view) {
                case 'domains':
                    $path = 'domain';
                    echo lang('domains');

                    break;

                case 'hosting':
                    $path = 'hosting';
                    echo lang('hosting');

                    break;

                case 'service':
                    $path = 'service';
                    echo lang('service');

                    break;
                }

                if (!isset($_GET['view'])) {?> 
					<a class="btn btn-default btn-sm btn-responsive" href="<?php echo base_url(); ?>items"><?php echo lang('all_items'); ?></a>
					<a class="btn btn-twitter btn-sm btn-responsive" href="<?php echo base_url(); ?>items?view=domains"><?php echo lang('domains'); ?></a>
					<a class="btn btn-success btn-sm btn-responsive" href="<?php echo base_url(); ?>items?view=hosting"><?php echo lang('hosting'); ?></a>
					<a class="btn btn-warning btn-sm btn-responsive" href="<?php echo base_url(); ?>items?view=service"><?php echo lang('service'); ?></a>
				<?php }	?>
			</span>
   		<?php if (isset($_GET['view'])) {?> 
			<a href="<?php echo base_url(); ?>items/add_<?php echo $path; ?>" class="btn btn-sm btn-<?php echo config_item('theme_color'); ?> pull-right" data-toggle="ajaxModal"><i class="fa fa-plus"></i> <?php echo lang('new_item'); ?></a>
		<?php }	?>
	</div>
	 
	<div class="box-body">
	<div class="table-responsive">
		<table id="table-templates-2" class="table table-striped b-t b-light text-sm AppendDataTables">
			<thead>
				<tr>
					<th><?php echo lang('category'); ?></th>					
					<th><?php echo lang('item_name'); ?></th>					
					<?php if ((isset($_GET['view']) && 'hosting' == $_GET['view']) || !isset($_GET['view'])) { ?>
					<th><?php echo lang('server'); ?></th>
					<th><?php echo lang('monthly'); ?></th>
					<th><?php echo lang('quarterly'); ?></th>
					<th><?php echo lang('semiannually'); ?></th>
					<th><?php echo lang('annually'); ?></th>
					<?php }
                    if ((isset($_GET['view']) && 'domains' == $_GET['view']) || !isset($_GET['view'])) { ?>
					<th><?php echo lang('registration'); ?></th>
					<th><?php echo lang('transfer'); ?></th>
					<th><?php echo lang('renewal'); ?></th>	
					<?php }
                    if ((isset($_GET['view']) && 'service' == $_GET['view']) || !isset($_GET['view'])) { ?>
					<th><?php echo lang('server'); ?></th>
					<th><?php echo lang('unit_price'); ?> </th> 
					<?php } ?>
					<th><?php echo lang('order'); ?> </th>
					<th class="col-options no-sort"><?php echo lang('options'); ?></th>
				</tr> </thead> <tbody>
				<?php foreach ($invoice_items as $key => $item) { ?>
				<tr>
				<td><span class="label label-default"><?php echo ('' == $item->cat_name) ? 'None' : $item->cat_name; ?></span></td>
				<td><?php echo $item->item_name; ?></td>								
				<?php if ((isset($_GET['view']) && 'hosting' == $_GET['view']) || !isset($_GET['view'])) { ?>
				<td><?php echo ('' != $item->server) ? '<span class="label label-default">'.$item->server.'</span>' : ''; ?></td>
				<td><?php echo Applib::format_currency(config_item('default_currency'), $item->monthly); ?></td>
				<td><?php echo Applib::format_currency(config_item('default_currency'), $item->quarterly); ?></td>
				<td><?php echo Applib::format_currency(config_item('default_currency'), $item->semi_annually); ?></td>
				<td><?php echo Applib::format_currency(config_item('default_currency'), $item->annually); ?></td>
				<?php }
                if ((isset($_GET['view']) && 'domains' == $_GET['view']) || !isset($_GET['view'])) { ?>
				<td><?php echo Applib::format_currency(config_item('default_currency'), $item->registration); ?></td>
				<td><?php echo Applib::format_currency(config_item('default_currency'), $item->transfer); ?></td>
				<td><?php echo Applib::format_currency(config_item('default_currency'), $item->renewal); ?></td>
				<?php }
                if ((isset($_GET['view']) && 'service' == $_GET['view']) || !isset($_GET['view'])) { ?>
				<td><?php echo ('' != $item->server) ? '<span class="label label-default">'.$item->server.'</span>' : ''; ?></td>
				<td><?php echo Applib::format_currency(config_item('default_currency'), $item->unit_cost); ?></td>	
				<?php } ?> 
				<td><?php echo $item->order_by; ?></td>               
				<td><a href="<?php echo base_url(); ?>items/edit_<?php echo $path; ?>/<?php echo $item->item_id; ?>" class="btn btn-primary btn-xs" data-toggle="ajaxModal">
					<i class="fa fa-edit"></i> <?php echo lang('edit'); ?></a>
					<?php if ('hosting' == $path || 'service' == $path) { ?>
					<a href="<?php echo base_url(); ?>items/package/<?php echo $item->item_id; ?>" class="btn btn-warning btn-xs">
					<i class="fa fa-edit"></i> <?php echo lang('package'); ?></a>
					<?php } if ('domains' != $_GET['view']) { ?>
					<a href="<?php echo base_url(); ?>items/item_links/<?php echo $item->item_id; ?>" class="btn btn-info btn-xs" data-toggle="ajaxModal">
					<i class="fa fa-link"></i> <?php echo lang('links'); ?></a> 
					<?php if ('TRUE' == config_item('affiliates')) { ?>
					<a href="<?php echo base_url(); ?>items/affiliates/<?php echo $item->item_id; ?>" class="btn btn-info btn-xs" data-toggle="ajaxModal">
					<i class="fa fa-link"></i> <?php echo lang('affiliates'); ?></a> <?php }} ?>
					<a href="<?php echo base_url(); ?>items/delete_<?php echo $path; ?>/<?php echo $item->item_id; ?>" class="btn btn-danger btn-xs" data-toggle="ajaxModal">
					<i class="fa fa-trash-o"></i> <?php echo lang('delete'); ?></a>
				</td>
				</tr>
				<?php } ?>
				
				
				
			</tbody>
		</table>
	</div>


</div>
<!-- End Invoice Items -->
