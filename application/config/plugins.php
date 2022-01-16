<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Plugins Directory
|--------------------------------------------------------------------------
|
| Where are the plugins kept?
|
|       Default: FCPATH . 'plugins/' (<root>/plugins/)
*/
$config['plugin_dir'] = FCPATH.'modules/';

//require( APPPATH . 'libraries/abstract.plugins.php' );
require APPPATH.'libraries/trait.plugins.php';
