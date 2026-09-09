<?php

/**
 * Request handler
 */

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

        if ($postAction === 'create_group') {
            $viewData = handleCreateGroupRequest();
        }

        if ($postAction === 'create_thread') {
            $viewData = handleCreateThreadRequest();
        }

        if ($postAction === 'create_comment') {
            $viewData = handleCreateCommentRequest();
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