<?php declare(strict_types=1);
$cart = $this->session->userdata('cart');
    $total = 0;
?>
<section id="pricing" class="bg-silver-light">
    <div class="container inner">
    <div class="box box-solid box-default">    
        <div class="box-body">
        <div class="section-title text-center mb-40">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h2 class="title text-uppercase text-theme-color-2 line-bottom-double-line-centered"><?php echo lang('domain'); ?></h2>
                    <p class="font-13 mt-10"><?php echo lang('enter_full_domain'); ?></p>
                </div>
            </div>
        </div>
        <div class="section-content">
            <div class="row"> 
                <div class="col-sm-6">
                    <h4><?php echo lang('enter_full_domain'); ?></h4>
                        <form method="post" action="<?php echo base_url(); ?>cart/existing_domain" class="panel-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="text" name="domain" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="submit" class="btn btn-primary btn-block" name="type"
                                        value="<?php echo lang('continue'); ?>" />
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>