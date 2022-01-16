<div class="box">
   
                <div class="box-body">
  
                <div class="table-responsive">
                <?php
             $attributes = ['class' => 'bs-example form-horizontal'];
          echo form_open(base_url().'companies/import_clients', $attributes); ?>  

                <table id="table-rates" class="table table-striped b-t">
                    <thead>
                    <tr>
                        <th><?php echo lang('first_name'); ?></th> 
                        <th><?php echo lang('last_name'); ?></th> 
                        <th><?php echo lang('company_name'); ?></th>
                        <th><?php echo lang('email'); ?></th> 
                        <th><?php echo lang('address_line_1'); ?></th> 
                        <th><?php echo lang('address_line_2'); ?></th> 
                        <th><?php echo lang('city'); ?></th>
                        <th><?php echo lang('country'); ?></th> 
                        <th><?php echo lang('phone'); ?></th> 
                        <th><input type="checkbox" id="select-all" checked> <?php echo lang('select'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    $data = $this->session->userdata('import_clients') ? $this->session->userdata('import_clients') : [];
                    foreach ($data as $acc) { ?>
                    <tr>
                        <td><?php echo $acc->first_name; ?></td>
                        <td><?php echo $acc->last_name; ?></td>
                        <td><?php echo $acc->company; ?></td>
                        <td><?php echo $acc->email; ?></td> 
                        <td><?php echo $acc->address_1; ?></td>
                        <td><?php echo $acc->address_2; ?></td>
                        <td><?php echo $acc->city; ?></td>
                        <td><?php echo $acc->country; ?></td> 
                        <td><?php echo $acc->phone; ?></td> 
                        <td><input type="checkbox" name="<?php echo $acc->id; ?>" checked></td>               
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
                        <td></td>
                        <td></td>    
                        <td></td>
                        <td></td>
                        <td><button class="btn btn-success btn-block btn-sm"><?php echo lang('import'); ?></button></td>                 
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