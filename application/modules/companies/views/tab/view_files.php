    <div class="box-body">
        <h4 class="subheader text-muted h3"><?php echo lang('files'); ?>

        <a href="<?php echo base_url(); ?>companies/file/add/<?php echo $i->co_id; ?>" class="btn btn-<?php echo config_item('theme_color'); ?> btn-xs pull-right" data-toggle="ajaxModal" data-placement="left" title="<?php echo lang('upload_file'); ?>">
            <i class="fa fa-plus-circle"></i> <?php echo lang('upload_file'); ?></a>
        </h4>

        <ul class="list-unstyled p-files">
        <?php $this->load->helper('file');
          foreach (Client::has_files($i->co_id) as $key => $f) {
              $icon = $this->applib->file_icon($f->ext);
              $real_url = base_url().'resource/uploads/'.$f->file_name; ?>
            <div class="line"></div>
                <li>
                  <?php if (1 == $f->is_image) { ?>
                      <?php if ($f->image_width > $f->image_height) {
                  $ratio = round(((($f->image_width - $f->image_height) / 2) / $f->image_width) * 100);
                  $style = 'height:100%; margin-left: -'.$ratio.'%';
              } else {
                  $ratio = round(((($f->image_height - $f->image_width) / 2) / $f->image_height) * 100);
                  $style = 'width:100%; margin-top: -'.$ratio.'%';
              }  ?>
        <div class="file-icon icon-small">
            <a href="<?php echo base_url(); ?>companies/file/<?php echo $f->file_id; ?>"><img style="<?php echo $style; ?>" src="<?php echo $real_url; ?>" /></a>
        </div>
        <?php } else { ?>
        <div class="file-icon icon-small"><i class="fa <?php echo $icon; ?> fa-lg"></i></div>
        <?php } ?>

        <a data-toggle="tooltip" data-placement="right" data-original-title="<?php echo $f->description; ?>" class="text-muted" href="<?php echo base_url(); ?>companies/file/<?php echo $f->file_id; ?>">
                      <?php echo (empty($f->title) ? $f->file_name : $f->title); ?>
        </a>

        <div class="pull-right">

        <a href="<?php echo base_url(); ?>companies/file/delete/<?php echo $f->file_id; ?>" data-toggle="ajaxModal"><i class="fa fa-trash-o text-danger"></i>
        </a>

        </div>

        </li>


                <?php
          } ?>
            </ul>
 
</div>
<!-- End File section -->
