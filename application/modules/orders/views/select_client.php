<div class="box box-solid box-default">
    <header class="box-header "><?php echo lang('new_order'); ?></header>
    <div class="box-body inner">
        <div class="row">
            <div class="col-sm-6">
                <?php
             $attributes = ['class' => 'bs-example form-horizontal'];
          echo form_open(base_url().'orders/select_client', $attributes); ?>
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 w_300">
                            <select class="select2-option w_280" id="modal_client" name="co_id" required> 
                                <option value="" selected>Select</option>
                                <?php foreach (Client::get_all_clients() as $client) { ?>
                                <option value="<?php echo $client->co_id; ?>"><?php echo ucfirst($client->company_name); ?></option>
                                <?php }  ?>
                            </select>
                        </div>
                        <div class="col-md-1">
                        <button type="submit" class="btn btn-success pull-right"><?php echo lang('continue'); ?></button>
                        </div>
                        <div class="col-md-1">
                            <a href="<?php echo base_url(); ?>companies/create" class="btn btn-default btn-sm"
                                data-toggle="ajaxModal" title="<?php echo lang('new_company'); ?>" data-placement="bottom"><i
                                    class="fa fa-plus"></i> <?php echo lang('new_client'); ?></a>
                        </div>
                    </div>
                </div>
            </div>
           
        </div>
    </div>
</div>
 