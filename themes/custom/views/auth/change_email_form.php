<?php declare(strict_types=1);
$password = [
    'name' => 'password',
    'id' => 'password',
    'size' => 30,
];
$email = [
    'name' => 'email',
    'id' => 'email',
    'value' => set_value('email'),
    'maxlength' => 80,
    'size' => 30,
];
?>

<div class="container inner">
        <div class="row"> 
		<div class="login-box"> 
<?php echo form_open($this->uri->uri_string()); ?>
<table>
	<tr>
		<td><?php echo form_label(lang('password'), $password['id']); ?></td>
		<td><?php echo form_password($password); ?></td>
		<td class="text-danger"><?php echo form_error($password['name']); ?><?php echo $errors[$password['name']] ?? ''; ?></td>
	</tr>
	<tr>
		<td><?php echo form_label(lang('new_email_address'), $email['id']); ?></td>
		<td><?php echo form_input($email); ?></td>
		<td class="text-danger"><?php echo form_error($email['name']); ?><?php echo $errors[$email['name']] ?? ''; ?></td>
	</tr>
</table>
<?php echo form_submit('change', 'Send confirmation email'); ?>
<?php echo form_close(); ?>

</div>
</div>
</div>