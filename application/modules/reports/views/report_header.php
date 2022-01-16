              <?php if (!$this->uri->segment(3)) { ?>
              <div class="btn-group">

              <button class="btn btn-<?php echo config_item('theme_color'); ?> btn-sm"><?php echo lang('year'); ?></button>
              <button class="btn btn-<?php echo config_item('theme_color'); ?> btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span>
              </button>

              <ul class="dropdown-menu">
              <?php
                      $max = date('Y');
                      $min = $max - 3;
                      foreach (range($min, $max) as $year) { ?>
                    <li><a href="<?php echo base_url(); ?>reports?setyear=<?php echo $year; ?>"><?php echo $year; ?></a></li>
              <?php }
              ?>
                        
              </ul>

              </div>
              <?php } ?>