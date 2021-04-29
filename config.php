<?php

return [
    'domainName' => 'local.domain',
    'LOG_PATH' => __DIR__ . './logs',
    'connectionParams' => [
        'dataSourceName' => 'mysql:host=127.0.01;dbname=CountryApp',
        'user' => 'root',
        'password' => '',
        'driver' => 'pdo_mysql',
    ],
    'secretKey' => 'secretKey'
   ];