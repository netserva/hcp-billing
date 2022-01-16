<!-- Start -->
<section id="content">
	<section class="hbox stretch">
		
		<aside class="aside-md bg-white b-r hidden-print" id="subNav">
			<header class="dk header b-b">
				<a href="<?php echo base_url(); ?>invoices/manage/add" data-original-title="<?php echo lang('new_invoice'); ?>" data-toggle="tooltip" data-placement="top" class="btn btn-icon btn-default btn-sm pull-right"><i class="fa fa-plus"></i></a>
				<p class="h4"><?php echo lang('all_invoices'); ?></p>
			</header>
			
			<section class="vbox">
				<section class="scrollable w-f">
					<div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">

						<?php echo $this->load->view('sidebar/invoices', $invoices); ?>
						
					</div></section>
				</section>
			</aside>
			
			<aside>
				<section class="vbox">
					<header class="header bg-white b-b clearfix hidden-print">
						<div class="row m-t-sm">
							<div class="col-sm-8 m-b-xs">
								<?php
                                if (!empty($invoice_details)) {
                                    foreach ($invoice_details as $key => $inv) { ?>
								
								
								<div class="btn-group">
						<a href="<?php echo base_url(); ?>invoices/view/<?php echo $inv->inv_id; ?>" data-original-title="<?php echo lang('view_details'); ?>" data-toggle="tooltip" data-placement="top" class="btn btn-<?php echo config_item('theme_color'); ?> btn-sm"><i class="fa fa-info-circle"></i> <?php echo lang('invoice_details'); ?></a>
						</div>
								
								
							</div>
							<div class="col-sm-4 m-b-xs pull-right">
								<a href="<?php echo base_url(); ?>fopdf/invoice/<?php echo $inv->inv_id; ?>" class="btn btn-sm btn-dark pull-right">
								<i class="fa fa-file-pdf-o"></i> <?php echo lang('pdf'); ?></a>
							</div>
						</div> </header>
						
						
						
						<section class="scrollable w-f">
							<div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">






								<!-- Start Display Details -->
								

								<!-- Timeline START -->
								<section class="panel panel-default">
									<div class="panel-body">


					<div  id="activity">
                          <ul class="list-group no-radius m-b-none m-t-n-xxs list-group-lg no-border">
							<?php
                            if (!empty($activities)) {
                                foreach ($activities as $key => $a) { ?>
                            <li class="list-group-item">
                              <a href="#" class="thumb-sm pull-left m-r-sm">
                                <img src="<?php echo base_url(); ?>resource/avatar/<?php echo Applib::profile_info($a->user)->avatar; ?>" class="img-circle">
                              </a>
                              <a href="#" class="clear">
                                <small class="pull-right"><?php echo strftime('%b %d, %Y %H:%M:%S', strtotime($a->activity_date)); ?></small>
                                <strong class="block"><?php echo ucfirst(Applib::login_info($a->user)->username); ?></strong>
                                <small>
                                    <?php if ('' != lang($a->activity)) {
                                    if (!empty($a->value1)) {
                                        if (!empty($a->value2)) {
                                            echo sprintf(lang($a->activity), '<em>'.$a->value1.'</em>', '<em>'.$a->value2.'</em>');
                                        } else {
                                            echo sprintf(lang($a->activity), '<em>'.$a->value1.'</em>');
                                        }
                                    } else {
                                        echo lang($a->activity);
                                    }
                                } else {
                                    echo $a->activity;
                                }
                                    ?> 
                                </small>
                              </a>
                            </li>
                            <?php }
                            } ?>

                          </ul>
                        </div>
								



											
										<?php }
                                } ?>		
									</div>
								</section>
							</div>
						</section>
						<!-- End display details -->
						</section> </aside> </section> <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>
						<!-- end -->