<?php declare(strict_types=1);

$company = Client::view_by_id($company);
$email = $company->company_email;

                $attributes = ['class' => 'bs-example form-horizontal'];
                echo form_open(base_url().'companies/send_email', $attributes); ?>
                    <div class="modal-body">

                        <div class="form-group">
                            <label class="col-lg-2 control-label"><?php echo lang('email'); ?> <span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="email" value="<?php echo $email; ?>" required>
                            </div>
                        </div>

                        
                        <div class="form-group">
                            <label class="col-lg-2 control-label">CC</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="cc">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-lg-2 control-label"><?php echo lang('subject'); ?> <span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="subject" required>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-lg-2 control-label"><?php echo lang('message'); ?> <span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <textarea class="form-control foeditor" rows="10" name="message" required></textarea>
                            </div>
                        </div>

                       
                    </div>
                    <div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a>
                        <button type="submit" class="btn btn-success"><?php echo lang('send'); ?></button>
                    </div>
                </form>