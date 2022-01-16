<div class="box">
    <div class="box-header font-bold">
        <i class="fa fa-flag"></i> <?php echo lang('promotions'); ?>
        <a href="<?php echo base_url(); ?>promotions/add_promotion" data-toggle="ajaxModal" class="btn btn-sm btn-<?php echo config_item('theme_color'); ?> pull-right"><i class="fa fa-plus"></i> <?php echo lang('add_promotion'); ?></a>
        </div>
                <div class="box-body">
                <?php if (isset($response)) {?>
                    <div class="alert alert-info"><?php echo $response; ?></div> 
                <?php } ?>
                <div class="table-responsive">
                <table id="table-rates" class="table table-striped b-t b-light AppendDataTables">
                    <thead>
                    <tr>
                        <th><?php echo lang('code'); ?></th>
                        <th><?php echo lang('value'); ?></th>
                        <th><?php echo lang('type'); ?></th>
                        <th><?php echo lang('start_date'); ?></th>
                        <th><?php echo lang('end_date'); ?></th>
                        <th><?php echo lang('use_date'); ?></th>
                        <th><?php echo lang('description'); ?></th>
                        <th><?php echo lang('action'); ?></th>
                    </tr>
                    </thead>
                    <tbody> 
                    <?php foreach ($promotions as $promo) { ?>
                          <tr>
                            <td><?php echo $promo->code; ?></td>
                            <td><?php echo $promo->value; ?></td>
                            <td><?php echo (1 == $promo->type) ? lang('amount') : lang('percentage'); ?></td>
                            <td><?php echo $promo->start_date; ?></td>
                            <td><?php echo $promo->end_date; ?></td>
                            <td><?php echo (1 == $promo->use_date) ? lang('yes') : lang('no'); ?></td>
                            <td><?php echo $promo->description; ?></td>
                            <th><a href="<?php echo base_url(); ?>promotions/edit/<?php echo $promo->id; ?>" class="btn btn-primary btn-xs" data-toggle="ajaxModal">
                                <i class="fa fa-edit"></i> <?php echo lang('edit'); ?></a>
                                <a href="<?php echo base_url(); ?>promotions/delete/<?php echo $promo->id; ?>" class="btn btn-danger btn-xs" data-toggle="ajaxModal">
                                <i class="fa fa-trash-o"></i> <?php echo lang('delete'); ?></a>
                            </th>
                        </tr>
                   <?php } ?>                   
                    </tbody>
                </table>  
              </div>                          
        </div>
 </div>
    

<script type="text/javascript">
 $(document).delegate(".datepicker-input", "focusin", function () {
            
            $(this).datepicker().css('z-index','1600');
        });
</script>