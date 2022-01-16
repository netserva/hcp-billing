	<div class="box">
                <div class="box-header"> 
                
                <a href="<?php echo base_url(); ?>sliders/add" data-toggle="ajaxModal" class="btn btn-sm btn-<?php echo config_item('theme_color'); ?> pull-right"><?php echo lang('new_slider'); ?></a>
                
              </div>
              <div class="box-body">
                <div class="table-responsive">
                  <table id="table-rates" class="table table-striped b-t b-light AppendDataTables">
                    <thead>
                      <tr>
                        <th><?php echo lang('name'); ?></th>
                        <th><?php echo lang('slides'); ?></th>
                        <th class="col-options no-sort"><?php echo lang('options'); ?></th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($sliders as $key => $row) { ?>
                      <tr>
                        <td><?php echo $row->name; ?></td>
                        <td><?php echo $row->slides; ?></td>
                        
                        <td>
                        <a class="btn btn-<?php echo config_item('theme_color'); ?> btn-sm" href="<?php echo base_url(); ?>sliders/slider/<?php echo $row->slider_id; ?>"><?php echo lang('manage_slides'); ?></a>
                        <a class="btn btn-warning btn-sm" href="<?php echo base_url(); ?>sliders/edit/<?php echo $row->slider_id; ?>" data-toggle="ajaxModal" title="<?php echo lang('edit_slider'); ?>"><?php echo lang('edit_slider'); ?></a>
                        <a class="btn btn-danger btn-sm" href="<?php echo base_url(); ?>sliders/delete/<?php echo $row->slider_id; ?>" data-toggle="ajaxModal" title="<?php echo lang('delete_slider'); ?>"><?php echo lang('delete_slider'); ?></a>
                        </td>
                      </tr>
                      <?php }  ?>
                    </tbody>
                  </table>
                </div>
           </div>
      </div>
              
<!-- end -->