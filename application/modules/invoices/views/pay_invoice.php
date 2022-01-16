
            <div class="box">
                <?php $inv = Invoice::view_by_id($id); ?>
                <div class="box-header b-b clearfix hidden-print">
       
                            <div class="btn-group pull-right">
              
                            <a href="<?php echo site_url(); ?>invoices/view/<?php echo $inv->inv_id; ?>" class="btn btn-sm btn-success">
                                <?php echo lang('view_invoice'); ?>
                            </a>                     
 
                                <a href="<?php echo base_url(); ?>fopdf/invoice/<?php echo $inv->inv_id; ?>" class="btn btn-sm btn-primary pull-right">
                                <i class="fa fa-file-pdf-o"></i> <?php echo lang('pdf'); ?> 
                            </a>

                            </div> 

                            </div>
                            <div class="box-body">
                                <?php
                                $attributes = ['class' => 'bs-example form-horizontal'];
                                echo form_open_multipart(base_url().'invoices/pay', $attributes);
                                $cur = App::currencies(config_item('default_currency'));
                                ?>

                                <input type="hidden" name="invoice" value="<?php echo $id; ?>">
                                <input type="hidden" name="currency" value="<?php echo $cur->code; ?>">

                                <div class="form-group">
                                    <label class="col-lg-3 control-label"><?php echo lang('trans_id'); ?> <span class="text-danger">*</span></label>
                                    <div class="col-lg-8">
                                        <?php $this->load->helper('string'); ?>
                                        <input type="text" class="form-control" value="<?php echo random_string('nozero', 6); ?>" name="trans_id" readonly>
                                    </div>
                                </div>
                                <div class="form-group">

                                        <label class="col-lg-3 control-label"><?php echo lang('amount'); ?> (<?php echo $cur->symbol; ?>)
                                        <span class="text-danger">*</span></label>
                                                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" value="<?php echo Applib::format_deci(Invoice::get_invoice_due_amount($id)); ?>" name="amount">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label"><?php echo lang('payment_date'); ?></label>
                                    <div class="col-lg-8">
                                        <input class="input-sm input-s datepicker-input form-control" size="16" type="text" value="<?php echo strftime(config_item('date_format'), time()); ?>" name="payment_date" data-date-format="<?php echo config_item('date_picker_format'); ?>" >
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label"><?php echo lang('payment_method'); ?> <span class="text-danger">*</span></label>
                                    <div class="col-lg-8">
                                        <select name="payment_method" class="form-control">
                                            <?php
                                            foreach (Invoice::payment_methods() as $key => $m) { ?>
                                                <option value="<?php echo $m->method_id; ?>"><?php echo $m->method_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label"><?php echo lang('notes'); ?></label>
                                    <div class="col-lg-8">
                                        <textarea name="notes" class="form-control ta"></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label"><?php echo lang('payment_slip'); ?></label>
                                    <div class="col-lg-3">
                                        <label class="switch">
                                            <input type="hidden" value="off" name="attach_slip" />
                                            <input type="checkbox" name="attach_slip" id="attach_slip">
                                            <span></span>
                                        </label>
                                    </div>
                                </div>

                                <div id="attach_field" style="display:none;">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label"><?php echo lang('attach_file'); ?></label>

                                        <div class="col-lg-3">
                                            <input type="file" class="filestyle" data-buttonText="<?php echo lang('choose_file'); ?>" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline input-s" name="payment_slip">
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label"><?php echo lang('send_email'); ?></label>
                                    <div class="col-lg-8">
                                        <label class="switch">
                                            <input type="checkbox" name="send_thank_you">
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="modal-footer"> <a href="<?php echo base_url(); ?>invoices/view/<?php echo $id; ?>" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a>
                                    <button type="submit" class="btn btn-<?php echo config_item('theme_color'); ?>"><?php echo lang('add_payment'); ?></button>
                                    </form>

                                </div> 
                    </div> 
 
 
<!-- end -->
