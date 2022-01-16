<div class="row">
            <div class="col-md-12 col-sm-12">
              <div class="box">
 
                <div class="box-body">
                  <?php 

                      if ($version_notifications_array['notification_case']=="notification_operation_ok") //'notification_operation_ok' case returned - operation succeeded
                      {
                      $demo_page_message=$version_notifications_array['notification_data']['product_title']."<br><br><b>Version</b>: ".$version_notifications_array['notification_data']['version_number']."<br><b>Release date</b>: ".$version_notifications_array['notification_data']['version_date'];
                      $demo_page_class="alert alert-success";
                      }
                      else //Other case returned - operation failed
                      {
                      $demo_page_message="Version $version_number information could not be retrieved: ".$version_notifications_array['notification_text'];
                      $demo_page_class="alert alert-danger";
                      }
                      
                    ?>

                    <div class="<?php echo $demo_page_class; ?>" role="alert"><strong><?php echo $demo_page_message; ?></strong></div>

                    <?php if(isset($version_notifications_array['notification_data']) && isset($version_notifications_array['notification_data']['version_changelog'])) { 

                      echo $version_notifications_array['notification_data']['version_changelog'];
                  
                    ?>

                    <hr>
 
                    <a class="btn btn-warning" href="<?=base_url()?>updates">Back</a>  
                     <a class="btn btn-success" href="<?=base_url()?>updates/install/<?=$version?>">Install</a>
                   <?php } ?>
 

                </div>
              </div>
            </div>
          </div>
        