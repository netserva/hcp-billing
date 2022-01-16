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
$template_group = $_GET['group'] ?? 'user';

switch ($template_group) {
    case 'invoice': $default = 'invoice_message';

break;

    case 'ticket': $default = 'ticket_client_email';

break;

    case 'user': $default = 'hosting_account';

break;

    case 'signature': $default = 'email_signature';

break;
}
$setting_email = $_GET['email'] ?? $default;

$email['invoice'] = ['invoice_message', 'invoice_reminder', 'payment_email'];
$email['ticket'] = ['ticket_client_email', 'ticket_closed_email', 'ticket_reply_email', 'ticket_staff_email', 'auto_close_ticket', 'ticket_reopened_email'];
$email['user'] = ['hosting_account', 'service_suspended', 'service_unsuspended', 'activate_account', 'change_email', 'forgot_password', 'registration', 'reset_password'];
$email['signature'] = ['email_signature'];

$attributes = ['class' => 'bs-example form-horizontal'];
echo form_open('settings/templates?settings=templates&group='.$template_group.'&email='.$setting_email, $attributes); ?>

<div class="row">
    <div class="col-lg-12">
        <section class="panel panel-default">
            <header class="panel-heading font-bold"><i class="fa fa-cogs"></i> <?php echo lang('email_templates'); ?></header>
            <div class="panel-body">


                <div class="m-b-sm">
                    <?php foreach ($email[$template_group] as $temp) {
    $lang = $temp;

    switch ($temp) {
                                    case 'registration': $lang = 'register_email';

break;

                                    case 'email_signature': $lang = 'email_signature';

break;
                                } ?>


                    <a href="<?php echo base_url(); ?>settings/?settings=templates&group=<?php echo $template_group; ?>&email=<?php echo $temp; ?>"
                        class="<?php if ($setting_email == $temp) {
                                    echo 'active';
                                } ?> btn btn-s-xs btn-sm btn-twitter"><?php echo lang($lang); ?></a>
                    <?php
} ?>

                </div>
                <input type="hidden" name="email_group" value="<?php echo $setting_email; ?>">
                <input type="hidden" name="return_url"
                    value="<?php echo base_url(); ?>settings/?settings=templates&group=<?php echo $template_group; ?>&email=<?php echo $setting_email; ?>">
                <?php if ('signature' != $template_group) { ?>
                <div class="form-group">
                    <label class="col-lg-12"><?php echo lang('subject'); ?></label>
                    <div class="col-lg-12">
                        <input class="form-control" name="subject"
                            value="<?php echo App::email_template($setting_email, 'subject'); ?>" />
                    </div>
                </div>
                <?php } ?>
                <div class="form-group">
                    <label class="col-lg-12"><?php echo lang('message'); ?></label>
                    <div class="col-lg-12">
                        <textarea class="form-control form-control foeditor" name="email_template">
                    <?php echo App::email_template($setting_email, 'template_body'); ?></textarea>
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
                    <?php $tags = get_tags($setting_email); foreach ($tags as $key => $value) {
                                    echo '<li>{'.$value.'}</li>';
                                } ?>
                </ul>
            </div>

        </section>
    </div>
</div>
</form>