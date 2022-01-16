<?php declare(strict_types=1);
$this->db->select('*');
$this->db->from('servers');
$servers = $this->db->get()->result();
?>


<div class="box">
    <div class="box-header font-bold">
        <i class="fa fa-server"></i> <?php echo lang('servers'); ?>
        <a href="<?php echo base_url(); ?>servers/add_server" data-toggle="ajaxModal" class="btn btn-sm btn-<?php echo config_item('theme_color'); ?> pull-right"><i class="fa fa-plus"></i> <?php echo lang('add_server'); ?></a>
        </div>
                <div class="box-body">
                <?php if (isset($response)) {?>
                    <div class="alert alert-info"><?php echo $response; ?></div> 
                <?php } ?>
                <div class="table-responsive">
                <table id="table-rates" class="table table-striped b-t b-light AppendDataTables">
                    <thead>
                    <tr> 
                        <th><?php echo lang('server_name'); ?></th>
                        <th><?php echo lang('server_host'); ?></th>
                        <th><?php echo lang('port'); ?></th>
                        <th><?php echo lang('default'); ?></th>
                        <th class="col-options no-sort"><?php echo lang('options'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($servers as $key => $r) { ?>
                    <tr> 
                        <td><?php echo $r->name; ?></td>
                        <td><?php echo $r->hostname; ?></td>
                        <td><?php echo $r->port; ?></td> 
                        <td><?php echo (1 == $r->selected) ? '<i class="fa fa-check"></i>' : ''; ?></td>                       
                        <td>
                        <?php echo modules::run($r->type.'/admin_options', $r); ?> 
                        </td>
                    </tr>
                    <?php }  ?>
                    </tbody>
                </table>  
              </div>                          
        </div>
 </div>
    