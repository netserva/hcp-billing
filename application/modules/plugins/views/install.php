<div class="row">
            <div class="col-md-12 col-sm-12">
              <div class="box">
 
                <div class="box-body">
                  <?php 

                        if ($version_notifications_array['notification_case']=="notification_operation_ok")  
                        {
                        $demo_page_message=$version_notifications_array['notification_data']['product_title']." <b>Version</b>: ".$version_notifications_array['notification_data']['version_number']."<br><b>Release date</b>: ".$version_notifications_array['notification_data']['version_date'];
                        $demo_page_class="alert alert-success";
                        }
                        else  
                        {
                        $demo_page_message="Version data could not be processed: ".$version_notifications_array['notification_text'];
                        $demo_page_class="alert alert-danger";
                        }

                        ?>

                        <div class="<?php echo $demo_page_class; ?>" role="alert"><strong><?php echo $demo_page_message; ?></strong>                     

                      </div>


                      <?php if(isset($version_notifications_array['notification_data']) && isset($version_notifications_array['notification_data']['version_changelog'])) { ?>

                      <h4>Downloading and Installing</h4>
                      <div class="progress">
                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%"></div>
                      </div>
                      <h4>Completed!</h4>
                      <br>

                      <?php
                      echo "<p>" . $version_notifications_array['notification_data']['version_changelog'] . "</p>";
                      echo "<p>" . $status . "</p>";
                      } ?>

                      
                    <br />
                    <a class="btn btn-default" href="<?=base_url()?>plugins/installed"><?=lang('continue')?></a>            

                </div>
              </div>
            </div>
          </div>
        