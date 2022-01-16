<div id="order_list">

	<?php if ($this->session->flashdata('message')) { ?>
           <div class="alert alert-info" role="alert">
                <?php echo $this->session->flashdata('message'); ?>
           </div>
        <?php } ?>

		
	<div class="box">
	<div class="box-header"> 
	<div class="btn-group">
		<button class="btn btn-<?php echo config_item('theme_color'); ?> btn-sm">
		<?php
        $view = $_GET['view'] ?? null;

        switch ($view) {
        case 'unpaid':
            echo lang('unpaid');

            break;

        case 'paid':
            echo lang('paid');

            break;

        default:
            echo lang('filter');

            break;
        }
        ?></button>
		<button class="btn btn-<?php echo config_item('theme_color'); ?> btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span>
		</button>
		<ul class="dropdown-menu">

		<li><a href="<?php echo base_url(); ?>orders?view=unpaid"><?php echo lang('unpaid'); ?></a></li>
		<li><a href="<?php echo base_url(); ?>orders?view=paid"><?php echo lang('paid'); ?></a></li>
		<li><a href="<?php echo base_url(); ?>orders"><?php echo lang('all_orders'); ?></a></li>

		</ul>
		</div>

		<?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'create_orders')) { ?>
			<a href="<?php echo base_url(); ?>orders/select_client" class="btn btn-sm btn-success pull-right"><i class="fa fa-plus"></i> <?php echo lang('new_order'); ?></a>
		</div>
		<?php } ?>
	
	<div class="box-body">
	<div class="table-responsive">
		<table class="table table-striped b-t b-light AppendDataTables">
			<thead>
				<tr>
					<th><?php echo lang('order_id'); ?></th>
					<th><?php echo lang('date'); ?></th>
					<th><?php echo lang('invoice'); ?></th> 
					<th><?php echo lang('status'); ?></th>
					<th><?php echo lang('invoice_options'); ?></th> 										
					<th><?php echo lang('client'); ?></th>	
					<?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'manage_orders')) { ?>				
					<th class="col-options no-sort w_200"><?php echo lang('action'); ?></th>
					<?php } ?>
				</tr> </thead> <tbody>
				<?php foreach ($orders as $key => $order) {
            $status = Invoice::payment_status($order->inv_id);

            switch ($status) {
                          case 'fully_paid': $label2 = 'success';

break;

                          case 'partially_paid': $label2 = 'warning';

break;

                          case 'not_paid': $label2 = 'danger';

break;

                          case 'cancelled': $label2 = 'primary';

break;
                      } ?>
				<tr>				
					<td><?php echo $order->order_id; ?></td>
					<td><?php echo $order->date; ?></td>					
					<td><?php echo $order->reference_no; ?></td>
					<td> <span class="label label-<?php echo $label2; ?>"><?php echo lang($status); ?></span></td>
					<td>
					<a class="btn btn-xs btn-primary" href="<?php echo base_url(); ?>invoices/view/<?php echo $order->inv_id; ?>" 
                           data-toggle="tooltip" data-original-title="<?php echo lang('view'); ?>" data-placement="top">
                           <i class="fa fa-eye"></i>
                           </a>  

					<?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'email_invoices')) { ?>
							<a class="btn btn-xs btn-success" href="<?php echo base_url(); ?>invoices/send_invoice/<?php echo $order->inv_id; ?>" 
							data-toggle="ajaxModal"><span data-toggle="tooltip" data-original-title="<?php echo lang('email_invoice'); ?>" data-placement="top">
							<i class="fa fa-envelope"></i></span></a>
					<?php } ?>


					<?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'send_email_reminders')) { ?>                   
						<a href="<?php echo base_url(); ?>invoices/remind/<?php echo $order->inv_id; ?>" data-toggle="ajaxModal" 
						class="btn btn-xs btn-vk" data-original-title="<?php echo lang('send_reminder'); ?>">
						<span data-toggle="tooltip" data-original-title="<?php echo lang('send_reminder'); ?>" data-placement="top">
						<i class="fa fa-bell"></i></span> </a>
					<?php } ?>
						
						<a class="btn btn-xs btn-linkedin" href="<?php echo base_url(); ?>fopdf/invoice/<?php echo $order->inv_id; ?>" 
						data-toggle="tooltip" data-original-title="<?php echo lang('pdf'); ?>" data-placement="top">
						<i class="fa fa-file-pdf-o"></i></a>
				</td> 					
					<td><?php echo $order->company_name; ?></td>	
					<?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'manage_orders')) { ?>				
					<td>
				 			 
					<?php if (6 != $order->status_id && 2 != $order->status_id) { ?>
							<a href="<?php echo base_url(); ?>orders/activate/<?php echo $order->order_id; ?>" class="btn btn-xs btn-success" data-toggle="ajaxModal">
							<i class="fa fa-check"></i><?php echo lang('activate'); ?></a>
							<?php }?>
							<?php if (6 == $order->status_id) { ?>
							<a href="<?php echo base_url(); ?>orders/cancel/<?php echo $order->order_id; ?>" class="btn btn-xs btn-default" data-toggle="ajaxModal">
							<i class="fa fa-minus-circle"></i> <?php echo lang('cancel'); ?></a>
							<?php } ?>
							<a href="<?php echo base_url(); ?>orders/delete/<?php echo $order->order_id; ?>" class="btn btn-xs btn-default" data-toggle="ajaxModal">
							<i class="fa fa-trash-o"></i> <?php echo lang('delete'); ?></a> 
					</td>
					<?php } ?>
				</tr>
				<?php
        } ?>
				
				
				
			</tbody>
		</table>
	</div>
	</div>
 </div>
</div>
 
 