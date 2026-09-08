<?php

function handleRequest(): array
{
    $viewData = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $postAction = $_POST['action'] ?? '';

        if ($postAction === 'request_membership') {
            handleMembershipRequest();
        }

        if ($postAction === 'approve_membership') {
            handleApproveMembershipRequest();
        }

        if ($postAction === 'reject_membership') {
            handleRejectMembershipRequest();
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

    if ($pageSlug === 'invitation') {
        $token = $_GET['token'] ?? null;

        if (!is_string($token) || $token === '') pageNotFound();

        $pdo = db();
        $invite = getMembershipInvitationByToken($pdo, $token);

        if (!$invite) pageNotFound();
        $viewData['invite'] = $invite;
    }

    if ($getAction === 'logout') {
        handleLogoutRequest();
    }

    return $viewData;
}