<?php declare(strict_types=1);
if ($this->session->flashdata('message')) { ?>
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
					<th><?php echo lang('status'); ?></th>
					<?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'manage_accounts')) { ?>				
					<th><?php echo lang('action'); ?></th>
					<th><?php echo lang('options'); ?></th>
					<?php } ?>
				</tr> </thead> <tbody>
					<?php foreach (Domain::by_client($company, "(type ='domain' OR type ='domain_only')") as $order) {
    $type = explode(' ', $order->item_name)[1]; ?>
		 		    <tr>	
					<td><?php echo $type; ?></td>	
					<td><?php echo $order->domain; ?></td>              
					<td><?php echo ucfirst($order->order_status); ?></td>
					<?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'manage_accounts')) { ?>
                    <td>
						<?php if (6 != $order->status_id) { ?>
						<a href="<?php echo base_url(); ?>domains/activate/<?php echo $order->id; ?>" class="btn btn-sm btn-success" data-toggle="ajaxModal">
						<i class="fa fa-check"></i><?php echo lang('activate'); ?></a>
						<?php } else { ?>
						<a href="#" class="btn btn-sm btn-white">
						<i class="fa fa-check"></i><?php echo lang('activate'); ?></a>
						<?php } ?>
						<a href="<?php echo base_url(); ?>domains/cancel/<?php echo $order->id; ?>" class="btn btn-sm btn-default" data-toggle="ajaxModal">
						<i class="fa fa-minus-circle"></i> <?php echo lang('cancel'); ?></a>
						<a href="<?php echo base_url(); ?>domains/delete/<?php echo $order->id; ?>" class="btn btn-sm btn-danger" data-toggle="ajaxModal">
						<i class="fa fa-trash-o"></i> <?php echo lang('delete'); ?></a>
					</td>			
					<td>
                      <a href="<?php echo base_url(); ?>domains/domain/<?php echo $order->id; ?>" class="btn btn-sm btn-default"><?php echo lang('view'); ?> </a>
                      <a href="<?php echo base_url(); ?>domains/manage/<?php echo $order->id; ?>" class="btn btn-sm btn-default"><?php echo lang('manage'); ?> </a>
					</td>					
					<?php } ?>
				</tr>
				<?php
} ?>
				
				
				
			</tbody>
		</table>
	  </div>
