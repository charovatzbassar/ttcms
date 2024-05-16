<?php

require __DIR__ . '/../../../vendor/autoload.php';

define('BASE_URL', 'http://localhost/ttcms/api/');

error_reporting(0);

$openapi = \OpenApi\Generator::scan(['../../../rest/controllers', './']);
header('Content-Type: application/x-yaml');
echo $openapi->toYaml();
?>
