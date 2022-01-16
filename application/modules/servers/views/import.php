<div class="box">
   
                <div class="box-body">

                <?php if ($this->session->flashdata('message')) { ?>
                    <div class="alert alert-info alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $this->session->flashdata('message'); ?>
                    </div>
                <?php } ?>


                <?php
                    if (!is_array($data)) {
                        echo $data;
                    }
                 ?>

                <div class="table-responsive">
                <?php
             $attributes = ['class' => 'bs-example form-horizontal'];
          echo form_open(base_url().'servers/import/'.$id, $attributes); ?>
                <table id="table-rates" class="table table-striped">
                    <thead>
                    <tr>
                        <th><?php echo lang('domain'); ?></th> 
                        <th><?php echo lang('username'); ?></th> 
                        <td><?php echo lang('email'); ?></td>
                        <td><?php echo lang('client'); ?></td>
                        <td><?php echo lang('package_name'); ?></td>
                        <td><?php echo lang('package'); ?></td>
                        <td><?php echo lang('server'); ?></td>
                        <td><?php echo lang('import'); ?></td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    $data = (is_array($data)) ? $data : [];
                    foreach ($data as $acc) { ?>
                    <tr>
                        <td><?php echo $acc['domain']; ?></td>
                        <td><?php echo (isset($acc['user'])) ? $acc['user'] : ''; ?></td>
                        <td><?php echo $acc['email']; ?></td>
                        <td><?php echo (isset($acc['client'])) ? $acc['client'] : '<span class="label label-default">'.lang('will_create'); ?></span></td>
                        <td><?php echo $acc['plan']; ?></td>
                        <td><?php echo (isset($acc['package'])) ? $acc['package'] : lang('not_found'); ?></td>    
                        <td><?php echo (isset($acc['server'])) ? $acc['server'] : ''; ?></td>
                        <td><?php echo (isset($acc['import']) && 1 == $acc['import']) ? '<input type="checkbox" checked name="'.$acc['domain'].'"' : ''; ?></td>                 
                    </tr>
                    <?php }  ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>    
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><button class="btn btn-success btn-sm btn-block"><?php echo lang('import'); ?></button></td>                 
                    </tr>
                    </tbody>
                </table>  
                </form>
              </div>                          
        </div>
 </div>
    