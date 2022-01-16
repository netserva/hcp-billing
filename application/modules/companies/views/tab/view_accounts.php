   <?php if ($this->session->flashdata('message')) { ?>
           <div class="alert alert-info" role="alert">
                <?php echo $this->session->flashdata('message'); ?>
           </div>
     <?php } ?>

    <div class="table-responsive">
    <table id="table-templates-2" class="table table-striped b-t b-light text-sm AppendDataTables">
			<thead>
				<tr>
                    <th><?php echo lang('package'); ?></th>
                    <th><?php echo lang('invoice'); ?></th>
                    <th><?php echo lang('status'); ?></th>
                    <th><?php echo lang('domain'); ?></th>
					<th><?php echo lang('service'); ?></th>
                    <?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'manage_accounts')) { ?>			
					<th class="col-options no-sort"><?php echo lang('action'); ?></th>
                    <?php } ?>
				    </tr>
                    </thead> <tbody>
				<?php foreach (Domain::by_client($company, "(type ='hosting')") as $order) {  ?>
				    <tr>	
                    <td><?php echo $order->item_name; ?></td>	
                    <td><?php echo $order->reference_no; ?></td>
                    <td><?php echo $order->status; ?></td>
                    <td><?php echo $order->domain; ?></td>
					<td><?php echo ucfirst($order->order_status); ?></td>
	                 <?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'manage_accounts')) { ?>
                    <td>
                      <a href="<?php echo base_url(); ?>accounts/account/<?php echo $order->id; ?>" class="btn btn-sm btn-success"><?php echo lang('view'); ?> </a>
                      <a href="<?php echo base_url(); ?>accounts/manage/<?php echo $order->id; ?>" class="btn btn-sm btn-warning"><?php echo lang('manage'); ?> </a>
					</td>
                  <?php } ?>
				</tr>
				<?php } ?>
				
				
				
			</tbody>
		</table>
      </div>
 