 
<?php $item = Item::view_item($item);
  $account = Order::get_order($account);
  $client_cur = Client::get_by_user($this->session->userdata('user_id'))->currency;
?>

 
 
	<div class="box">
	<div class="box-body">

    <div class="container aside-xxxl animated fadeInUp">
    <div class="panel panel-success m-t-lg bg-white"> 
    <header class="panel-heading text-center">
      <h3 class="text-success"><?php echo lang('upgrade_confirmation'); ?></h3>
      <h5> <?php echo $account->item_name; ?> &nbsp; <i class="fa fa-arrow-circle-right icon"></i> <?php echo $item->item_name; ?> </h5>
    </header>
    <div class="panel-body">                 
                <table class="table table-bordered">
                    <thead>
                        <tr>                          
                          <th><?php echo lang('renewal'); ?></th>
                          <th><?php echo lang('next_payment'); ?></th>
                          <th><?php echo lang('amount'); ?></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>                    
                          <td><?php echo ucfirst($renewal); ?></td>
                          <td><?php echo strftime(config_item('date_format'), strtotime($renewal_date)); ?></td>
                          <td><?php if (!User::is_admin() && !User::is_staff()) {
    echo Applib::format_currency($client_cur, Applib::client_currency($client_cur, $amount));
} else {
                                            echo Applib::format_currency(config_item('default_currency'), $amount);
                                        }
                               ?></td>
                        </tr>
                        <tr>
                          <td colspan="2"><span class="pull-right"><?php echo lang('payable_today'); ?></span></td>
                          <td><?php if (!User::is_admin() && !User::is_staff()) {
                                   echo Applib::format_currency($client_cur, Applib::client_currency($client_cur, $payable));
                               } else {
                                            echo Applib::format_currency(config_item('default_currency'), $payable);
                                        }
                               ?></td>
                        </tr>
                        <tr> 
                          <td colspan="2"></td>
                          <td><?php echo form_open(base_url().'invoices/upgrade', ''); ?> 
                          <input name="upgrade" value="true" type="hidden">
                          <button class="btn btn-sm btn-success" type="submit"><?php echo lang('submit_order'); ?></button></form></td>
                        </tr>
                        </tbody>
                  </table>        
                </div>		 
              </div>
            </div>
      </div> 
      </div>
 
 