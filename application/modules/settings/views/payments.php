    <!-- Start Form -->
    <?php
    $view = $_GET['view'] ?? '';
    $data['load_setting'] = $load_setting;

    switch ($view) {
        case 'currency':
            $this->load->view('currency', $data);

            break;

            default: ?>


        <?php echo $this->session->flashdata('form_error'); ?>
        <?php
        $attributes = ['class' => 'bs-example form-horizontal'];
        echo form_open('settings/update', $attributes); ?>
                 <input type="hidden" name="settings" value="<?php echo $load_setting; ?>">


                 <img src="<?php echo base_url(); ?>resource/images/gateways/mollie.png" alt="Mollie" />

                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('mollie_live'); ?></label>
                        <div class="col-lg-4">
                            <label class="switch">
                                <input type="hidden" value="off" name="mollie_live" />
                                <input type="checkbox" <?php if ('TRUE' == config_item('mollie_live')) {
            echo 'checked="checked"';
        } ?> name="mollie_live">
                                <span></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('mollie_api_key'); ?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" value="<?php echo config_item('mollie_api_key'); ?>" name="mollie_api_key">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('mollie_active'); ?></label>
                        <div class="col-lg-4">
                            <label class="switch">
                                <input type="hidden" value="off" name="mollie_active" />
                                <input type="checkbox" <?php if ('TRUE' == config_item('mollie_active')) {
            echo 'checked="checked"';
        } ?> name="mollie_active">
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="line line-dashed line-lg pull-in"></div>




                    <img src="<?php echo base_url(); ?>resource/images/gateways/razorpay.png" alt="Mollie" />

                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('razorpay_live'); ?></label>
                        <div class="col-lg-4">
                            <label class="switch">
                                <input type="hidden" value="off" name="razorpay_live" />
                                <input type="checkbox" <?php if ('TRUE' == config_item('razorpay_live')) {
            echo 'checked="checked"';
        } ?> name="razorpay_live">
                                <span></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('razorpay_api_key'); ?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" value="<?php echo config_item('razorpay_api_key'); ?>" name="razorpay_api_key">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('razorpay_active'); ?></label>
                        <div class="col-lg-4">
                            <label class="switch">
                                <input type="hidden" value="off" name="razorpay_active" />
                                <input type="checkbox" <?php if ('TRUE' == config_item('razorpay_active')) {
            echo 'checked="checked"';
        } ?> name="razorpay_active">
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="line line-dashed line-lg pull-in"></div>



                    <img src="<?php echo base_url(); ?>resource/images/gateways/instamojo.png" alt="Instamojo" />

                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('instamojo_live'); ?></label>
                        <div class="col-lg-4">
                            <label class="switch">
                                <input type="hidden" value="off" name="instamojo_live" />
                                <input type="checkbox" <?php if ('TRUE' == config_item('instamojo_live')) {
            echo 'checked="checked"';
        } ?> name="instamojo_live">
                                <span></span>
                            </label>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('instamojo_api_key'); ?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" value="<?php echo config_item('instamojo_api_key'); ?>" name="instamojo_api_key">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('instamojo_oath_token'); ?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" value="<?php echo config_item('instamojo_oath_token'); ?>" name="instamojo_oath_token">
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('instamojo_hash'); ?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" value="<?php echo config_item('instamojo_hash'); ?>" name="instamojo_hash">
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('instamojo_active'); ?></label>
                        <div class="col-lg-4">
                            <label class="switch">
                                <input type="hidden" value="off" name="instamojo_active" />
                                <input type="checkbox" <?php if ('TRUE' == config_item('instamojo_active')) {
            echo 'checked="checked"';
        } ?> name="instamojo_active">
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="line line-dashed line-lg pull-in"></div>


                    <img src="<?php echo base_url(); ?>resource/images/gateways/paystack.png" alt="Paystack" />

                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('paystack_live'); ?></label>
                        <div class="col-lg-4">
                            <label class="switch">
                                <input type="hidden" value="off" name="paystack_live" />
                                <input type="checkbox" <?php if ('TRUE' == config_item('paystack_live')) {
            echo 'checked="checked"';
        } ?> name="paystack_live">
                                <span></span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('paystack_secret_key'); ?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" value="<?php echo config_item('paystack_secret_key'); ?>" name="paystack_secret_key">
                        </div>
                    </div>            

                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('paystack_active'); ?></label>
                        <div class="col-lg-4">
                            <label class="switch">
                                <input type="hidden" value="off" name="paystack_active" />
                                <input type="checkbox" <?php if ('TRUE' == config_item('paystack_active')) {
            echo 'checked="checked"';
        } ?> name="paystack_active">
                                <span></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label">Set Callback URL</label>
                        <div class="col-lg-4"> 
                            <small><?php echo base_url(); ?>paystack/verify</small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label">Leave Webhook URL</label>
                        <div class="col-lg-4"> 
                            <small>Empty</small>
                        </div>
                    </div>

                    <div class="line line-dashed line-lg pull-in"></div>



                    <img src="<?php echo base_url(); ?>resource/images/gateways/payfast.png" alt="Payfast" />

                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('payfast_live'); ?></label>
                        <div class="col-lg-4">
                            <label class="switch">
                                <input type="hidden" value="off" name="payfast_live" />
                                <input type="checkbox" <?php if ('TRUE' == config_item('payfast_live')) {
            echo 'checked="checked"';
        } ?> name="payfast_live">
                                <span></span>
                            </label>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('payfast_merchant_id'); ?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" value="<?php echo config_item('payfast_merchant_id'); ?>" name="payfast_merchant_id">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('payfast_merchant_key'); ?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" value="<?php echo config_item('payfast_merchant_key'); ?>" name="payfast_merchant_key">
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('payfast_passphrase'); ?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" value="<?php echo config_item('payfast_passphrase'); ?>" name="payfast_passphrase">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('payfast_active'); ?></label>
                        <div class="col-lg-4">
                            <label class="switch">
                                <input type="hidden" value="off" name="payfast_active" />
                                <input type="checkbox" <?php if ('TRUE' == config_item('payfast_active')) {
            echo 'checked="checked"';
        } ?> name="payfast_active">
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="line line-dashed line-lg pull-in"></div>




                 <img src="<?php echo base_url(); ?>resource/images/gateways/paypal.png" alt="PayPal" />
                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('paypal_live'); ?></label>
                        <div class="col-lg-4">
                            <label class="switch">
                                <input type="hidden" value="off" name="paypal_live" />
                                <input type="checkbox" <?php if ('TRUE' == config_item('paypal_live')) {
            echo 'checked="checked"';
        } ?> name="paypal_live">
                                <span></span>
                            </label>
                        </div>
                    </div>

                    
                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('paypal_email'); ?></label>
                        <div class="col-lg-4">
                            <input type="email" name="paypal_email" class="form-control" value="<?php echo config_item('paypal_email'); ?>">
                        </div>
                    </div>
                    

                   <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('paypal_active'); ?></label>
                        <div class="col-lg-4">
                            <label class="switch">
                                <input type="hidden" value="off" name="paypal_active" />
                                <input type="checkbox" <?php if ('TRUE' == config_item('paypal_active')) {
            echo 'checked="checked"';
        } ?> name="paypal_active">
                                <span></span>
                            </label>
                        </div>
                    </div> 


                    <div class="line line-dashed line-lg pull-in"></div>
                    <img src="<?php echo base_url(); ?>resource/images/gateways/checkout.png" alt="2Checkout" />

                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('2checkout_live'); ?></label>
                        <div class="col-lg-4">
                            <label class="switch">
                                <input type="hidden" value="off" name="two_checkout_live" />
                                <input type="checkbox" <?php if ('TRUE' == config_item('two_checkout_live')) {
            echo 'checked="checked"';
        } ?> name="two_checkout_live">
                                <span></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('checkout_publishable_key'); ?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" value="<?php echo config_item('2checkout_publishable_key'); ?>" name="2checkout_publishable_key">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('checkout_private_key'); ?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" value="<?php echo config_item('2checkout_private_key'); ?>" name="2checkout_private_key">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('checkout_seller_id'); ?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" value="<?php echo config_item('2checkout_seller_id'); ?>" name="2checkout_seller_id">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('two_checkout_active'); ?></label>
                        <div class="col-lg-4">
                            <label class="switch">
                                <input type="hidden" value="off" name="two_checkout_active" />
                                <input type="checkbox" <?php if ('TRUE' == config_item('two_checkout_active')) {
            echo 'checked="checked"';
        } ?> name="two_checkout_active">
                                <span></span>
                            </label>
                        </div>
                    </div>

                    <div class="line line-dashed line-lg pull-in"></div>


                    <img src="<?php echo base_url(); ?>resource/images/gateways/stripe.png" alt="Stripe" />

                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('stripe_live'); ?></label>
                        <div class="col-lg-4">
                            <label class="switch">
                                <input type="hidden" value="off" name="stripe_live" />
                                <input type="checkbox" <?php if ('TRUE' == config_item('stripe_live')) {
            echo 'checked="checked"';
        } ?> name="stripe_live">
                                <span></span>
                            </label>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('stripe_private_key'); ?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" value="<?php echo config_item('stripe_private_key'); ?>" name="stripe_private_key">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('stripe_public_key'); ?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" value="<?php echo config_item('stripe_public_key'); ?>" name="stripe_public_key">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('stripe_active'); ?></label>
                        <div class="col-lg-4">
                            <label class="switch">
                                <input type="hidden" value="off" name="stripe_active" />
                                <input type="checkbox" <?php if ('TRUE' == config_item('stripe_active')) {
            echo 'checked="checked"';
        } ?> name="stripe_active">
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="line line-dashed line-lg pull-in"></div>


                    <img src="<?php echo base_url(); ?>resource/images/gateways/coin.png" alt="CoinPayments" />

                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('coinpayments_live'); ?></label>
                        <div class="col-lg-4">
                            <label class="switch">
                                <input type="hidden" value="off" name="coinpayments_live" />
                                <input type="checkbox" <?php if ('TRUE' == config_item('coinpayments_live')) {
            echo 'checked="checked"';
        } ?> name="coinpayments_live">
                                <span></span>
                            </label>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('coinpayments_private_key'); ?></label>
                        <div class="col-lg-4">
                            <input type="<?php echo 'TRUE' == config_item('demo_mode') ? 'password' : 'text'; ?>" class="form-control" value="<?php echo config_item('coinpayments_private_key'); ?>" name="coinpayments_private_key">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('coinpayments_public_key'); ?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" value="<?php echo config_item('coinpayments_public_key'); ?>" name="coinpayments_public_key">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('accept_coin'); ?></label>
                        <div class="col-lg-2">
                            <input type="text" class="form-control" value="<?php echo config_item('accept_coin'); ?>" name="accept_coin">
                        </div>
                        <span class="help-block m-b-none small text-danger"><a href="https://www.coinpayments.net/supported-coins" target="_blank"><?php echo lang('code_list'); ?></a></span>
                    </div>


                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('coinpayments_active'); ?></label>
                        <div class="col-lg-4">
                            <label class="switch">
                                <input type="hidden" value="off" name="coinpayments_active" />
                                <input type="checkbox" <?php if ('TRUE' == config_item('coinpayments_active')) {
            echo 'checked="checked"';
        } ?> name="coinpayments_active">
                                <span></span>
                            </label>
                        </div>
                    </div>

                    <div class="line line-dashed line-lg pull-in"></div>
                    <img src="<?php echo base_url(); ?>resource/images/gateways/bitcoin.png" alt="Bitcoin" />

                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('bitcoin_live'); ?></label>
                        <div class="col-lg-4">
                            <label class="switch">
                                <input type="hidden" value="off" name="bitcoin_live" />
                                <input type="checkbox" <?php if ('TRUE' == config_item('bitcoin_live')) {
            echo 'checked="checked"';
        } ?> name="bitcoin_live">
                                <span></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('blockchain_xpub'); ?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" value="<?php echo config_item('bitcoin_address'); ?>" name="bitcoin_address">
                        </div>
                         <span class="help-block m-b-none small text-danger"><a href="https://blockchain.info/api/api_receive" target="_blank"><?php echo lang('read_more'); ?></a></span>
                         
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('blockchain_api_key'); ?></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" value="<?php echo config_item('bitcoin_api_key'); ?>" name="bitcoin_api_key">
                        </div>
                        <span class="help-block m-b-none small text-danger"><a href="https://api.blockchain.info/v2/apikey/request/" target="_blank"><?php echo lang('read_more'); ?></a></span>
                        
                    </div>
                    

                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('bitcoin_active'); ?></label>
                        <div class="col-lg-4">
                            <label class="switch">
                                <input type="hidden" value="off" name="bitcoin_active" />
                                <input type="checkbox" <?php if ('TRUE' == config_item('bitcoin_active')) {
            echo 'checked="checked"';
        } ?> name="bitcoin_active">
                                <span></span>
                            </label>
                        </div>
                    </div>
                    
          
                    <div class="text-center">
                        <button type="submit" class="btn btn-sm btn-<?php echo config_item('theme_color'); ?>"><?php echo lang('save_changes'); ?></button>
                    </div>
                
        </form>

         <?php
            break;
    }
    ?>
 
    <!-- End Form -->
 