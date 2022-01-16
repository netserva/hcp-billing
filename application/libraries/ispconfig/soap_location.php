<?php

declare(strict_types=1);

if ('on' == $soapsecure) {
    $soap_url = 'https://'.$soapsvrurl.':'.$soapsvrport.'/remote/index.php';
    $soap_uri = 'https://'.$soapsvrurl.':'.$soapsvrport.'/remote/';
} else {
    $soap_url = 'http://'.$soapsvrurl.':'.$soapsvrport.'/remote/index.php';
    $soap_uri = 'http://'.$soapsvrurl.':'.$soapsvrport.'/remote/';
}
