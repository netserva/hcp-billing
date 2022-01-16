<?php

declare(strict_types=1);

// Connect to SOAP Server
$client = new SoapClient(
    null,
    ['location' => $soap_url,
        'uri' => $soap_uri,
        'exceptions' => 1,
        'trace' => false,
    ]
);
