<div class="box">   
        <div class="box-body">
        <div class="table-responsive">
        <?php
        $attributes = ['class' => 'bs-example form-horizontal'];
    echo form_open(base_url().'domains/import_domains', $attributes); ?>  
    
        <div class="row">   
            <div class="form-group">
            <label class="col-sm-3 control-label"><?php echo lang('registrar'); ?></label>
            <div class="col-md-3">
            <select name="registrar" class="form-control m-b">
                    <option value=""><?php echo lang('none'); ?></option>
                    <?php

                            $registrars = Plugin::domain_registrars();
                            foreach ($registrars as $registrar) {?> 
                            <option value="<?php echo $registrar->system_name; ?>"><?php echo ucfirst($registrar->system_name); ?></option>
                            <?php } ?>

                    </select>
                </div>
            </div>
        </div>

        <table id="table-rates" class="table table-striped b-t">
            <thead>
            <tr>
                <th><?php echo lang('type'); ?></th> 
                <th><?php echo lang('domain'); ?></th> 
                <th><?php echo lang('period'); ?></th>
                <th><?php echo lang('registration'); ?> <?php echo lang('date'); ?></th> 
                <th><?php echo lang('expires'); ?></th> 
                <th><?php echo lang('status'); ?></th> 
                <th><?php echo lang('notes'); ?></th> 
                <th><input type="checkbox" id="select-all" checked> <?php echo lang('select'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php

            $data = $this->session->userdata('import_domains') ? $this->session->userdata('import_domains') : [];
            foreach ($data as $acc) { ?>
            <tr>
                <td><?php echo $acc->type; ?></td>
                <td><?php echo $acc->domain; ?></td>
                <td><?php echo $acc->period; ?></td>
                <td><?php echo $acc->registration; ?></td> 
                <td><?php echo $acc->expires; ?></td>
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