<?php

require_once __DIR__ . '/core/Autoloader.php';

$autoloader = new Autoloader(__DIR__);

$autoloader->registerDir('/core');
$autoloader->registerDir('/models');
$autoloader->registerDir('/controller');
$autoloader->registerDir('/exception');

$autoloader->autoload();
