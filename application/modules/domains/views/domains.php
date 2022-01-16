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

        default:
            echo lang('filter');

            break;
        }
        ?></button>
		<button class="btn btn-<?php echo config_item('theme_color'); ?> btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span>
		</button>
		<ul class="dropdown-menu">

		<li><a href="<?php echo base_url(); ?>domains?view=pending"><?php echo lang('pending'); ?></a></li>
		<li><a href="<?php echo base_url(); ?>domains?view=active"><?php echo lang('active'); ?></a></li>
		<li><a href="<?php echo base_url(); ?>domains?view=cancelled"><?php echo lang('cancelled'); ?></a></li>
		<li><a href="<?php echo base_url(); ?>domains"><?php echo lang('all_domains'); ?></a></li>

		</ul> 
		</div>

		<?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'manage_accounts')) { ?>
		<a href="<?php echo base_url(); ?>domains/upload" class="btn btn-info btn-sm pull-right" title="<?php echo lang('domain'); ?>" data-placement="bottom"><i class="fa fa-download"></i> <?php echo lang('import_whmcs'); ?></a>
		<?php } ?>	

	</div>
	<div class="box-body">

    <?php if ($this->session->flashdata('message')) { ?>
           <div class="alert alert-info" role="alert">
                <?php echo $this->session->flashdata('message'); ?>
           </div>
        <?php } ?>

	<div class="table-responsive">
		<table id="table-templates-2" class="table table-striped b-t b-light text-sm AppendDataTables">
			<thead>
				<tr>
					<th><?php echo lang('type'); ?></th>
					<th><?php echo lang('domain'); ?></th>
                    <th><?php echo lang('invoice'); ?></th>
                    <th><?php echo lang('reference'); ?></th>                    
					<th><?php echo lang('status'); ?></th>
					<th><?php echo lang('nameservers'); ?></th>
					<?php if (User::is_admin() || User::is_staff()) { ?>
					<th><?php echo lang('client'); ?></th>
					<?php } ?>
					<th class="col-options no-sort"><?php echo lang('action'); ?></th>
					</tr> </thead> <tbody>
					<?php foreach ($domains as $key => $order) {
            $type = explode(' ', $order->item_name);
            $type = $type[1] ?? $order->item_name;

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
					<td><?php echo $type; ?></td>	
					<td><?php echo $order->domain; ?></td> 
					<td><a href="<?php echo base_url(); ?>invoices/view/<?php echo $order->inv_id; ?>"><?php echo $order->reference_no; ?></a></td>
                    <td><?php echo $order->status; ?></td>                    
					<td><span class="label <?php echo $label; ?>"><?php echo ucfirst($order->order_status); ?></span></td>
					<td><?php echo $order->nameservers; ?></td>
	                <?php if (User::is_admin() || User::is_staff()) { ?>
					<td><?php echo $order->company_name; ?></td>
					<?php } ?>
                    <td>
						<a href="<?php echo base_url(); ?>domains/domain/<?php echo $order->id; ?>" class="btn btn-<?php echo config_item('theme_color'); ?> btn-sm btn-block"><?php echo lang('details'); ?></a>
					</td> 
				</tr>
				<?php
        } ?>
				
				
				
			</tbody>
			</table>
		</div>
	</div>
</div>
 