<?php declare(strict_types=1);
$client_cur = Client::get_by_user($this->session->userdata('user_id'))->currency;
   $interval = intervals();
   $current = Order::get_order($current);
   $options = Item::view_item($options);
?>
 <div class="box">
    <div class="box-body">

 
    <div class="container aside-xxxl animated fadeInUp">
 <div class="panel panel-danger bg-white m-t-lg"> 
 <header class="panel-heading text-center">
      <h3 class="text-danger"><?php echo $options->item_name; ?></h3> 
    </header>
    <div class="panel-body">  
 
            <table class="table">
            <thead>
              <tr><th><?php echo lang('amount'); ?></th><th><?php echo lang('billed'); ?></th><th><?php echo lang('payable_today'); ?></th><th><?php echo lang('next_payent'); ?></th><th><?php echo lang('options'); ?></th></tr>
            </thead>
            <tbody>
                <?php if ($options->monthly > 0) {
    $renewal = $current->renewal_date;
    $days = (strtotime($renewal) - strtotime(date('Y-m-d'))) / (60 * 60 * 24);
    if ('monthly' == $current->renewal) {
        if ($current->fee > 0) {
            $curr_rate = $current->fee / $interval[$current->renewal];
            $balance = $days * $curr_rate;
        } else {
            $balance = 0;
        }

        $new_rate = $options->monthly / $interval[$current->renewal];
        $payable = $days * $new_rate - $balance;
    } else {
        if ($current->fee > 0) {
            $rate = $current->fee / $interval[$current->renewal];
            $balance = $days * $rate;
        } else {
            $balance = 0;
        }

        $payable = $options->monthly - $balance;
        $renewal = Invoice::get_renewal_date(date('Y-m-d'), $interval['monthly']);
    }
    $payable = ($payable < 0) ? '0.00' : round($payable, 2); ?>
                        <tr><td>
                        <?php if (!User::is_admin() && !User::is_staff()) {
        echo Applib::format_currency($client_cur, Applib::client_currency($client_cur, $options->monthly));
    } else {
        echo Applib::format_currency(config_item('default_currency'), $options->monthly);
    } ?></td>
                        <td><?php echo lang('monthly'); ?></td>
                        <td class="bg-green center">
                        <?php if (!User::is_admin() && !User::is_staff()) {
        echo Applib::format_currency($client_cur, Applib::client_currency($client_cur, $payable));
    } else {
        echo Applib::format_currency(config_item('default_currency'), $payable);
    } ?>
                        </td>
                        <td class=""><?php echo $renewal; ?></td>
                        <td><?php echo form_open(base_url().'accounts/review', ''); ?> 
                        <input name="renewal" value="monthly" type="hidden">
                        <input name="amount" value="<?php echo $options->monthly; ?>" type="hidden">
                        <input name="payable" value="<?php echo $payable; ?>" type="hidden">
                        <input name="next_due" value="<?php echo $renewal; ?>" type="hidden">
                        <button class="btn btn-sm btn-default" type="submit"><?php echo lang('select'); ?></button></form>
                        </td></tr>
                    <?php
}

                    if ($options->quarterly > 0) {
                        $renewal = $current->renewal_date;
                        $days = (strtotime($renewal) - strtotime(date('Y-m-d'))) / (60 * 60 * 24);
                        if ('quarterly' == $current->renewal) {
                            if ($current->fee > 0) {
                                $curr_rate = $current->fee / $interval[$current->renewal];
                                $balance = $days * $curr_rate;
                            } else {
                                $balance = 0;
                            }

                            $new_rate = $options->monthly / $interval[$current->renewal];
                            $payable = $days * $new_rate - $balance;
                        } else {
                            if ($current->fee > 0) {
                                $rate = $current->fee / $interval[$current->renewal];
                                $balance = $days * $rate;
                            } else {
                                $balance = 0;
                            }
                            $payable = $options->quarterly - $balance;
                            $payable = ($payable < 0) ? '0.00' : $payable;
                            $renewal = Invoice::get_renewal_date(date('Y-m-d'), $interval['quarterly']);
                        }
                        $payable = ($payable < 0) ? '0.00' : round($payable, 2); ?>
                        <tr><td><?php if (!User::is_admin() && !User::is_staff()) {
                            echo Applib::format_currency($client_cur, Applib::client_currency($client_cur, $options->quarterly));
                        } else {
                            echo Applib::format_currency(config_item('default_currency'), $options->quarterly);
                        } ?></td>
                        <td><?php echo lang('quarterly'); ?></td>
                        <td class="bg-green center">
                        <?php if (!User::is_admin() && !User::is_staff()) {
                            echo Applib::format_currency($client_cur, Applib::client_currency($client_cur, $payable));
                        } else {
                            echo Applib::format_currency(config_item('default_currency'), $payable);
                        } ?>
                        </td>
                        <td class=""><?php echo $renewal; ?></td>
                        <td><?php echo form_open(base_url().'accounts/review', ''); ?> 
                        <input name="renewal" value="quarterly" type="hidden">
                        <input name="amount" value="<?php echo $options->quarterly; ?>" type="hidden">
                        <input name="payable" value="<?php echo $payable; ?>" type="hidden">
                        <input name="next_due" value="<?php echo $renewal; ?>" type="hidden">
                        <button class="btn btn-sm btn-default" type="submit"><?php echo lang('select'); ?></button></form>
                        </td></tr>
                    <?php
                    }

                    if ($options->semi_annually > 0) {
                        $renewal = $current->renewal_date;
                        $days = (strtotime($renewal) - strtotime(date('Y-m-d'))) / (60 * 60 * 24);
                        if ('semi_annually' == $current->renewal) {
                            if ($current->fee > 0) {
                                $curr_rate = $current->fee / $interval[$current->renewal];
                                $balance = $days * $curr_rate;
                            } else {
                                $balance = 0;
                            }

                            $new_rate = $options->monthly / $interval[$current->renewal];
                            $payable = $days * $new_rate - $balance;
                        } else {
                            if ($current->fee > 0) {
                                $rate = $current->fee / $interval[$current->renewal];
                                $balance = $days * $rate;
                            } else {
                                $balance = 0;
                            }
                            $payable = $options->semi_annually - $balance;
                            $renewal = Invoice::get_renewal_date(date('Y-m-d'), $interval['semi_annually']);
                        }
                        $payable = ($payable < 0) ? '0.00' : round($payable, 2); ?>
                        <tr><td><?php if (!User::is_admin() && !User::is_staff()) {
                            echo Applib::format_currency($client_cur, Applib::client_currency($client_cur, $options->semi_annually));
                        } else {
                            echo Applib::format_currency(config_item('default_currency'), $options->semi_annually);
                        } ?></td>
                        <td><?php echo lang('semi_annually'); ?></td>
                        <td class="bg-green center">
                        <?php if (!User::is_admin() && !User::is_staff()) {
                            echo Applib::format_currency($client_cur, Applib::client_currency($client_cur, $payable));
                        } else {
                            echo Applib::format_currency(config_item('default_currency'), $payable);
                        } ?>
                        </td>
                        <td class=""><?php echo $renewal; ?></td>   
                        <td><?php echo form_open(base_url().'accounts/review', ''); ?> 
                        <input name="renewal" value="semi_annually" type="hidden">
                        <input name="amount" value="<?php echo $options->semi_annually; ?>" type="hidden">
                        <input name="payable" value="<?php echo $payable; ?>" type="hidden">
                        <input name="next_due" value="<?php echo $renewal; ?>" type="hidden">
                        <button class="btn btn-sm btn-default" type="submit"><?php echo lang('select'); ?></button></form>
                        </td></tr>
                    <?php
                    }

                    if ($options->annually > 0) {
                        $renewal = $current->renewal_date;
                        $days = (strtotime($renewal) - strtotime(date('Y-m-d'))) / (60 * 60 * 24);
                        if ('annually' == $current->renewal) {
                            if ($current->fee > 0) {
                                $curr_rate = $current->fee / $interval[$current->renewal];
                                $balance = $days * $curr_rate;
                            } else {
                                $balance = 0;
                            }

                            $new_rate = $options->annually / $interval[$current->renewal];
                            $payable = $days * $new_rate - $balance;
                        } else {
                            $days = (strtotime($renewal) - strtotime(date('Y-m-d'))) / (60 * 60 * 24);
                            if ($current->fee > 0) {
                                $rate = $current->fee / $interval[$current->renewal];
                                $bal = $days * $rate;
                            } else {
                                $bal = 0;
                            }

                            $renewal = $current->renewal_date;
                            $payable = $options->annually - $bal;
                        }
                        $payable = ($payable < 0) ? '0.00' : round($payable, 2); ?>
                        <tr><td><?php if (!User::is_admin() && !User::is_staff()) {
                            echo Applib::format_currency($client_cur, Applib::client_currency($client_cur, $options->annually));
                        } else {
                            echo Applib::format_currency(config_item('default_currency'), $options->annually);
                        } ?></td>
                        <td><?php echo lang('annually'); ?></td>
                        <td class="bg-green center">
                        <?php if (!User::is_admin() && !User::is_staff()) {
                            echo Applib::format_currency($client_cur, Applib::client_currency($client_cur, $payable));
                        } else {
                            echo Applib::format_currency(config_item('default_currency'), $payable);
                        } ?>
                        </td>
                        <td class=""><?php echo $renewal; ?></td>
                        <td><?php echo form_open(base_url().'accounts/review', ''); ?> 
                        <input name="renewal" value="annually" type="hidden">
                        <input name="amount" value="<?php echo $options->annually; ?>" type="hidden">
                        <input name="payable" value="<?php echo $payable; ?>" type="hidden">
                        <input name="next_due" value="<?php echo $renewal; ?>" type="hidden">
                        <button class="btn btn-sm btn-default" type="submit"><?php echo lang('select'); ?></button></form>
                        </td></tr>
                    <?php
                    } ?>

                    </tbody>
                </table> 
            </div>
          </div>
     </div>
 
</div>
</div>