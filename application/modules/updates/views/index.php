          <div class="row">
            <div class="col-md-12 col-sm-12">
              <div class="box">
                <div class="box-body">
                  <?php
                          $version_notifications_array = Update::get_versions();

                      if ('notification_operation_ok' == $version_notifications_array['notification_case']) { //'notification_operation_ok' case returned - operation succeeded
                          $demo_page_message = 'Version: '.config_item('version').'';
                          $demo_page_class = 'alert alert-success';
                      } else { //Other case returned - operation failed
                          $demo_page_message = 'No data to display: '.$version_notifications_array['notification_text'];
                          $demo_page_class = 'alert alert-danger';
                      }

                    ?>

                    <div class="<?php echo $demo_page_class; ?>" role="alert"><strong><?php echo $demo_page_message; ?></strong></div>

                    <table class="table table-striped">
                      <thead>
                        <tr><th>Name</th><th>Version</th><th>Date</th><th>Details</th><th>Action</th></tr>
                      </thead>
                      <tbody>
                          <?php

                          if (isset($version_notifications_array['notification_data'])) {
                              foreach ($version_notifications_array['notification_data'] as $key => $update) {
                                  if (1 == $update['product_id'] && $update['version_number'] > config_item('version')) { ?>
                               <tr><td><?php echo $update['product_title']; ?></td><td><?php echo $update['version_number']; ?></td><td><?php echo $update['version_date']; ?></td> <td><a class="btn btn-default btn-sm" href="<?php echo base_url(); ?>updates/version/<?php echo $update['product_id'].'_'.$update['version_number']; ?>">View Information</a></td> <td><a class="btn btn-success btn-sm" href="<?php echo base_url(); ?>updates/install/<?php echo $update['product_id'].'_'.$update['version_number']; ?>">Install</a></td></tr>
                                <?php break; }
                              }
                              foreach ($version_notifications_array['notification_data'] as $key => $update) {
                                  if ($update['product_id'] > 1) {
                                      foreach ($plugins as $plugin) {
                                          if (trim($plugin->system_name) == trim($update['product_sku']) && $update['version_number'] > $plugin->version) { ?>
                                <tr><td><?php echo $update['product_title']; ?></td><td><?php echo $update['version_number']; ?></td><td><?php echo $update['version_date']; ?></td> <td><a class="btn btn-default btn-sm" href="<?php echo base_url(); ?>updates/version/<?php echo $update['product_id'].'_'.$update['version_number']; ?>">View Information</a></td> <td><a class="btn btn-warning btn-sm" href="<?php echo base_url(); ?>updates/install/<?php echo $update['product_id'].'_'.$update['version_number']; ?>">Install</a></td></tr>
                          <?php }
                                      }
                                  }
                              }
                          }?>
                      </tbody>
                   </table>

                </div>
              </div>
            </div>
          </div>
        