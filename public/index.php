<?php

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/app/bootstrap.php';

$viewData = handleRequest();

part('header');

output($viewData);

part('footer');