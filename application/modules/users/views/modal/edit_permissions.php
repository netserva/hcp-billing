<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button> 
    <h4 class="modal-title"><?php echo lang('permission_settings'); ?> <?php
                if (isset($user_id)) {
                    echo ' for '.ucfirst(Applib::get_table_field('users', ['id' => $user_id], 'username'));
                }
                ?></h4>
    </div>
    <div class="modal-body">


    <?php
    $attributes = ['class' => 'bs-example form-horizontal'];
    echo form_open('users/account/permissions', $attributes); ?>
        <input type="hidden" name="settings" value="permissions">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

        <!-- checkbox -->
        <?php
        $permission = $this->db->where(['status' => 'active'])->get('permissions')->result();

        $current_json_permissions = Applib::get_table_field(Applib::$profile_table, ['user_id' => $user_id], 'allowed_modules');

        if (null == $current_json_permissions) {
            $current_json_permissions = '{"settings":"permissions"}';
        }
        $current_permissions = json_decode($current_json_permissions, true);
        foreach ($permission as $key => $p) { ?>
            <div class="checkbox">
                <label class="checkbox-custom">
                    <input type="hidden" value="off" name="<?php echo $p->name; ?>" />
                    <input name="<?php echo $p->name; ?>" <?php
                    if (array_key_exists($p->name, $current_permissions) && 'on' == $current_permissions[$p->name]) {
                        echo 'checked="checked"';
                    }
                    ?>  type="checkbox">
                    <?php echo lang($p->name); ?>
                </label>
            </div>
            <?php } ?>

        <div class="modal-footer"> 
    <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a> 
    <button type="submit" class="btn btn-<?php echo config_item('theme_color'); ?>"><?php echo lang('save_changes'); ?></button>
    </form>

        </div>

    
    </div>

  </div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->