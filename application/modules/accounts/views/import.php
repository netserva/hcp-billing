<div class="box">   
        <div class="box-body">
        <div class="table-responsive">
        <?php
        $attributes = ['class' => 'bs-example form-horizontal'];
        echo form_open(base_url().'accounts/import_accounts', $attributes); ?>      
   
        <table id="table-rates" class="table table-striped b-t">
            <thead>
            <tr>
                <th><?php echo lang('domain'); ?></th> 
                <th><?php echo lang('username'); ?></th> 
                <th><?php echo lang('billed'); ?></th> 
                <th><?php echo lang('package'); ?></th>
                <th><?php echo lang('next_renewal'); ?></th> 
                <th><?php echo lang('status'); ?></th>
                <th><?php echo lang('notes'); ?></th> 
                <th><input type="checkbox" id="select-all" checked> <?php echo lang('select'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php

            $data = $this->session->userdata('import_accounts') ? $this->session->userdata('import_accounts') : [];
            $services = Item::get_hosting();

            foreach ($data as $acc) { ?>
            <tr>
                <td><?php echo $acc->domain; ?></td>
                <td><?php echo $acc->username; ?></td>
                <td><?php echo $acc->renewal; ?></td>
                <td><select name="package[<?php echo $acc->id; ?>]">
                <option value="0"><?php echo lang('select'); ?></option>
                    <?php foreach ($services as $service) { ?>
                        <option value="<?php echo $service->item_id; ?>" 
                        <?php $interval = strtolower(str_replace('_', '', $acc->renewal));
                        if (isset($service->{$interval})) {
                            if ($acc->recurring_amount == intval($service->{$interval})) {
                                echo 'selected';
                            }
                        }

                        ?>

                        ><?php echo $service->item_name; ?></option>
                     <?php } ?>
                     </select>
                </td> 
                <td><?php echo $acc->due_date; ?></td>
                <td><?php echo $acc->status; ?></td>
                <td><?php echo $acc->notes; ?></td>  
                <td><input type="checkbox" checked name="<?php echo $acc->id; ?>"></td>               
            </tr>
            <?php }  ?>
            
            </tbody>
            <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>    
                <td></td>
                <td></td>
                <td><button class="btn btn-success btn-block btn-sm"><?php echo lang('import'); ?></button></td> 
                <td></td>  
                <td></td>                               
            </tr>
            </tfoot>
        </table>  
        </form>
        </div>                          
    </div>
</div>
    

<script>
$(document).ready(function() {
    $('#select-all').click(function() {
        var checked = this.checked;
        $('input[type="checkbox"]').each(function() {
        this.checked = checked;
    });
    })
});
</script>