 <?php
if ($this->session->flashdata('message')) { ?>
<?php if ('success' == $this->session->flashdata('response_status')) {
    $alert_type = 'success';
} else {
    $alert_type = 'danger';
} ?>
<div class="alert alert-<?php echo $alert_type; ?>"> 
<button type="button" class="close" data-dismiss="alert">×</button> <i class="fa fa-info-sign"></i>
<?php echo $this->session->flashdata('message'); ?>
</div>

    <?php } ?> 