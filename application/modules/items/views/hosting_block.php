<div class="row pricing-row" id="style-<?php echo $style; ?>">          
        <?php $count = 0;
        foreach ($items as $plan) {
            $price = 0;
            $period = '';
            ++$count;

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
            }

            $features = explode(',', $plan->item_features);
            $price = explode('.', $price); ?>

        <div class="col-lg-4 col-md-6 pricing-col">
                <div class="pricing pricing-<?php echo $style; ?> <?php echo (3 == $count || 5 == $count) ? 'starter' : 'premium'; ?>">
                    <div class="bg-element"></div>
                    <p class="pricing-title"><?php echo ucfirst($plan->item_name); ?></p>
                    <div class="price">
                        <div class="currency"><?php echo App::currencies(config_item('default_currency'))->symbol; ?></div>
                        <div class="num"><?php echo $price[0]; ?></div>
                        <?php if ('one' == $style || 'two' == $style || 'three' == $style || 'one' == $style) { ?>
                        <div class="period"><?php echo $period; ?></div>
                        <?php } ?>
                    </div>
                    <?php if ('one' != $style && 'two' != $style && 'three' != $style && 'one' != $style) { ?>
                        <div class="period"><?php echo ('three' != $style) ? '/' : ''; ?><?php echo $period; ?></div>
                    <?php } ?>                    

                    <ul class="specs">                        
                        <?php if (count($features) > 0) {
                foreach ($features as $feature) { ?>
                            <li>
                                <?php echo $feature; ?>
                            </li>
                        <?php }
            } ?>                        
                    </ul> 

                    <?php if ('two' == $style) { ?>
                        <div class="bg-element-2"></div>
                    <div class="button-holder"> 
                    <?php } ?>
                                            
                        <a href="<?php echo base_url().'cart/options?item='.$plan->item_id; ?>" class="btn"><?php echo lang('order_now'); ?></a>
                        <?php if ('two' == $style) { ?>
                        </div>
                    <?php } ?>
                
                </div>
            </div> 
        <?php
        } ?>            
</div>
 
