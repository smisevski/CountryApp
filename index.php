<?php
require __DIR__ . '/vendor/autoload.php';

use App\Libs\Logger;
use App\Libs\WebHost;

WebHost::modifyHeaders();

require __DIR__ . '/App/Controllers/AuthController.php';
require __DIR__ . '/App/Controllers/CountriesController.php';

Logger::enableSystemLogs();
