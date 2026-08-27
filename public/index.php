<?php

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/app/bootstrap.php';

part('header');

output();

include BASE_PATH . '/config/database.php';

part('footer');