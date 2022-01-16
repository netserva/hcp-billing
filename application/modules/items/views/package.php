<?php declare(strict_types=1);
$item = Item::view_item($id);
$list = [];
$server = (object) [];

foreach ($servers as $srv) {
    $list[$srv->type] = ucfirst($srv->type);

    if ($srv->id == $item->server) {
        $server = $srv;
    }
}

?>

<div class="box">

    <div class="box-body">
        <div class="row">
            <div class="col-md-6">

                <?php echo $this->settings->open_form(
    ['action' => '', 'id' => 'servers', 'method' => 'GET']
);

                $options = [
                    'label' => 'Server',
                    'id' => 'server',
                    'type' => 'dropdown',
                    'options' => $list,
                ];

                if (isset($server->type)) {
                    $options['value'] = $server->type;
                }

                if (isset($_GET['server'])) {
                    $options['value'] = $_GET['server'];
                    foreach ($servers as $srv) {
                        if ($srv->type == $_GET['server']) {
                            $server = $srv;
                        }
                    }
                }

                if (!isset($server->type) && !isset($_GET['server'])) {
                    $list = array_merge(['none' => 'None'], $list);
                    $options = [
                        'label' => 'Server',
                        'id' => 'server',
                        'type' => 'dropdown',
                        'options' => $list,
                    ];

                    $options['value'] = 'none';
                }

                echo $this->settings->build_form_horizontal([$options]);
                echo $this->settings->close_form();

                if (isset($_GET['server']) || isset($server->type) && '' != $server->type) {
                    echo $this->settings->open_form(['action' => '']);

                    if (isset($server->type) && '' != $server->type) {
                        $conf = $server->type;
                    }

                    if (isset($_GET['server'])) {
                        $conf = $_GET['server'];
                    }

                    $package_config = unserialize($item->package_config);
                    if (is_array($package_config)) {
                        $package_config['package'] = $item->package_name;
                    } else {
                        $package_config = ['package' => $item->package_name];
                    }

                    $configuration = modules::run($conf.'/'.$conf.'_package_config', $package_config);

                    $configuration[] = [
                        'id' => 'item_id',
                        'type' => 'hidden',
                        'value' => $id,
                    ];

                    $configuration[] = [
                        'id' => 'server_id',
                        'type' => 'hidden',
                        'value' => $server->id,
                    ];

                    $configuration[] = [
                        'id' => 'submit',
                        'type' => 'submit',
                        'label' => 'Save',
                    ];

                    echo $this->settings->build_form_horizontal($configuration);
                    echo $this->settings->close_form();
                }
              ?>

            </div>
        </div>
    </div>
</div>

<script>
	$('#server').on('change', function() {
		$('#servers').submit();
	});
</script>