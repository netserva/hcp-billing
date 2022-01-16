<?php declare(strict_types=1);
$order = Order::get_order($id);
  $server = Order::get_server($order->server);
  $package = Order::get_package($order->item_parent);
  $client_cur = Client::get_by_user($this->session->userdata('user_id'))->currency;
  $disk_used = 0;
  $bw_used = 0;
  $disk_limit = 0;
  $bw_limit = 0;

  $usage = modules::run($order->server_type.'/get_usage', $order);

    if (isset($usage['disk_limit'], $usage['disk_used'])) {
        $disk_limit = $usage['disk_limit'];
        $disk_used = $usage['disk_used'];
    }

    if (isset($usage['bw_limit'], $usage['bw_used'])) {
        $bw_limit = $usage['bw_limit'];
        $bw_used = $usage['bw_used'];
    }

   switch ($order->order_status) {
        case 'pending': $label = 'label-warning';

        break;

        case 'active': $label = 'label-success';

        break;

        case 'suspended': $label = 'label-danger';

        break;

        default: $label = 'label-default';

        break;
    }

?>

<div class="box">
		<div class="box-header with-border">   
        <?php if (6 == $order->status_id && 'Yes' == $package->allow_upgrade) { ?><a href="<?php echo base_url(); ?>accounts/change?plan=<?php echo $order->item_parent; ?>&account=<?php echo $id; ?>" class="btn btn-sm btn-twitter" data-toggle="ajaxModal"><?php echo lang('upgrade_downgrade'); ?></a><?php } ?>                  
               
        <?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'manage_accounts')) { ?>
            <div class="pull-right">                   
                <?php if (6 != $order->status_id && 9 != $order->status_id) { ?>
                <a href="<?php echo base_url(); ?>accounts/activate/<?php echo $id; ?>" class="btn btn-sm btn-success" data-toggle="ajaxModal">
                <i class="fa fa-check"></i><?php echo lang('activate'); ?></a>
                <?php } else { ?>

                <a href="<?php echo base_url(); ?>accounts/manage/<?php echo $id; ?>"  
                    class="btn btn-sm btn-primary">
                <i class="fa fa-edit"></i> <?php echo lang('manage'); ?></a>

                <?php } ?>

                <a href="<?php echo base_url(); ?>accounts/cancel/<?php echo $id; ?>"  
                    class="btn btn-sm btn-warning" data-toggle="ajaxModal">
                <i class="fa fa-minus-circle"></i> <?php echo lang('cancel'); ?></a>

                <a href="<?php echo base_url(); ?>accounts/delete/<?php echo $id; ?>" 
                    class="btn btn-sm btn-danger" data-toggle="ajaxModal">
                <i class="fa fa-trash-o"></i> <?php echo lang('delete'); ?></a>
            </div>
     <?php } ?>
                            </div>
							<!-- /.box-header -->
							<div class="box-body">	    
                                
                            <?php if ($this->session->flashdata('message')) { ?>
                                <div class="alert alert-info alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <?php echo $this->session->flashdata('message'); ?>
                                </div>
                                <?php } ?>
                                
                            <div class="row">
                                <div class="col-lg-5">
                                        <table class="table table-striped">
                                            <tr>
                                               <td colspan="2"><h2><?php echo $order->item_name; ?></h2></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo lang('domain'); ?></td>
                                                <td><?php echo $order->domain; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo lang('status'); ?></td>
                                                <td><span class="label <?php echo $label; ?>"><?php echo ucfirst($order->order_status); ?></span></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo lang('order_date'); ?></td>
                                                <td><?php echo $order->date; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo lang('billed'); ?></td>
                                                <td><?php echo ucfirst($order->renewal); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo lang('next_renewal'); ?></td>
                                                <td><?php echo $order->renewal_date; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo lang('amount'); ?></td>
                                                 <td><?php if (!User::is_admin() && !User::is_staff()) {
    echo Applib::format_currency($client_cur, Applib::client_currency($client_cur, $order->total_cost));
} else {
                                                        echo Applib::format_currency(config_item('default_currency'), $order->total_cost);
                                                    }  ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo lang('storage_limit'); ?></td>
                                                <td><?php echo $disk_limit; ?>MB</td>
                                            </tr>
                                            <tr>
                                             <td><?php echo lang('bandwidth_limit'); ?></td>
                                                <td><?php echo $bw_limit; ?>MB</td>
                                            </tr>
                                            <tr>
                                                <td><?php echo lang('control_panel'); ?></td>
                                                <td><?php echo isset($server->type) ? ucfirst($server->type) : ''; ?> </td>
                                            </tr>
                                        </table>                                            
                                </div>       
                                
                                
                                
                                <?php if (is_numeric($disk_limit) && is_numeric($disk_used)) { ?>
                                    <div class="col-md-3">
                                        <div class="chart-responsive">
                                                <canvas id="storage" height="200"></canvas>
                                        </div>  
                                    </div>  

                                <?php } if (is_numeric($bw_limit) && is_numeric($bw_used)) {  ?>
                                    <div class="col-md-3">
                                        <div class="chart-responsive">
                                                <canvas id="bandwidth" height="200"></canvas>
                                        </div>  
                                    </div>

                                <?php } ?>

                            </div>
                                    
							
                                    <?php if (User::is_admin() || User::perm_allowed(User::get_id(), 'manage_accounts')) { ?>

										<?php if (9 != $order->status_id) { ?>                                       
										<a href="<?php echo base_url(); ?>accounts/suspend/<?php echo $id; ?>" class="btn btn-sm btn-google" data-toggle="ajaxModal">
										<i class="fa fa-lock"></i> <?php echo lang('suspend'); ?></a>

										<?php } if (9 == $order->status_id) { ?>
											<a href="<?php echo base_url(); ?>accounts/unsuspend/<?php echo $id; ?>" class="btn btn-sm btn-info" data-toggle="ajaxModal">
										<i class="fa fa-unlock"></i> <?php echo lang('unsuspend'); ?></a>

									<?php } } ?>

                                    <?php echo modules::run($order->server_type.'/client_options', $id); ?>                           	
								</div>
							<!-- /.box-body -->
                        </div>
                        
 
<script type="text/javascript" src="<?php echo base_url(); ?>resource/js/charts/chartjs/Chart.min.js"></script>

<?php if (is_numeric($disk_limit) && is_numeric($disk_used) && $disk_limit > 0) {
                                                        $used = ($disk_used / $disk_limit) * 100;
                                                        $available = 100 - $used; ?>

<script type="text/javascript">
    (function($){
    "use strict";
        $(document).ready(function () {     
            new Chart($("#storage"), {
            type: 'doughnut',
            data: {
            labels: ['<?php echo lang('available'); ?>', '<?php echo lang('used'); ?>'],
            datasets: [
                {
                label: "",
                backgroundColor: ["#00BCD4","#9E9E9E"],                
                data: [<?php echo $available; ?>,<?php echo $used; ?>]
                }
            ]
            },
            options: {
            title: {
                display: true,
                text: '<?php echo lang('disk_usage'); ?>'
            },
            cutoutPercentage: 80,
            animation: {
					duration: 2000,
					animateRotate: true,
					animateScale: false,
					easing: 'easeInOutCirc'
					 
				}
            }
        });

    });
})(jQuery);
</script>

<?php
                                                    } if (is_numeric($bw_limit) && is_numeric($bw_used) && $bw_limit > 0) {
                                                        $used = ($bw_used / $bw_limit) * 100;
                                                        $available = 100 - $used; ?>

<script type="text/javascript">
    (function($){
    "use strict";
        $(document).ready(function () {     
            new Chart($("#bandwidth"), {
            type: 'doughnut',
            data: {
            labels: ['<?php echo lang('available'); ?>', '<?php echo lang('used'); ?>'],
            datasets: [
                {
                label: "",
                backgroundColor: ["#8BC34A", "#FF6384"],
                data: [<?php echo $available; ?>,<?php echo $used; ?>]
                }
            ]
            },
            options: {
            title: {
                display: true,
                text: '<?php echo lang('bandwidth_usage'); ?>'
            },
            cutoutPercentage: 80,
            animation: {
					duration: 2000,
					animateRotate: true,
					animateScale: false,
					easing: 'easeInCubic'
					 
				}
            }
        });

    });
})(jQuery);
</script>

<?php
                                                    } ?>


 