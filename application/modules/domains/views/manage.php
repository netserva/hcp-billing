<?php declare(strict_types=1);
$account = $this->db->where('id', $id)->get('orders')->row();

$this->db->select('items_saved.*');
$this->db->join('item_pricing', 'items_saved.item_id = item_pricing.item_id', 'INNER');
$this->db->join('categories', 'categories.id = item_pricing.category', 'LEFT');
$this->db->where('parent >', 8);
$packages = $this->db->get('items_saved')->result();
?>
 <div class="box"> 	
<div class="box-body">

        <div class="row">
        <div class="col-md-8">
            <div class="box-body">

             <section class="panel panel-default bg-white m-t-lg radius_3">
                    <header class="panel-heading text-center">			 
                    <h3><?php echo lang('manage').' '.lang('account'); ?></h3>		 	
                    </header> 
                        
                    <div class="panel-body">
                    <div class="box-body">
                    <?php
                        $attributes = ['class' => 'bs-example form-horizontal'];
                    echo form_open(base_url().'domains/manage', $attributes); ?> 
                    <input type="hidden" value="<?php echo $id; ?>" name="id">

                            <div class="row">
                                <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label"><?php echo lang('client'); ?></label>
                                            <div class="col-lg-8">
                                            <select class="select2-option w_200" name="client_id" > 
                                                        <?php foreach (Client::get_all_clients() as $client) { ?>                                                      
                                                            <option value="<?php echo $client->co_id; ?>" <?php echo ($account->client_id == $client->co_id) ? 'selected' : ''; ?>><?php echo ucfirst($client->company_name); ?></option>
                                                        <?php }  ?> 
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-4 control-label"><?php echo lang('status'); ?></label>
                                            <div class="col-lg-8">
                                                <select name="status_id" class="select2-option w_200">   
                                                    <option value="5" <?php echo (5 == $account->status_id) ? 'selected' : ''; ?>><?php echo lang('pending'); ?></option>
                                                    <option value="6" <?php echo (6 == $account->status_id) ? 'selected' : ''; ?>><?php echo lang('active'); ?></option>
                                                    <option value="7" <?php echo (7 == $account->status_id) ? 'selected' : ''; ?>><?php echo lang('cancelled'); ?></option>
                                                    <option value="9" <?php echo (9 == $account->status_id) ? 'selected' : ''; ?>><?php echo lang('suspended'); ?></option>
                                                </select> 
                                            </div>
                                        </div>

                             

                                        <div class="form-group">
                                            <label class="col-lg-4 control-label"><?php echo lang('registrar'); ?></label>
                                            <div class="col-lg-8">
                                                <select class="form-control" name="registrar">
                                                <option value="">None</option> 
                                                    <?php $registrars = Plugin::domain_registrars();
                                                        foreach ($registrars as $registrar) {?> 
                                                        <option value="<?php echo $registrar->system_name; ?>"><?php echo ucfirst($registrar->system_name); ?></option>
                                                        <?php } ?>   
                                                </select>
                                            </div>
                                        </div>                                      
                                </div>


                                <div class="col-md-6">

                                <div class="form-group">
                                        <label class="col-lg-4 control-label"><?php echo lang('created'); ?></label>
                                        <div class="col-lg-8">
                                            <input class="input-sm input-s datepicker form-control" size="16" type="text" value="<?php echo $account->date; ?>" name="date" data-date-format="<?php echo config_item('date_picker_format'); ?>" >
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-4 control-label"><?php echo lang('next_due_date'); ?></label>
                                        <div class="col-lg-8">
                                            <input class="input-sm input-s datepicker form-control" size="16" type="text" value="<?php echo $account->renewal_date; ?>" name="renewal_date" data-date-format="<?php echo config_item('date_picker_format'); ?>" >
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label"><?php echo lang('domain'); ?></label>
                                        <div class="col-lg-8">
                                            <input class="input form-control" type="text" value="<?php echo $account->domain; ?>" name="domain">
                                        </div>
                                    </div>  

                                    <div class="form-group">
                                        <label class="col-lg-4 control-label"><?php echo lang('authcode'); ?></label>
                                        <div class="col-lg-8">
                                            <input class="input form-control" type="text" value="<?php echo $account->authcode; ?>" name="authcode">
                                        </div>
                                    </div> 

                                </div> 
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label"><?php echo lang('notes'); ?></label>
                                <div class="col-lg-10">
                                    <input class="input form-control" type="text" value="<?php echo $account->notes; ?>" name="notes">
                                </div>
                            </div> 


                            <div class="form-group">
                                <label class="col-lg-4 control-label"> </label>
                                <div class="col-lg-8">
                                    <input class="btn btn-primary pull-right" type="submit" value="<?php echo lang('save'); ?>">
                                </div>
                            </div> 


                    </form>
                </div>
                </div>
            </section>

         </div>
        </div>
	</div>

</div>
</div> 
