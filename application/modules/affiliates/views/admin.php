 			<div class="box">
 			    <div class="box-header b-b b-light">
 			        <a href="#aside" data-toggle="class:show"
 			            class="btn btn-sm btn-<?php echo config_item('theme_color'); ?> pull-right"><i class="fa fa-plus"></i>
 			            <?php echo lang('settings'); ?></a>
 			    </div>
 			    <div class="box-body">

 			        <div class="hide" id="aside">
 			            <div class="row">

 			                <div class="col-md-4">
 			                    <?php
                                  $attributes = ['class' => 'bs-example form-horizontal'];
                                            echo form_open(base_url().'affiliates/config', $attributes); ?>
 			                    <p class="text-danger"><?php echo $this->session->flashdata('form_errors'); ?></p>

 			                    <div class="form-group">
 			                        <label class="col-md-12"><?php echo lang('affiliates_active'); ?></label>
 			                        <label class="switch">
 			                            <input type="hidden" value="off" name="affiliates" />
 			                            <input type="checkbox"
 			                                <?php if ('TRUE' == config_item('affiliates')) {
                                                echo 'checked="checked"';
                                            } ?>
 			                                name="affiliates">
 			                            <span></span>
 			                        </label>
 			                    </div>

 			                    <div class="form-group">
 			                        <label class="col-md-6"><?php echo lang('activation_bonus'); ?></label>
 			                        <div class="col-lg-4">
 			                            <input type="text" name="affiliates_bonus" value="<?php echo config_item('affiliates_bonus'); ?>"
 			                                class="input-sm form-control" required>
 			                        </div>
 			                    </div>

 			                    <div class="form-group">
 			                        <label class="col-md-6"><?php echo lang('default_percentage'); ?></label>
 			                        <div class="col-lg-4">
 			                            <div class="input-group">
 			                                <input type="text" name="affiliates_percentage"
 			                                    value="<?php echo config_item('affiliates_percentage'); ?>" class="input-sm form-control"
 			                                    required>
 			                                <span class="input-group-addon">%</span>
 			                            </div>
 			                        </div>
 			                    </div>

 			                    <div class="form-group">
 			                        <label class="col-md-6"><?php echo lang('minimun_payout'); ?></label>
 			                        <div class="col-lg-4">
 			                            <input type="text" name="affiliates_payout"
 			                                value="<?php echo config_item('affiliates_payout'); ?>" class="input-sm form-control"
 			                                required>
 			                        </div>
 			                    </div>


 			                    <div class="form-group">
 			                        <label class="col-md-6"><?php echo lang('affiliates_commission'); ?></label>
 			                        <div class="col-lg-4">
 			                            <select name="affiliates_commission" class="form-control m-b">
 			                                <option value="recurring"
 			                                    <?php echo ('recurring' == config_item('affiliates_commission')) ? 'selected' : ''; ?>>
 			                                    <?php echo lang('recurring'); ?></option>
 			                                <option value="once"
 			                                    <?php echo ('once' == config_item('affiliates_commission')) ? 'selected' : ''; ?>>
 			                                    <?php echo lang('once_off'); ?></option>
 			                            </select>
 			                        </div>
 			                    </div>
 			                </div>

 			                <div class="col-md-8">
 			                    <div class="form-group">
 			                        <label class="col-md-12"><?php echo lang('affiliates_links'); ?></label>
 			                        <div class="col-lg-12">
 			                            <textarea class="col-lg-12 input-sm form-control" rows="12"
 			                                name="affiliates_links"><?php echo config_item('affiliates_links'); ?></textarea>
 			                        </div>
 			                    </div>
 			                </div>


 			            </div>
 			            <button class="btn btn-success"><?php echo lang('save_settings'); ?></button>
 			            <hr>
 			        </div>
 			        </form>
 			    </div>


 			    <div class="table-responsive">
 			        <table id="table-users" class="table table-striped m-b-none AppendDataTables">
 			            <thead>
 			                <tr>
 			                    <th><?php echo lang('name'); ?></th>
 			                    <th><?php echo lang('clicks'); ?></th>
 			                    <th><?php echo lang('signups'); ?></th>
 			                    <th><?php echo lang('balance'); ?></th>
 			                    <th class="col-options no-sort"><?php echo lang('options'); ?></th>
 			                </tr>
 			            </thead>
 			            <tbody>
 			                <?php $affiliates = Affiliate::all();
                             foreach ($affiliates as $affiliate) { ?>
 			                <tr>
 			                    <td><?php echo $affiliate->company_name; ?></td>
 			                    <td><?php echo $affiliate->affiliate_clicks; ?></td>
 			                    <td><?php echo $affiliate->affiliate_signups; ?></td>
 			                    <td><?php echo $affiliate->affiliate_balance; ?></td>
 			                    <td class="col-options no-sort">									
									<a href="<?php echo base_url(); ?>affiliates/change_balance/<?php echo $affiliate->affiliate_id; ?>" data-toggle="ajaxModal" class="btn btn-xs btn-warning"><?php echo lang('change_balance'); ?></a> 
									<a href="<?php echo base_url(); ?>affiliates/view_signups/<?php echo $affiliate->affiliate_id; ?>" data-toggle="ajaxModal" class="btn btn-xs btn-success"><?php echo lang('view_signups'); ?></a> 
									<a href="<?php echo base_url(); ?>affiliates/payout_history/<?php echo $affiliate->affiliate_id; ?>" data-toggle="ajaxModal" class="btn btn-xs btn-info"><?php echo lang('payout_history'); ?></a>
									<a href="<?php echo base_url(); ?>affiliates/pay_withdrawal/<?php echo $affiliate->affiliate_id; ?>" data-toggle="ajaxModal" class="btn btn-xs btn-danger"><?php echo lang('pay_withdrawal'); ?></a> 
								</td>
 			                </tr>
 			                <?php } ?>
 			            </tbody>
 			        </table>
 			    </div>
 			</div>