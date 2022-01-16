<?php declare(strict_types=1);
$domains = modules::run('domains/domain_pricing', ''); ?>
    <section class="domain_search">
          <div class="forms-main">
			   <div class="container">

                    <div id="response"></div>
                   <div id="continue"> <div class="btn-group"><a href="<?php echo base_url(); ?>cart/hosting_packages" class="btn btn-warning"><?php echo lang('add_hosting'); ?></a><a href="<?php echo base_url(); ?>cart/domain_only" class="btn btn-info"><?php echo lang('domain_only'); ?></a></div> </span></div>
           
				   <div class="grid grid-column-2">
						<div class="column">
							<h3><?php echo lang('check_domain_label'); ?></h3>							
						</div>	 
						<div class="column">
						    <form action="#" class="search_form" method="post" id="search_form">
                                <input name="domain" type="hidden" id="domain">
                                <input name="price" type="hidden" id="price">
                                <input name="type" type="hidden" id="type">
            
								<input id="searchBar" type="email" name="email" placeholder="Enter your domain name...">
								<span class="input-group-btn">

                                <select class="btn btn-default" name="ext" id="ext">
                                <?php foreach ($domains as $domain) { ?>
                                <option value="<?php echo $domain->item_name; ?>">.<?php echo $domain->item_name; ?></option>                       
                                <?php } ?>    
                                </select>

                                </span>
                                <button type="submit" id="Transfer" data="<?php echo lang('domain_transfer'); ?>"><?php echo lang('transfer'); ?></button>
                                <button type="submit" id="btnSearch" data="<?php echo lang('domain_registration'); ?>"><?php echo lang('check_domain'); ?></button>
                                <img id="checking" src="<?php echo base_url(); ?>resource/images/checking.gif"/>
                
							</form>
							<p>
                            <?php $limit = 5;
                            $count = 0;
                            foreach ($domains as $domain) {
                                if ($count == $limit) {
                                    break;
                                } ?>
                            .<?php echo $domain->item_name; ?><sub><?php echo Applib::format_currency(config_item('default_currency'), $domain->registration); ?></sub>                      
                            <?php ++$count;
                            } ?>
                            </p>
						</div>
					</div>
			   </div>
		
		   </div>
    </section>
    