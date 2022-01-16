<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="box">
        <div class="box-header">
        <i class="fa fa-server"></i> <?php echo lang('plugins'); ?>        
        &nbsp; <a class="btn btn-xs btn-info pull-right" href="<?php echo base_url(); ?>plugins/add_plugin" data-toggle="ajaxModal"><i class="fa fa-plus"></i> <?php echo lang('upload'); ?></a>
        <a class="btn btn-xs btn-warning pull-right" href="<?php echo base_url(); ?>plugins/download"><i class="fa fa-download"></i> <?php echo lang('download_install'); ?></a> &nbsp;
           </div>
            <div class="box-body">
                <table id="table-templates-2" class="table table-striped b-t b-light text-sm AppendDataTables dataTable no-footer">
                    <thead>
                        <tr>
                            <th><?php echo lang('plugin'); ?></th>
                            <th><?php echo lang('category'); ?></th>
                            <th><?php echo lang('status'); ?></th>
                            <th><?php echo lang('uri'); ?></th>
                            <th><?php echo lang('version'); ?></th>
                            <th><?php echo lang('description'); ?></th>
                            <th><?php echo lang('author'); ?></th> 
                            <th><?php echo lang('options'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($plugins as $k => $p) { ?>
                        <tr>
                            <td><?php echo $p->name; ?></td>
                            <td><?php echo $p->category; ?></td>
                            <td><?php echo ($p->status ? 'Enabled' : 'Disabled'); ?></td>
                            <td><?php echo '<a href='.$p->uri.'" target="_blank">'.$p->uri.'</a>'; ?></td>
                            <td><?php echo $p->version; ?></td>
                            <td><?php echo $p->description; ?></td>
                            <td><?php echo '<a href="http://'.$p->author_uri.'" target="_blank">'.$p->author.'</a>'; ?></td> 
                            <td> 
                            <?php if (1 == $p->status) { ?>
                            <a class="btn btn-primary btn-sm trigger" href="<?php echo site_url('plugins/config?plugin='.$p->system_name); ?>" data-toggle="ajaxModal"><?php echo lang('settings'); ?></a> 
                            <?php } else { ?>
                                <a class="btn btn-warning btn-sm trigger" href="<?php echo site_url('plugins/uninstall/'.$p->system_name); ?>" data-toggle="ajaxModal"><?php echo lang('uninstall'); ?></a> 
                            <?php } if (0 == $p->status) { ?><a
                                class="btn btn-success btn-sm" href="<?php echo site_url('plugins/activate/'.$p->system_name); ?>">
                                <?php echo lang('activate'); ?></a><?php } else { ?>
                                <a class="btn btn-warning btn-sm" href="<?php echo site_url('plugins/deactivate/'.$p->system_name); ?>" href="<?php echo site_url('plugin/deactivate/'.$p->system_name); ?>">
                                <?php echo lang('deactivate'); ?></a><?php } ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

