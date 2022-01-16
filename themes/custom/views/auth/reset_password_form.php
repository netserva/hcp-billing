<?php declare(strict_types=1);
$new_password = [
    'name' => 'new_password',
    'id' => 'new_password',
    'maxlength' => config_item('password_max_length', 'tank_auth'),
    'size' => 30,
    'class' => 'form-control',
];
$confirm_new_password = [
    'name' => 'confirm_new_password',
    'id' => 'confirm_new_password',
    'maxlength' => config_item('password_max_length', 'tank_auth'),
    'size' => 30,
    'class' => 'form-control',
];
?>

<?php echo modules::run('sidebar/flash_msg'); ?>  

<div class="container inner">
        <div class="row"> 
		<div class="login-box"> 
                 
		 <section class="panel panel-default">
		<header class="panel-heading text-center"> <strong>Change Password <?php echo config_item('company_name'); ?></strong> </header>

		<?php $attributes = ['class' => 'panel-body wrapper-lg'];
        echo form_open($this->uri->uri_string(), $attributes); ?>
			<div class="form-group">
				<label class="control-label"><?php echo lang('new_password'); ?></label>
				<?php echo form_password($new_password); ?>
				<span class="text-hidden">
				<?php echo form_error($new_password['name']); ?><?php echo $errors[$new_password['name']] ?? ''; ?></span>
			</div>
			<div class="form-group">
				<label class="control-label"><?php echo lang('confirm_password'); ?> </label>
				<?php echo form_password($confirm_new_password); ?>
				<span class="text-hidden"><?php echo form_error($confirm_new_password['name']); ?><?php echo $errors[$confirm_new_password['name']] ?? ''; ?></span>
			</div>


			<button type="submit" class="btn btn-<?php echo config_item('theme_color'); ?>">Change Password</button>
			<div class="line line-dashed">
			</div> 
			<?php if (config_item('allow_registration', 'tank_auth')) { ?>
			<p class="text-muted text-center"><small>Do not have an account?</small></p> 
			<?php } ?>
			<a href="<?php echo base_url(); ?>auth/register/" class="btn btn-success btn-block">Get Your Account</a>
<?php echo form_close(); ?>

 </section>
 
</div>
</div>
</div>