	 <?php $this->lang->load('calendar', config_item('language')); ?>
				<div class="box-body">

					<div class="row status_blocks">
							<div class="col-sm-6 col-md-3">
								<div class="info-box bg-teal-gradient">
								<a class="clear" href="<?php echo base_url(); ?>domains?view=pending">
										<span class="info-box-icon"><i class="fa fa-globe fa-1x text-white"></i></span>
										<span class="status_count"><?php echo Order::pending_domains(); ?></span><br>									 
										<span class="label"><?php echo lang('domains_pending'); ?> </span>										 					
									</a>
								</div>
							</div>



							<div class="col-sm-6 col-md-3">
								<div class="info-box bg-green-gradient">
									<a class="clear" href="<?php echo base_url(); ?>accounts?view=pending">
										<span class="info-box-icon"><i class="fa fa-server fa-1x text-white"></i></span>	
										<span class="status_count"><?php echo Order::pending_accounts(); ?></span><br>									 
										<span class="label"><?php echo lang('hosting_pending'); ?> </span>
									</a>					
								</div>
							</div>
								

							
							<div class="col-sm-6 col-md-3">
								<div class="info-box bg-light-blue-gradient">
									<a class="clear" href="<?php echo base_url(); ?>invoices?view=unpaid">
									<span class="info-box-icon"><i class="fa fa-shopping-basket fa-1x"></i></span>										 
									<span class="status_count"><?php echo Order::unpaid_orders(); ?></span><br>									 
									<span class="label"><?php echo lang('unpaid_invoices'); ?> </span>							
									</a>						
								</div>
							</div>



							<div class="col-sm-6 col-md-3">
								<div class="info-box bg-purple-gradient">
									<a class="clear" href="<?php echo base_url(); ?>tickets">
									<span class="info-box-icon"><i class="fa fa-support fa-1x text-white"></i></span>
									<span class="status_count"><?php echo App::counter('tickets', ['status !=' => 'closed']); ?></span><br>									 
									<span class="label"><?php echo lang('active_tickets'); ?> </span>								
									</a>
								</div>
							</div>
					
				</div>

 
				<div class="row">

						<div class="col-md-4">

							<?php
                            $total_receipts = $sums['paid'];
                            $invoices_cost = Invoice::all_invoice_amount();
                            $outstanding = $sums['due'];
                            if ($outstanding < 0) {
                                $outstanding = 0;
                            }
                            $perc_paid = $perc_outstanding = 0;

                            if ($invoices_cost > 0) {
                                $perc_paid = ($total_receipts / $invoices_cost) * 100;
                                $perc_paid = ($perc_paid > 100) ? '100' : round($perc_paid, 1);
                                $perc_outstanding = round(100 - $perc_paid, 1);
                            }
                            ?>

								<section class="box box-default revenue">

								<header class="box-header"><?php echo lang('received_amount'); ?></header>

								<div class="panel-body text-center"> 
 

									<div class="chart-responsive">
											<canvas id="pieChart" height="160"></canvas>
										</div> 
									</div>
														
									<div class="box-footer">
										<div class="l_50">
										<i class="fa fa-circle chart_unpaid"></i>
										<?php echo lang('outstanding'); ?> - <?php echo Applib::format_currency(config_item('default_currency'), Invoice::outstanding()); ?>
									 	</div>
										 <div class="r_50">					
										<i class="fa fa-circle chart_paid"></i>
										<?php echo lang('paid'); ?> - <?php echo Applib::format_currency(config_item('default_currency'), $total_receipts); ?>
										</div>
										</div>
							 
							</section>

							<div class="row dash_p_14" id="month_payments">
							
								<div class="col-sm-6 padder-v b-r bg-olive b-light">
									<?php if (User::is_admin()) { ?> <a class="clear" href="<?php echo base_url(); ?>reports"> <?php } ?>
									
											<small class=" text-uc"><?php echo lang('last_month'); ?>  </small>
											<span class="h4 block m-t-xs">
											<?php echo Applib::format_currency(config_item('default_currency'), Report::month_amount(date('Y'), date('m') - 1)); ?>
											</span>
											<?php if (User::is_admin()) { ?> </a> <?php } ?>
									</div>

									<div class="col-sm-6 padder-v b-r bg-light-blue b-light">
										<?php if (User::is_admin()) { ?> <a class="clear" href="<?php echo base_url(); ?>reports"> <?php } ?>
										
											<small class="text-uc"><?php echo lang('this_month'); ?></small>
											<span class="h4 block m-t-xs">
											<?php echo Applib::format_currency(config_item('default_currency'), Report::month_amount(date('Y'), date('m'))); ?>
											 </span>  
											 <?php if (User::is_admin()) { ?> </a> <?php } ?>
										</div>
									</div>
						</div>
			 


						<div class="col-md-8 ">

							<?php
                            $chart_year = ($this->session->userdata('chart_year')) ? $this->session->userdata('chart_year') : date('Y');
                            ?>

						<div class="box box-blue">
							<div class="box-header"> 
							<div id="legend" class="line-legend"></div>			
									<div class="btn-group">
										<button class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown"><?php echo (isset($_GET['setyear'])) ? $_GET['setyear'] : date('Y'); ?> <span class="caret"></span></button>
										<ul class="dropdown-menu">
										<?php
                                        $max = date('Y');
                                        $min = $max - 3;
                                        foreach (range($min, $max) as $year) { ?>
													<?php if (isset($_GET['setyear'])) { ?>														
													<?php } ?>
													<li><a href="<?php echo base_url(); ?>dashboard?setyear=<?php echo $year; ?>"><?php echo $year; ?></a></li>
											<?php }
                                            ?>

										</ul>
									</div>
								 
								<?php echo lang('invoices_payments'); ?>

								
							</div>
							<div class="box-body border-radius-none">
							<div class="chart h_308" id="line-chart"></div>
							
							</div>
						</div>

					</div>
							
					</div>


					<div class="row">

							<div class="col-lg-4 fadeInLeft animated">
								<section class="box box-dark">
								<header class="box-header"><?php echo lang('recently_paid_invoices'); ?></header>
								<div class="box-body">

								<section class="slim-scroll" data-height="360" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">

									<div class="list-group bg-white small">

										<?php foreach (Payment::recent_paid() as $key => $i) {
                                                $currency = config_item('default_currency');
                                                $badge = 'dark';
                                                if ('1' == $i->payment_method) {
                                                    $badge = 'success';
                                                } elseif ('2' == $i->payment_method) {
                                                    $badge = 'danger';
                                                }

                                                $amount = '';
                                                if ($currency != config_item('default_currency')) {
                                                    $amount = Applib::format_currency(config_item('default_currency'), Applib::convert_currency($currency, $i->amount));
                                                } else {
                                                    $amount = Applib::format_currency(config_item('default_currency'), $i->amount);
                                                } ?>
										<a href="<?php echo base_url(); ?>invoices/view/<?php echo $i->invoice; ?>" class="list-group-item recent_bl">
											<?php echo Invoice::view_by_id($i->invoice)->reference_no; ?>
												- <small class="text-muted">
												<?php echo $amount; ?>
											<span class="badge bg-<?php echo $badge; ?> pull-right">
											<?php echo Payment::method_name_by_id($i->payment_method); ?></span></small>
										</a>
										<?php
                                            } ?>
									</div>
									</section>
								</div>
								<div class="box-footer">
									<small><?php echo lang('total_receipts'); ?>: <strong>
									<?php echo Applib::format_currency(config_item('default_currency'), Report::total_paid()); ?>
									</strong></small>
								</div>
							</section>
				</div>
 

				<div class="col-md-4 radius_2">
						<div class="row">
						 
							<div class="col-lg-12">
								<section class="box box-default">
								<header class="box-header"><?php echo lang('recent_tickets'); ?></header>
								<div class="box-body">
									<section class="comment-list block">
										<section class="slim-scroll" data-height="400" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">
											<?php
                                            foreach (Ticket::get_tickets() as $key => $ticket) {
                                                $badge = 'dark';
                                                if ('open' == $ticket->status) {
                                                    $badge = 'danger';
                                                } elseif ('closed' == $ticket->status) {
                                                    $badge = 'success';
                                                } ?>
											<article id="comment-id-1" class="comment-item small">
												<?php if (null != $ticket->reporter) { ?>
												<div class="pull-left thumb-sm avatar">
											<img src="<?php echo User::avatar_url($ticket->reporter); ?>" class="img-circle">
												</div>
												<?php } else {
                                                    echo 'NULL';
                                                } ?>
												<section class="comment-body m-b-lg">
													<header class="b-b">
														<strong>
														<?php
                                                        echo (null != $ticket->reporter)
                                                            ? User::displayName($ticket->reporter)
                                                            : 'NULL'; ?>
														</strong>
														<span class="text-muted text-xs">
											<?php echo Applib::time_elapsed_string(strtotime($ticket->created)); ?>
														</span>
													</header>
													<div>
														<a href="<?php echo base_url(); ?>tickets/view/<?php echo $ticket->id; ?>">
															<?php echo $ticket->subject; ?>
															<small class="text-muted">
															<?php echo lang('priority'); ?>: <?php echo $ticket->priority; ?>
															<span class="badge bg-<?php echo $badge; ?>"><?php echo lang($ticket->status); ?>
															</span>
															</small>
														</a>
													</div>
												</section>
											</article>
											<?php
                                            } ?>
										</section>
									</section>
								</div>
							</section>
						</div>
					</div>
			</div>

			<div class="col-md-4">
					<section class="box box-default"> 
					<div class="box-body">
					<section class="slim-scroll" data-height="440" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">				 
							<div class="list-group bg-white">
                                    <?php
                                    $orders = Order::all_orders();
                                    $orders = array_reverse($orders);
                                    foreach ($orders as $key => $order) {
                                        $earlier = new DateTime(date('Y-m-d'));
                                        $later = new DateTime($order->renewal_date);
                                        $remaining = $later->diff($earlier)->format('%a');
                                        if ($remaining < 365) { ?>
                                        <span href="#" class="list-group-item">
                                        <?php echo $order->domain; ?> <span class="label label-default"> <small><?php echo ('hosting' == $order->type) ? $order->item_name : 'Domain'; ?></small> </span> <span class="pull-right"><span class="label <?php echo ($remaining < 10) ? 'label-warning' : 'label-success'; ?>"><?php echo $remaining; ?></span> <?php echo strtolower(lang('days')); ?></span> 
                                    </span>
                                    <?php }
                                    } ?>
                                </div>
							</section>
						</div>
					</section>
				</div>
			</div>
		</div>		
	 
 
 
<script src="<?php echo base_url(); ?>resource/js/charts/raphael/raphael.min.js"></script>
<script src="<?php echo base_url(); ?>resource/js/charts/morris/morris.min.js"></script>
<script src="<?php echo base_url(); ?>resource/js/charts/chartjs/Chart.min.js"></script>

<script type="text/javascript">

(function($){
"use strict";
	<?php
    $cur = App::currencies(config_item('default_currency'));
    $labels = ucfirst(lang('invoices_payments'));
    $preunits = '';
    $labels = lang('amount'); $preunits = $cur->symbol; ?>;
	var LineChart = Morris.Area({
			element: 'line-chart',
			data: [
	<?php
    for ($i = 1; $i <= 12; ++$i) {
        print_r('{
			"Paid": '.Applib::cal_amount('payments', $chart_year, sprintf('%02d', $i)).',
			"Invoiced": '.Applib::cal_amount('invoiced', $chart_year, sprintf('%02d', $i)).',
			"period": "'.$chart_year.'-'.sprintf('%02d', $i).'"
		},');
    }
    ?>
	],
	xkey: 'period',
	ykeys: ['Paid', 'Invoiced'],
	labels: ['<?php echo lang('paid'); ?>', '<?php echo lang('invoiced'); ?>'],
	hoverCallback: function (index, options, content) {
	return(content);
	},
	hideHover: 'auto',
	lineColors: ["#3e95cd","#c45850"],
	lineWidth  : 1,
	fillOpacity: 0.2,
	behaveLikeLine: true,
	grid: false,
    resize: true,
	preUnits: ['<?php echo $preunits; ?>'],
	xLabelFormat: function (x) {
	var IndexToMonth = ["<?php echo lang('cal_jan'); ?>", "<?php echo lang('cal_feb'); ?>", "<?php echo lang('cal_mar'); ?>", "<?php echo lang('cal_apr'); ?>", "<?php echo lang('cal_may'); ?>", "<?php echo lang('cal_jun'); ?>", "<?php echo lang('cal_jul'); ?>", "<?php echo lang('cal_aug'); ?>", "<?php echo lang('cal_sep'); ?>", "<?php echo lang('cal_oct'); ?>", "<?php echo lang('cal_nov'); ?>", "<?php echo lang('cal_dec'); ?>"];
	var month = IndexToMonth[ x.getMonth() ];
	var year = x.getFullYear();
	return year + ' ' + month;
	},
	dateFormat: function (x) {
	var IndexToMonth = ["<?php echo lang('cal_jan'); ?>", "<?php echo lang('cal_feb'); ?>", "<?php echo lang('cal_mar'); ?>", "<?php echo lang('cal_apr'); ?>", "<?php echo lang('cal_may'); ?>", "<?php echo lang('cal_jun'); ?>", "<?php echo lang('cal_jul'); ?>", "<?php echo lang('cal_aug'); ?>", "<?php echo lang('cal_sep'); ?>", "<?php echo lang('cal_oct'); ?>", "<?php echo lang('cal_nov'); ?>", "<?php echo lang('cal_dec'); ?>"];
	var month = IndexToMonth[ new Date(x).getMonth() ];
	var year = new Date(x).getFullYear();
	return year + ' ' + month;
	},
	resize: true
	});


	LineChart.options.labels.forEach(function(label, i) {
        var legendItem = $('<span class="legend-item"></span>').text( label).prepend('<span class="legend-color">&nbsp;</span>');
        legendItem.find('span')
          .css('backgroundColor', LineChart.options.lineColors[i]);
        $('#legend').append(legendItem)
   });


	var ctx = document.getElementById("pieChart").getContext('2d');
	var myChart = new Chart(ctx, {
	type: 'doughnut',
	data: {
		labels: [],
		datasets: [{
		backgroundColor: [
			"#f39c12",
			"#3c8dbc" 
		],
		data: [<?php echo Invoice::outstanding(); ?>, <?php echo $total_receipts; ?>]
		}],		 
		},
  	options: {
  
	responsive: true,
	maintainAspectRatio: false,
	tooltips: {
         enabled: false
	},
	animation: {
					duration: 2000,
					animateRotate: true,
					animateScale: false,
					easing: 'easeInOutBack'
					 
				}


  	}
  });
 
})(jQuery);
</script>