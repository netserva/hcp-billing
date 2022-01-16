	<div class="box">
                <div class="box-header"> 
                
                <a href="<?php echo base_url(); ?>sliders/add_slide/<?php echo $slider_id; ?>" data-toggle="ajaxModal" class="btn btn-sm btn-<?php echo config_item('theme_color'); ?> pull-right"><?php echo lang('new_slide'); ?></a>
                
              </div>
              <div class="box-body">
                <div class="table-responsive">
                  <table id="table-rates" class="table table-striped b-t b-light AppendDataTables">
                    <thead>
                      <tr>
                        <th><?php echo lang('image'); ?></th>
                        <th><?php echo lang('title'); ?></th>
                        <th><?php echo lang('description'); ?></th>
                        <th class="col-options no-sort"><?php echo lang('options'); ?></th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($slider as $key => $row) { ?>
                      <tr>
                        <td>
                        <?php if (!empty($row->image)) {?>
                        <img src="<?php echo base_url(); ?>resource/uploads/<?php echo $row->image; ?>" class="list_thumb" />
                        <?php } ?>
                        </td>
                        <td><?php echo $row->title; ?></td>
                        <td><?php echo $row->description; ?></td>
                        <td>
                        <a class="btn btn-warning btn-sm" href="<?php echo base_url(); ?>sliders/edit_slide/<?php echo $row->slide_id; ?>" data-toggle="ajaxModal" title="<?php echo lang('edit_slide'); ?>"><?php echo lang('edit_slide'); ?></a>
                        <a class="btn btn-danger btn-sm" href="<?php echo base_url(); ?>sliders/delete_slide/<?php echo $row->slide_id; ?>" data-toggle="ajaxModal" title="<?php echo lang('delete_slide'); ?>"><?php echo lang('delete_slide'); ?></a>
                        </td>
                      </tr>
                      <?php }  ?>
                    </tbody>
                  </table>
                </div>
           </div>
      </div>
              
<!-- end -->