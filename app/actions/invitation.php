<?php

/**
 * Invitation action handler
 */

function handleCreateMembershipInvitationRequest(): void
{
    if (!isLoggedIn()) {
        header('Location: ?p=login');
        exit;
    }

    $groupId = isset($_POST['group_id']) ? (int) $_POST['group_id'] : 0;

    if (!$groupId) {
        http_response_code(400);
        exit;
    }

    $pdo = db();
    $userId = $_SESSION['user_id'];

    if (!isGroupAdmin($pdo, $groupId)) {
        http_response_code(403);
        exit;
    }

    $token = createMembershipInvitation($pdo, $userId, $groupId);

    if (!$token) {
        http_response_code(500);
        exit;
    }

    $link = '?p=invitation&token=' . urlencode($token);

    $_SESSION['generated_invitation_link'] = PAGE_URL . '?p=invitation&token=' . urlencode($token);

    header('Location: ?p=group&gid=' . $groupId);
    exit;
}