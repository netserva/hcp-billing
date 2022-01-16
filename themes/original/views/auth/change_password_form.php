<?php declare(strict_types=1);
$old_password = [
    'name' => 'old_password',
    'id' => 'old_password',
    'value' => set_value('old_password'),
    'size' => 30,
];
$new_password = [
    'name' => 'new_password',
    'id' => 'new_password',
    'maxlength' => config_item('password_max_length', 'tank_auth'),
    'size' => 30,
];
$confirm_new_password = [
    'name' => 'confirm_new_password',
    'id' => 'confirm_new_password',
    'maxlength' => config_item('password_max_length', 'tank_auth'),
    'size' => 30,
];
?>
<?php echo form_open($this->uri->uri_string()); ?>

<div class="container inner">
        <div class="row"> 
		<div class="login-box"> 

<table>
	<tr>
		<td><?php echo form_label('Old Password', $old_password['id']); ?></td>
		<td><?php echo form_password($old_password); ?></td>
		<td class="text-danger"><?php echo form_error($old_password['name']); ?><?php echo $errors[$old_password['name']] ?? ''; ?></td>
	</tr>
	<tr>
		<td><?php echo form_label('New Password', $new_password['id']); ?></td>
		<td><?php echo form_password($new_password); ?></td>
		<td class="text-danger"><?php echo form_error($new_password['name']); ?><?php echo $errors[$new_password['name']] ?? ''; ?></td>
	</tr>
	<tr>
		<td><?php echo form_label('Confirm New Password', $confirm_new_password['id']); ?></td>
		<td><?php echo form_password($confirm_new_password); ?></td>
		<td class="text-danger"><?php echo form_error($confirm_new_password['name']); ?><?php echo $errors[$confirm_new_password['name']] ?? ''; ?></td>
	</tr>
</table>
<?php echo form_submit('change', 'Change Password'); ?>
<?php echo form_close(); ?>
</div>
</div>
</div>