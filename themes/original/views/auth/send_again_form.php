<?php declare(strict_types=1);
$email = [
    'name' => 'email',
    'id' => 'email',
    'value' => set_value('email'),
    'maxlength' => 80,
    'size' => 30,
    'class' => 'form-control',
];
?>

<div class="container inner">
        <div class="row"> 
		<div class="login-box"> 

		 <section class="panel panel-default bg-white m-t-lg">
		<header class="panel-heading text-center"> 
			<strong>Send Again <?php echo config_item('company_name'); ?></strong> 
		</header>

		<?php
        $attributes = ['class' => 'panel-body wrapper-lg'];
        echo form_open($this->uri->uri_string(), $attributes); ?>
			<div class="form-group">
				<label class="control-label"><?php echo lang('email_address'); ?></label>
				<?php echo form_input($email); ?>
				<span class="text-hidden">
				<?php echo form_error($email['name']); ?><?php echo $errors[$email['name']] ?? ''; ?>
				</span>
			</div>


			<button type="submit" class="btn btn-primary">Send</button>
			<div class="line line-dashed">
			</div>
			<?php if (config_item('allow_registration', 'tank_auth')) { ?>
			<p class="text-muted text-center"><small>Do not have an account?</small></p>
			<?php } ?>
			<a href="<?php echo base_url(); ?>auth/register" class="btn btn-success btn-block">Get Your Account</a>
<?php echo form_close(); ?>

 </section>
	</div>
	</div>
	</div>
