<div class="row">
            <div class="col-md-12 col-sm-12">
              <div class="box">
                <div class="box-body">
                  <?php $version_notifications_array = Update::get_versions(); ?>
                    <table class="table table-striped">
                      <thead>
                        <tr><th>Name</th><th>Version</th><th>Date</th><th>Details</th><th>Action</th></tr>
                      </thead>
                      <tbody>
                          <?php

                          if(isset($version_notifications_array['notification_data'])) { 
                              foreach ($version_notifications_array['notification_data'] as $key => $install) { 
                              if($install['product_id'] > 1) 
                              { ?>
                                <tr><td><?=$install['product_title']?></td><td><?=$install['version_number']?></td><td><?=$install['version_date']?></td> <td><a class="btn btn-default btn-sm" href="<?=base_url()?>plugins/version/<?=$install['product_id'] ."_". $install['version_number']?>">View Information</a></td> <td><a class="btn btn-warning btn-sm" href="<?=base_url()?>plugins/install/<?=$install['product_id'] ."_". $install['version_number']?>">Install</a></td></tr>
                          <?php } } }?>
                      </tbody>
                   </table>

                </div>
              </div>
            </div>
          </div>
        