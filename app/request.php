<?php

function handleRequest(): array
{
    $viewData = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $postAction = $_POST['action'] ?? '';

        if ($postAction === 'request_membership') {
            handleMembershipRequest();
        }
    }

    $pageSlug = $_GET['p'] ?? 'start';
    $getAction = $_GET['a'] ?? null;

    if ($pageSlug === 'login') {
        $viewData = handleLoginRequest();
    }

    if ($pageSlug === 'register') {
        $viewData = handleRegisterRequest();
    }

    if ($getAction === 'logout') {
        handleLogoutRequest();
    }

    return $viewData;
}