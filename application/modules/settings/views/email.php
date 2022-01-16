<!-- START TEMPLATES -->
<?php
$template_group = $_GET['view'] ?? '';
if ('alerts' == $template_group) {
    $this->load->view($template_group);
} else {
    $this->load->view('email_settings');
}
?>