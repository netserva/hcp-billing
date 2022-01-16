<p>
        <strong>GENERAL CRON: </strong> <code>wget -O /dev/null <?php echo base_url(); ?>crons/run/<?php echo config_item('cron_key'); ?></code>
         </p><p>
        <strong>EMAIL PIPING: </strong> <code>wget -O /dev/null <?php echo base_url(); ?>crons/email_piping</code>
         </p>
         <div class="box">
 
        <div class="box-body">
            <div class="row">
    <!-- Start Form -->
    <div class="col-lg-12">

       
                        <div class="table-responsive">
                          <table id="cron-jobs" class="table table-striped b-t b-light table-menu">
                            <thead>
                                    <tr>
                                    <th><?php echo lang('job'); ?></th>
                                    <th><?php echo lang('cron_last_run'); ?></th>
                                    <th><?php echo lang('result'); ?></th>
                                    <th><?php echo lang('active'); ?></th>
                                    </tr>
                            </thead>
                            <tbody>
                                <?php error_reporting(0);
                                $result = unserialize(config_item('cron_last_run')); ?>
                                <?php foreach ($crons as $cron) { ?>
                                <tr>
                                    <td><i class="fa fa-fw m-r-sm <?php echo ('' != $cron->icon ? $cron->icon : 'cog'); ?>"></i> <?php echo lang($cron->name); ?></td>
                                    <td><?php echo date('Y-m-d H:i', strtotime($cron->last_run)); ?></td>
                                    <td><?php if ($result) {
                                    if (is_array($result[$cron->module])) {
                                        echo $result[$cron->module]['result'];
                                    } else {
                                        echo $result[$cron->module] ? lang('success') : lang('error');
                                    }
                                }
                                    ?></td>
                                    <td>
                                        <a data-rel="tooltip" data-original-title="<?php echo lang('toggle_enabled'); ?>" class="cron-enabled-toggle btn btn-xs btn-<?php echo (1 == $cron->enabled ? 'success' : 'default'); ?> m-r-xs" href="#" data-role="1" data-href="<?php echo base_url(); ?>settings/hook/enabled/<?php echo $cron->module; ?>"><i class="fa fa-check"></i></a>
                                        <?php
                                            $cron_set = $this->db->where('hook', 'cron_job_settings')->where('parent', $cron->module)->get('hooks')->result_array();
                                            if (1 == count($cron_set)) {
                                                $cron_set = $cron_set[0]; ?>
                                        <a data-rel="tooltip" data-original-title="<?php echo lang('settings'); ?>" data-toggle="ajaxModal" class="cron-settings btn btn-xs btn-default" href="<?php echo base_url(); ?><?php echo $cron_set['route']; ?>/<?php echo $cron->module; ?>"><i class="fa fa-cog"></i></a>
                                        <?php
                                            } ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                          </table>
                        </div>
               
        <?php
        $attributes = ['class' => 'bs-example form-horizontal'];
        echo form_open_multipart('settings/update', $attributes); ?>
            
                    <?php echo validation_errors(); ?>
                    <input type="hidden" name="settings" value="<?php echo $load_setting; ?>">
                    <div class="row">

                    <div class="col-md-8">
                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?php echo lang('cron_key'); ?></label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" value="<?php echo config_item('cron_key'); ?>" name="cron_key">
                        </div>
                    </div>
                    </div>

                    <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-lg-7 control-label"><?php echo lang('auto_backup_db'); ?></label>
                        <div class="col-lg-5">
                            <label class="switch">
                                <input type="hidden" value="off" name="auto_backup_db" />
                                <input type="checkbox" <?php if ('TRUE' == config_item('auto_backup_db')) {
            echo 'checked="checked"';
        } ?> name="auto_backup_db">
                                <span></span>
                            </label>
                        </div>
                    </div>
                 </div> 
      

                    <div class="text-center">
                        <button type="submit" class="btn btn-sm btn-<?php echo config_item('theme_color'); ?>"><?php echo lang('save_changes'); ?></button>
                    </div>
               
        </form>
        </div>
        </div>       
    <!-- End Form -->
 