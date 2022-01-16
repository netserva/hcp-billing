<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title"><?php echo lang('ban_user'); ?> - <?php echo strtoupper($username); ?></h4>
    </div><?php
    $attributes = ['class' => 'bs-example form-horizontal'];
    echo form_open(base_url().'users/account/ban', $attributes); ?>

    <div class="modal-body">
      <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

      <div class="form-group">
        <label class="col-lg-4 control-label"><?php echo lang('ban_reason'); ?></label>
        <div class="col-lg-8">
          <textarea class="form-control ta" name="ban_reason"><?php echo User::login_info($user_id)->ban_reason; ?></textarea>
        </div>
      </div>

    </div>
    <div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a>
      <button type="submit" class="btn btn-<?php echo config_item('theme_color'); ?>"><?php echo lang('save_changes'); ?></button>
    </form>
  </div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
