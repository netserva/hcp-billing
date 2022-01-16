<style type="text/css">
.btn-twitter:active,
.btn-twitter.active {
    color: #000 !important;
    background-color: #fff;
    border-color: #1ab394;
}
</style>
<?php
$this->load->helper('app');
$template = $_GET['template'] ?? 'invoice';
$attributes = ['class' => 'bs-example form-horizontal'];
echo form_open('settings/update'); ?>

<div class="row">
    <div class="col-lg-12">
        <section class="panel panel-default">
            <header class="panel-heading font-bold"><i class="fa fa-cogs"></i> <?php echo lang('sms_templates'); ?></header>
            <div class="panel-body">


                <div class="m-b-sm">
                    <?php foreach ($templates as $temp) { ?>
                    <a href="<?php echo base_url(); ?>settings/?settings=sms_templates&template=<?php echo $temp->type; ?>"
                        class="<?php if ($template == $temp->type) {
    echo 'active';
} ?> btn btn-s-xs btn-sm btn-twitter"><?php echo lang($temp->type); ?></a>
                    <?php } ?>

                </div>
                <input type="hidden" name="settings" value="<?php echo $load_setting; ?>">
                <input type="hidden" name="template" value="<?php echo $template; ?>">
                <input type="hidden" name="return_url"
                    value="<?php echo base_url(); ?>settings/?settings=sms_templates&template=<?php echo $template; ?>"> 
                <div class="form-group">
                    <label class="col-lg-12"><?php echo lang('message'); ?></label>
                    <div class="col-lg-12">
                        <textarea class="form-control form-control" name="sms_template"><?php echo App::sms_template($template); ?></textarea>
                    </div>
                </div>

            </div>
            <div class="panel-footer">
                <div class="text-center">
                    <button type="submit"
                        class="btn btn-sm btn-<?php echo config_item('theme_color'); ?>"><?php echo lang('save_changes'); ?></button>
                </div>

                <strong><?php echo lang('template_tags'); ?></strong>
                <ul>
                    <?php $tags = get_tags('sms'); foreach ($tags as $key => $value) {
    echo '<li>{'.$value.'}</li>';
} ?>
                </ul>
            </div>

        </section>
    </div>
</div>
</form>