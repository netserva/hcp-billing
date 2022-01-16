<?php declare(strict_types=1);
$package = $package[0];
   if (isset($_GET['item'])) {
       $options = ['total_cost', 'monthly', 'quarterly', 'semi_annually', 'annually'];
   } else {
       header('Location: '.base_url());
   }
?>

<div class="box"> 	
	<div class="container inner">
        <div class="row"> 
					<div class="col-md-6">
					<h2><?php echo $package->item_name; ?></h2>	
						<?php
                        $attributes = ['class' => 'bs-example form-horizontal'];
                        echo form_open(base_url().'cart/options', $attributes); ?> 
						<input type="hidden" name="id" value="<?php echo $package->item_id; ?>">
							<div class="row">
								<div class="col-md-8">
									<select class="form-control" name="selected">
									<?php $count = 0;
                                    foreach ($options as $key => $value) {
                                        if (isset($package->{$value}) && $package->{$value} > 0) {
                                            ++$count; ?>
											<option value="<?php echo $package->item_id; ?>,<?php echo $package->item_name; ?>,<?php echo $value; ?>,<?php echo $package->{$value}; ?>"><?php echo Applib::format_currency(config_item('default_currency'), $package->{$value}); ?> - <?php echo lang($value); ?></option>
									<?php
                                        }
                                    }

                                    if (0 == $count) {
                                        foreach ($options as $key => $value) {
                                            if (isset($package->{$value}) && 0 == $package->{$value}) { ?>
											<option value="<?php echo $package->item_id; ?>,<?php echo $package->item_name; ?>,<?php echo $value; ?>,<?php echo $package->{$value}; ?>"><?php echo Applib::format_currency(config_item('default_currency'), $package->{$value}); ?> - <?php echo lang($value); ?></option>
									<?php if (0 == $package->{$value}) {
                                                break;
                                            }
                                            }
                                        }
                                    }
                                    ?>
									</select>
								</div>
								<div class="col-md-4">
									<input type="submit" class="btn btn-success btn-block" value="<?php echo lang('continue'); ?>">
								</div>
							</div>
						</form>
						</div>
					</div>
				</div>
				<div class="h_100"></div>
	 </div>
