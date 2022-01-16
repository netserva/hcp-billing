<div class="box box-solid box-default"> 
<header class="box-header "><?php echo lang('new_order'); ?></header>                   
    <div class="box-body">  
     <div class="row">
        <div class="col-sm-6"> 
                <?php $categories = [];

                    foreach (Item::list_items(['deleted' => 'No']) as $item) {
                        if ($item->parent > 8) {
                            $categories[$item->cat_name][] = $item;
                        }
                    }
                    foreach ($categories as $key => $options) { ?>                   
                            <h2><?php echo $key; ?></h2>  
                            <table class="table table-striped table-bordered">                                                  
                            <?php $count = 0; foreach ($options as $plan) {
                        $price = 0;
                        $period = '';
                        ++$count;

                        if ($plan->total_cost > 0) {
                            $price = $plan->total_cost;
                            $period = lang('total_cost');
                        }

                        if ($plan->annually > 0) {
                            $price = $plan->annually;
                            $period = lang('annually');
                        }

                        if ($plan->semi_annually > 0) {
                            $price = $plan->semi_annually;
                            $period = lang('semi_annually');
                        }

                        if ($plan->quarterly > 0) {
                            $price = $plan->quarterly;
                            $period = lang('quarterly');
                        }

                        if ($plan->monthly > 0) {
                            $price = $plan->monthly;
                            $period = lang('monthly');
                        } ?>


                                <tr><td><?php echo ucfirst($plan->item_name); ?></td><td><?php echo Applib::format_currency(config_item('default_currency'), $price); ?></td><td><?php echo ucfirst($period); ?></td><td><a href="<?php echo base_url(); ?>cart/options?item=<?php echo $plan->item_id; ?>" class="btn btn-sm btn-success pull-right"><?php echo lang('select'); ?></a></td></tr>                                        
                            <?php
                    } ?>
                        </table>
                    <?php } ?>                                

            </div>

            <div class="col-md-6 inner-order">

                <form method="post" action="<?php echo base_url(); ?>cart/add_domain" class="panel-body" id="search_form">
                <input name="domain" type="hidden" id="domain">
                <input name="price" type="hidden" id="price">
                <input name="type" type="hidden" id="type">
                </form>

                <div class="row domain_search">
                    <div class="col-md-12">
                    <input type="text" id="searchBar" placeholder="<?php echo lang('enter_domain_name'); ?>"> 
                        <select name="ext" id="ext" class="domain_ext">
                            <?php foreach (Item::get_domains() as $domain) { ?>
                            <option value="<?php echo $domain->item_name; ?>">.<?php echo $domain->item_name; ?></option>                       
                            <?php } ?> 
                        </select>	
                    </div>
                </div>
                <br />
                <div class="row">
                        <div class="col-md-6">
                        <a id="existing" href="<?php echo base_url(); ?>cart/add_existing" class="btn btn-warning btn-block"><?php echo lang('existing_domain'); ?></a>	
                        </div>
                        <div class="col-md-3">
                            <input type="submit" class="btn btn-info btn-block" data="<?php echo lang('domain_transfer'); ?>" id="Transfer" value="<?php echo lang('transfer'); ?>" /> 
                        </div>
                        <div class="col-md-3">
                            <input type="submit" class="btn btn-primary btn-block" data="<?php echo lang('domain_registration'); ?>" id="Search" value="<?php echo lang('register'); ?>" />		
                        </div>
                </div>
                <p>
                <div class="checking">
                    <img id="checking" src="<?php echo base_url(); ?>resource/images/checking.gif"/> 
                </div>
                <div id="response"></div>
                <div id="continue"> <?php echo lang('select_hosting_below'); ?><a href="<?php echo base_url(); ?>cart/domain_only" class="btn btn-info"><?php echo lang('domain_only'); ?></a> </span></div>

                </p>
                </form>

            </div>
        </div>
    </div>
</div>    

 