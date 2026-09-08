<?php

require_once __DIR__ . '/../app/bootstrap.php';

$viewData = handleRequest();

part('header');

output($viewData);

part('footer');