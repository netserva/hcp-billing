<div class="box">
	<div class="box-header"> 
		<div class="btn-group">
		<button class="btn btn-<?php echo config_item('theme_color'); ?> btn-sm">
		<?php
        $view = $_GET['view'] ?? null;

        switch ($view) {
        case 'pending':
            echo lang('pending');

            break;

        case 'active':
            echo lang('active');

            break;

        case 'cancelled':
            echo lang('cancelled');

            break;

        case 'suspended':
            echo lang('suspended');

            break;

        default:
            echo lang('filter');

            break;
        }
        ?></button>
		<button class="btn btn-<?php echo config_item('theme_color'); ?> btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span>
		</button>
		<ul class="dropdown-menu">

		<li><a href="<?php echo base_url(); ?>accounts?view=pending"><?php echo lang('pending'); ?></a></li>
		<li><a href="<?php echo base_url(); ?>accounts?view=active"><?php echo lang('active'); ?></a></li>
		<li><a href="<?php echo base_url(); ?>accounts?view=suspended"><?php echo lang('suspended'); ?></a></li>
		<li><a href="<?php echo base_url(); ?>accounts?view=cancelled"><?php echo lang('cancelled'); ?></a></li>
		<li><a href="<?php echo base_url(); ?>accounts"><?php echo lang('all_accounts'); ?></a></li>

		</ul>
		</div>

		<?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'manage_accounts')) { ?>

		<a href="<?php echo base_url(); ?>accounts/upload" class="btn btn-info btn-sm pull-right" title="<?php echo lang('domain'); ?>" data-placement="bottom"><i class="fa fa-download"></i> <?php echo lang('import_whmcs'); ?></a>
	
		<?php } ?>
	</div>
	<div class="box-body" id="box">
 
	<div class="table-responsive">
		<table id="table-templates-2" class="table table-striped b-t b-light text-sm AppendDataTables">
			<thead>
				<tr>
                    <th><?php echo lang('package'); ?></th> 
                    <th><?php echo lang('status'); ?></th>
                    <th><?php echo lang('domain'); ?></th>
					<th><?php echo lang('service'); ?></th>
					<?php if (User::is_admin() || User::is_staff()) { ?> 
					<th><?php echo lang('client'); ?></th>	
					<?php } ?>
					<th><?php echo lang('control_panel'); ?></th>
					<th><?php echo lang('server'); ?></th>
					<th class="col-options no-sort"><?php echo lang('options'); ?></th> 
				</tr> 
			</thead> 
			<tbody>
				<?php if ('TRUE' == config_item('demo_mode')) {
            $accounts = array_reverse($accounts);
        }

                foreach ($accounts as $key => $order) {
                    switch ($order->order_status) {
                        case 'pending': $label = 'label-warning';

                        break;

                        case 'active': $label = 'label-success';

                        break;

                        case 'suspended': $label = 'label-danger';

                        break;

                        default: $label = 'label-default';

                        break;
                            } ?>
				    <tr>	
                    <td><?php echo $order->item_name; ?></td>	
                    <td><?php echo $order->status; ?></td>
                    <td><?php echo $order->domain; ?></td>
					<td><span class="label <?php echo $label; ?>"><?php echo ucfirst($order->order_status); ?></span></td>
					<?php if (User::is_admin() || User::is_staff()) { ?>			 			
                    <td><?php echo $order->company_name; ?></td>
					<?php } ?>
					<td><?php echo ucfirst($order->type); ?></td>    
					<td><?php echo $order->server_name; ?></td>                
					<td><a href="<?php echo base_url(); ?>accounts/account/<?php echo $order->id; ?>" class="btn btn-<?php echo config_item('theme_color'); ?> btn-sm btn-block"><?php echo lang('options'); ?></a></td> 				
				</tr>
				<?php
                } ?> 
				</tbody>
			</table>
		</div>
	</div>
</div>