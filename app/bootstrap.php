<?php
declare(strict_types=1);

date_default_timezone_set("UTC");

require_once 'vendor/autoload.php';

use Core\App;
use Core\Http\RequestFactory;

$config = require 'app/config.php';

$app = App::getInstance();
$app->setConfig($config);
$request = RequestFactory::fromGlobals();
$app->setRequest($request);
