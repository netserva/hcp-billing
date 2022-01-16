<?php declare(strict_types=1);
$login = [
    'name' => 'login',
    'class' => 'form-control',
    'placeholder' => lang('username'),
    'value' => set_value('login'),
    'maxlength' => 80,
    'size' => 30,
];
if ($login_by_username and $login_by_email) {
    $login_label = 'Email or Username';
} elseif ($login_by_username) {
    $login_label = 'Username';
} else {
    $login_label = 'Email';
}
$password = [
    'name' => 'password',
    'id' => 'inputPassword',
    'placeholder' => lang('password'),
    'size' => 30,
    'class' => 'form-control',
];
$remember = [
    'name' => 'remember',
    'id' => 'remember',
    'value' => 1,
    'checked' => set_value('remember'),
];
$captcha = [
    'name' => 'captcha',
    'id' => 'captcha',
    'class' => 'form-control',
    'maxlength' => 10,
];
?>


<div class="container inner">
    <div class="row">
        <div class="login-box">

            <section class="panel panel-default">
                <header class="panel-heading text-center"> <?php echo lang('please_enter'); ?>
                    <strong><?php echo config_item('website_name'); ?></strong> <?php echo lang('login_details'); ?>
                    <?php echo modules::run('sidebar/flash_msg'); ?>
                </header>
                <?php
        $attributes = ['class' => 'panel-body login'];
        echo form_open($this->uri->uri_string(), $attributes); ?>

                <div class="form-group">
                    <label class="control-label"><?php echo lang('email_user'); ?></label>
                    <?php echo form_input($login); ?>
                    <span class="text-danger">
                        <?php echo form_error($login['name']); ?><?php echo $errors[$login['name']] ?? ''; ?></span>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo lang('password'); ?></label>
                    <?php echo form_password($password); ?>
                    <span
                        class="text-danger"><?php echo form_error($password['name']); ?><?php echo $errors[$password['name']] ?? ''; ?></span>
                </div>


                <table>

                    <?php if ($show_captcha) {
            if ($use_recaptcha) { ?>

                    <?php echo $this->recaptcha->render(); ?>

                    <?php } else { ?>
                    <tr>
                        <td colspan="2">
                            <p><?php echo lang('enter_the_code_exactly'); ?></p>
                        </td>
                    </tr>


                    <tr>
                        <td colspan="3"><?php echo $captcha_html; ?></td>
                        <td class="pl_5"><?php echo form_input($captcha); ?></td>
                        <span class="text-danger"><?php echo form_error($captcha['name']); ?></span>
                    </tr>
                    <?php }
        } ?>
                </table>

                <div class="checkbox">
                    <label>
                        <?php echo form_checkbox($remember); ?> <?php echo lang('this_is_my_computer'); ?>
                    </label>

                    <span class="pull-right"><a href="<?php echo base_url(); ?>auth/forgot_password"
                            class=" m-t-xs"><?php echo lang('forgot_password'); ?></a></span>
                </div>

                <button type="submit" class="btn btn-<?php echo config_item('theme_color'); ?>"><?php echo lang('sign_in'); ?></button>

                <hr>

                <?php if ('TRUE' == config_item('allow_client_registration')) { ?>
                <span class="pull-left"><?php echo lang('do_not_have_an_account'); ?></span>
                <a href="<?php echo base_url(); ?>auth/register"
                    class="btn btn-default pull-right"><?php echo lang('get_your_account'); ?></a>
                <?php } ?>

                <?php echo form_close(); ?>

                <!-- footer -->



                <!-- / footer -->

            </section>
        </div>
    </div>
</div>