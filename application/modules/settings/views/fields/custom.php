<style>
  * {
    box-sizing: border-box;
  }

  .fb-main {
    min-height: 600px;
  }

  input[type=text] {

    margin-bottom: 3px;
  }

  select {
    margin-bottom: 5px;
    font-size: 40px;
  }

  </style>
<div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile"> 
              <h3 class="profile-username text-center"><?php echo lang('settings_menu'); ?></h3> 

              <ul class="list-group" id="settings_menu">
              <?php $live = ['system', 'email', 'theme', 'departmets', 'menu', 'crons', 'departments', 'templates', 'general'];
                            $menus = $this->db->where('hook', 'settings_menu_admin')->where('visible', 1)->order_by('order', 'ASC')->get('hooks')->result();
                            foreach ($menus as $menu) {
                                if ('TRUE' == config_item('demo_mode') && in_array($menu->route, $live)) {
                                    continue;
                                } ?>
                                <li class="list-group-item <?php echo ($load_setting == $menu->route) ? 'active' : ''; ?>">
                                    <a href="<?php echo base_url(); ?>settings/?settings=<?php echo $menu->route; ?>">
                                        <i class="fa fa-fw <?php echo $menu->icon; ?>"></i>
                                        <?php echo lang($menu->name); ?>
                                    </a>
                                </li>
                            <?php
                            } ?>
              </ul>
            </div>
              <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
        <div class="box box-warning">
                <div class="box-body">

                    <?php
                    $attributes = ['id' => 'saveform'];
                    echo form_open(base_url().'settings/fields/saveform', $attributes);
                    ?>

                        <div class="table-head"><?php echo ucfirst($module); ?> custom fields
                            <span class="pull-right">
                            <span class="label label-warning changes">Unsaved</span>
                        <input type="submit" class="btn btn-primary btn-sm save button-loader" value="Save" disabled="disabled"></span>
                        <input type="hidden" name="module" value="<?php echo $module; ?>" />
                        <input type="hidden" name="deptid" value="<?php echo $department ?? 0; ?>" />
                        <input type="hidden" name="uniqid" value="<?php echo Applib::generate_unique_value(); ?>" />
                        </div>
                        <div class="table-div">
                            <br>

                                <textarea id="formcontent" class="hidden" name="formcontent"></textarea>
                        </div>

                        </form>
                        <div class='fb-main'></div>

                        </div>
                  </div>
                </div>
             </div>
   

<?php if (isset($formbuilder)) { ?>
    <script src="<?php echo base_url(); ?>resource/js/apps/formbuilder_vendor.js"></script>
    <script src="<?php echo base_url(); ?>resource/js/apps/formbuilder.js"></script>
<?php } ?>
<script>
    (function($){ 

        fb = new Formbuilder({
          selector: '.fb-main',
          bootstrapData: [
              <?php foreach ($fields as $f) { ?>
              {"label":"<?php echo $f->label; ?>","field_type":"<?php echo $f->type; ?>","required":"<?php echo (1 == $f->required) ? true : false; ?>","cid":"<?php echo $f->cid; ?>",'uniqid':"<?php echo $f->uniqid; ?>",'module':"<?php echo $f->module; ?>","field_options":<?php echo $f->field_options; ?>},
              <?php } ?>
          ]
        });

        fb.on('save', function(payload){
          console.log(payload);
          $("#formcontent").text(payload);
        });


        switch ( window.orientation ) {

      case 0:
          alert('Please turn your phone sideways in order to use this page!');
      break;

  }

})(jQuery);  
  </script>
