<?php

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/app/bootstrap.php';

$viewData = [];

$pageSlug = $_GET['p'] ?? 'start';
$action = $_GET['a'] ?? null;

if ($pageSlug === 'login') $viewData = handleLoginRequest();
if ($pageSlug === 'register') $viewData = handleRegisterRequest();

if ($action === 'logout') handleLogoutRequest();

part('header');

output($viewData);

part('footer');