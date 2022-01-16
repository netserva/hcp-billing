
<!-- Start -->
            <div class="box">
                <div class="box-header b-b clearfix">
                          <?php $i = Payment::view_by_id($id); ?>

                            <strong><i class="fa fa-info-circle"></i> <?php echo lang('payment'); ?> - <?php echo $i->trans_id; ?> </strong>                      
                            <a href="<?php echo base_url(); ?>payments/view/<?php echo $i->p_id; ?>" data-original-title="<?php echo lang('view_details'); ?>" data-toggle="tooltip" data-placement="top" class="btn btn-<?php echo config_item('theme_color'); ?> btn-sm pull-right"><i class="fa fa-info-circle"></i> <?php echo lang('payment_details'); ?></a>
                    </div>
                   <div class="box-body">

                                <?php
                                $attributes = ['class' => 'bs-example form-horizontal'];
                                echo form_open(base_url().'payments/edit', $attributes); ?>
                                <input type="hidden" name="p_id" value="<?php echo $i->p_id; ?>">

                                <div class="form-group">
                                    <label class="col-lg-3 control-label"><?php echo lang('amount'); ?> <span class="text-danger">*</span></label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" value="<?php echo $i->amount; ?>" name="amount">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label"><?php echo lang('payment_method'); ?> <span class="text-danger">*</span></label>
                                    <div class="col-lg-4">
                                        <select name="payment_method" class="form-control">
                                            <?php foreach (App::list_payment_methods() as $key => $p_method) { ?>
                                                <option value="<?php echo $p_method->method_id; ?>"<?php echo ($i->payment_method == $p_method->method_id ? ' selected="selected"' : ''); ?>><?php echo $p_method->method_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>


                                <?php $currency = App::currencies($i->currency); ?>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label"><?php echo lang('currency'); ?> <span class="text-danger">*</span></label>
                                    <div class="col-lg-4">
                                        <select name="currency" class="form-control">
                                           <?php foreach (App::currencies() as $cur) { ?>
                                <option value="<?php echo $cur->code; ?>"<?php echo ($currency->code == $cur->code ? ' selected="selected"' : ''); ?>><?php echo $cur->name; ?></option>
                                <?php } ?>
                                        </select>
                                    </div>
                                </div>



                                <div class="form-group">
                                    <label class="col-lg-3 control-label"><?php echo lang('payment_date'); ?></label>
                                    <div class="col-lg-4">
                                        <input class="input-sm input-s datepicker-input form-control" size="16" type="text" value="<?php echo strftime(config_item('date_format'), strtotime($i->payment_date)); ?>" name="payment_date" data-date-format="<?php echo config_item('date_picker_format'); ?>" >
                                    </div>
                                </div>



                                <div class="form-group">
                                    <label class="col-lg-3 control-label"><?php echo lang('notes'); ?> </label>
                                    <div class="col-lg-8">
                                        <textarea name="notes" class="form-control ta"><?php echo $i->notes; ?></textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-sm btn-<?php echo config_item('theme_color'); ?> pull-right"> <?php echo lang('save_changes'); ?></button>


                                </form>
                            </div>
                          </div>

   
<!-- end -->
