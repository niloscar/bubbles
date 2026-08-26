<?php

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/config/settings.php';
require_once BASE_PATH . '/app/helpers/view.php';
require_once BASE_PATH . '/app/helpers/page.php';

pageHeader();

pageOutput();

pageFooter();
