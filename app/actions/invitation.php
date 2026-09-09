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

function handleAcceptMembershipInvitationRequest(): void
{
    if (!isLoggedIn()) {
        header('Location: ?p=login');
        exit;
    }

    $token = $_POST['token'] ?? null;

    if (!is_string($token) || $token === '') {
        http_response_code(400);
        exit;
    }

    $pdo = db();
    $userId = $_SESSION['user_id'];

    $invite = getMembershipInvitationByToken($pdo, $token);

    if (!$invite) pageNotFound();

    $groupId = (int) $invite['group_id'];

    if ($invite['used']) {
        header('Location: ?p=invitation&token=' . urlencode($token));
        exit;
    }

    if (strtotime($invite['expires_at']) <= time()) {
        header('Location: ?p=invitation&token=' . urlencode($token));
        exit;
    }

    if (getGroupRole($pdo, $groupId) !== false) {
        header('Location: ?p=group&gid=' . urlencode($groupId));
        exit;
    }

    $success = acceptMembershipInvitation($pdo, $token, $groupId, $userId);

    if (!$success) {
        http_response_code(500);
        exit;
    }

    header('Location: ?p=group&gid=' . urlencode($groupId));
    exit;
}