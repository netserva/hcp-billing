<div class="box">
                <div class="box-header"> 
                
                <a href="<?php echo base_url(); ?>blocks/add" class="btn btn-sm btn-<?php echo config_item('theme_color'); ?> pull-right"><?php echo lang('new_block'); ?></a>
                
              </div>
              <div class="box-body">
                <div class="table-responsive">
                  <table id="table-rates" class="table table-striped b-t b-light AppendDataTables">
                    <thead>
                      <tr>
                        <th><?php echo lang('name'); ?></th>
                        <th><?php echo lang('module'); ?></th>
                        <th><?php echo lang('type'); ?></th>
                        <th><?php echo lang('section'); ?></th>
                        <th class="col-options no-sort"><?php echo lang('options'); ?></th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($blocks as $key => $row) { ?>
                      <tr>
                        <td><?php echo $row->name; ?></td>
                        <td><?php echo $row->module; ?></td>
                        <td><span class="label <?php echo ('Module' == $row->type) ? 'label-primary' : 'label-warning'; ?>"><?php echo $row->type; ?></span></td>
                        <td>
                          <?php foreach ($sections as $section) {
    if (!isset($row->param)) {
        if ($section->id == $row->id) {
            echo $section->section;
        }
    } else {
        if ($section->id == $row->param) {
            echo $section->section;
        }
    }
}
                          ?>
                        </td>
                        <td>
                          <?php $id = '';

                              $parts = $row->id;
                              $part = explode('_', $parts);
                              if ('Custom' == $row->type) {
                                  $id = strtolower($row->module).'_'.$row->id;
                              }

                              if ('Module' == $row->type && isset($row->param)) {
                                  $id = $row->param;
                              }

                              if ('Module' == $row->type && count($part) > 1 && isset($part[1]) && !is_numeric($part[1])) {
                                  $id = $row->id;
                              }

                            ?>

                          <a data-toggle="ajaxModal" class="btn btn-primary btn-sm" href="<?php echo base_url(); ?>blocks/configure/<?php echo $id; ?>"><?php echo lang('configure'); ?></a>
                          <<?php echo ('Module' == $row->type) ? 'button disabled' : 'a'; ?> class="btn btn-warning btn-sm" href="<?php echo base_url(); ?>blocks/edit/<?php echo $row->id; ?>" title="<?php echo lang('edit'); ?>"><?php echo lang('edit'); ?><?php echo ('Module' == $row->type) ? '</button>' : '</a>'; ?>
                          <<?php echo ('Module' == $row->type) ? 'button disabled' : 'a'; ?> data-toggle="ajaxModal" class="btn btn-danger btn-sm" href="<?php echo base_url(); ?>blocks/delete/<?php echo $row->id; ?>" title="<?php echo lang('delete'); ?>"><?php echo lang('delete'); ?><?php echo ('Module' == $row->type) ? '</button>' : '</a>'; ?>
                        </td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
           </div>
      </div>
              
<!-- end -->