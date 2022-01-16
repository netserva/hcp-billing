<?php declare(strict_types=1);
$cart = $this->session->userdata('cart');
    $total = 0;
?>

<div class="box">
    <div class="container inner domain_search">
        <div class="row">
                    <div class="col-sm-3">
                        <a href="<?php echo base_url(); ?>cart/add_existing"><button type="submit" id="Existing"><?php echo lang('use_existing_domain'); ?></button></a>
                    </div>
     
                    <div class="col-sm-8">
                            <form action="<?php echo base_url(); ?>cart/add_domain" class="search_form" method="post" id="search_form cart">
                                <input name="domain" type="hidden" id="domain">
                                <input name="price" type="hidden" id="price">
                                <input name="type" type="hidden" id="type">
            
                                <input id="searchBar" type="text" placeholder="Enter your domain name...">
                                <span class="input-group-btn">

                                <select class="btn btn-default" name="ext" id="ext">
                                <?php foreach ($domains as $domain) { ?>
                                <option value="<?php echo $domain->item_name; ?>">.<?php echo $domain->item_name; ?></option>                       
                                <?php } ?>    
                                </select>
                                </span> 
                                <button type="submit" id="Transfer" data="<?php echo lang('domain_transfer'); ?>"><?php echo lang('transfer'); ?></button>
                                <button type="submit" id="btnSearch" data="<?php echo lang('domain_registration'); ?>"><?php echo lang('register'); ?></button>
                                
                                <img id="checking" src="<?php echo base_url(); ?>resource/images/checking.gif"/>                
                            </form>	 
                    </div>
                   
                </div>

                <div id="response"></div>
             
    </div>
</div>


 