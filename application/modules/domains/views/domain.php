<?php declare(strict_types=1);
$order = Order::get_domain_order($id); ?> 
<div class="box">
	<div class="box-body">	
	<?php if ($this->session->flashdata('message')) { ?>
           <div class="alert alert-info alert-dismissible">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $this->session->flashdata('message'); ?>
           </div>
		<?php } ?>
						
				<div class="box box-solid">
					<div class="box-header with-border">
						<h2 class="text-muted"><?php echo $order->domain; ?></h2>	 
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-lg-5">
								<table class="table table-padded table-bordered">
									<tr><td><label><?php echo lang('order_date'); ?></label></td><td><?php echo substr($order->date, 0, 10); ?></td></tr>
									<tr><td><label><?php echo lang('renewal'); ?></label></td><td><?php echo $order->renewal_date; ?></td></tr>
									<?php if ('' != $order->registrar) { ?>
									<tr><td><label><?php echo lang('registrar'); ?></label></td><td><?php echo ucfirst($order->registrar); ?></td></tr>										
									<?php } ?>
									<tr><td><label><?php echo lang('status'); ?></label></td><td><span class="label bg-info"><?php echo ucfirst($order->domain_status); ?></span></td></tr>
									<?php if ('' != $order->authcode) { ?>
									<tr><td><label><?php echo lang('authcode'); ?></label></td><td><?php echo $order->authcode; ?></td></tr>										
									<?php } ?>
								</table>

								<h3><?php echo lang('nameservers'); ?></h3>
								<ul class="list-group alt">
										<?php if ('' != $order->nameservers) {
    $nameservers = explode(',', $order->nameservers);
} else {
                                            $nameservers = [];
                                            if ('' != config_item('nameserver_one')) {
                                                $nameservers[] = config_item('nameserver_one');
                                            }
                                            if ('' != config_item('nameserver_two')) {
                                                $nameservers[] = config_item('nameserver_two');
                                            }
                                            if ('' != config_item('nameserver_three')) {
                                                $nameservers[] = config_item('nameserver_three');
                                            }
                                            if ('' != config_item('nameserver_four')) {
                                                $nameservers[] = config_item('nameserver_four');
                                            }
                                            if ('' != config_item('nameserver_five')) {
                                                $nameservers[] = config_item('nameserver_five');
                                            }
                                        }

                                            foreach ($nameservers as $server => $value) { ?>
												<li class="list-group-item text-muted"><?php echo $value; ?></li>
									<?php } ?>
								</ul>

								</div>
							
									<div class="col-lg-2">
										<?php if ($order->status_id > 5 && '' != $order->registrar && (User::is_admin() || User::perm_allowed(User::get_id(), 'manage_accounts'))) {  ?>
													<a href="<?php echo base_url().'domains/proccess/'.$order->registrar; ?>/register_domain/<?php echo $order->id; ?>" class="btn btn-sm btn-success btn-block">
													<?php echo lang('register'); ?></a>

													<a href="<?php echo base_url().'domains/proccess/'.$order->registrar; ?>/transfer_domain/<?php echo $order->id; ?>" class="btn btn-sm btn-twitter btn-block">
													<?php echo lang('transfer'); ?></a>

													<a href="<?php echo base_url().'domains/proccess/'.$order->registrar; ?>/renew_domain/<?php echo $order->id; ?>" class="btn btn-sm btn-vk btn-block">
													<?php echo lang('renew'); ?></a>

											<?php if ('namecheap' != $order->registrar) { ?>

													<a href="<?php echo base_url(); ?>domains/suspend/<?php echo $order->id; ?>" class="btn btn-sm btn-linkedin btn-block" data-toggle="ajaxModal">
													<?php echo lang('suspend'); ?></a>

													<a href="<?php echo base_url().'domains/proccess/'.$order->registrar; ?>/unsuspend_domain/<?php echo $order->id; ?>" class="btn btn-sm btn-instagram btn-block">
													<?php echo lang('unsuspend'); ?></a>	

											<?php } else { ?>
												<a href="<?php echo base_url().'domains/proccess/'.$order->registrar; ?>/reactivate_domain/<?php echo $order->id; ?>" class="btn btn-sm btn-instagram btn-block">
													<?php echo lang('reactivate'); ?></a>	

											<?php }} if (isset($order->registrar)) { ?>
													<a href="<?php echo base_url(); ?>domains/manage_nameservers/<?php echo $order->id; ?>" class="btn btn-sm btn-primary btn-block" data-toggle="ajaxModal">
													<?php echo lang('nameservers'); ?></a>
											<?php } ?>
									</div>
									<div class="col-lg-4">
										<?php echo ('' != $order->notes) ? $order->notes : ''; ?>

									</div>
							
							</div>
						</div>
				
					<div class="box-footer">	
						<?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'manage_accounts')) { ?>
							<?php if (6 != $order->status_id) { ?>
							<a href="<?php echo base_url(); ?>domains/activate/<?php echo $order->id; ?>" class="btn btn-sm btn-success" data-toggle="ajaxModal">
							<i class="fa fa-check"></i><?php echo lang('activate'); ?></a>
							<?php } else { ?>
							<a href="#" class="btn btn-xs btn-white">
							<i class="fa fa-check"></i><?php echo lang('activate'); ?></a>

							<a href="<?php echo base_url(); ?>domains/manage/<?php echo $id; ?>"  
								class="btn btn-sm btn-primary">
							<i class="fa fa-edit"></i> <?php echo lang('manage'); ?></a>

							<?php } ?>
							<a href="<?php echo base_url(); ?>domains/cancel/<?php echo $order->id; ?>" class="btn btn-sm btn-default" data-toggle="ajaxModal">
							<i class="fa fa-minus-circle"></i> <?php echo lang('cancel'); ?></a>
							<a href="<?php echo base_url(); ?>domains/delete/<?php echo $order->id; ?>" class="btn btn-sm btn-danger" data-toggle="ajaxModal">
							<i class="fa fa-trash-o"></i> <?php echo lang('delete'); ?></a>
						<?php } ?>
					</div>
				</div>
			
	</div>
</div>