	<div class="box">
                <div class="box-header"> 
                
                <a href="<?php echo base_url(); ?>invoices/tax_rates/add" data-toggle="ajaxModal" class="btn btn-sm btn-<?php echo config_item('theme_color'); ?> pull-right"><?php echo lang('new_tax_rate'); ?></a>
                
              </div>
              <div class="box-body">
                <div class="table-responsive">
                  <table id="table-rates" class="table table-striped b-t b-light AppendDataTables">
                    <thead>
                      <tr>
                        <th><?php echo lang('tax_rate_name'); ?></th>
                        <th><?php echo lang('tax_rate_percent'); ?></th>
                        <th class="col-options no-sort"><?php echo lang('options'); ?></th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($rates as $key => $r) { ?>
                      <tr>
                        <td><?php echo $r->tax_rate_name; ?></td>
                        <td><?php echo $r->tax_rate_percent; ?> %</td>
                        
                        <td>
                        <a class="btn btn-<?php echo config_item('theme_color'); ?> btn-sm" href="<?php echo base_url(); ?>invoices/tax_rates/edit/<?php echo $r->tax_rate_id; ?>" data-toggle="ajaxModal" title="<?php echo lang('edit_rate'); ?>"><?php echo lang('edit_rate'); ?></a>
                <a class="btn btn-dark btn-sm" href="<?php echo base_url(); ?>invoices/tax_rates/delete/<?php echo $r->tax_rate_id; ?>" data-toggle="ajaxModal" title="<?php echo lang('delete_rate'); ?>"><?php echo lang('delete_rate'); ?></a>
                        </td>
                      </tr>
                      <?php }  ?>
                    </tbody>
                  </table>
                </div>
           </div>
      </div>
              
<!-- end -->