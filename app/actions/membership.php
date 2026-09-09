<?php

/**
 * Membership actions
 */

function handleMembershipRequest(): void
{
  if (!isLoggedIn()) return;

  $userId = (int) $_SESSION['user_id'];
  $groupId = (int) ($_POST['group_id'] ?? 0);

  if ($groupId <= 0) return;

  $pdo = db();
  $success = createMembershipRequest($pdo, $groupId, $userId);
  if (!$success) {
    // ONTODO: Handle error case for when creating membership request fails due to existing membership or pending request
    return;
  }

  header('Location: ' . $_SERVER['REQUEST_URI']);
  exit;
}

function handleApproveMembershipRequest(): void
{
  if (!isLoggedIn()) return;

  $requestId = (int) ($_POST['request_id'] ?? 0);

  if ($requestId <= 0) return;

  $pdo = db();
  $success = approveMembershipRequest($pdo, $requestId, (int) $_SESSION['user_id']);

  if (!$success) {
    // ONTODO: Handle error case for when approving membership request fails due to insufficient permissions or that the request does not exist
    return;
  }

  header('Location: ' . $_SERVER['REQUEST_URI']);
  exit;
}

function handleRejectMembershipRequest(): void
{
    if (!isLoggedIn()) return;

    $requestId = (int) ($_POST['request_id'] ?? 0);

    if ($requestId <= 0) return;

    $pdo = db();
    $success = rejectMembershipRequest($pdo, $requestId, (int) $_SESSION['user_id']);

    if (!$success) {
        // ONTODO: Handle error case for when rejecting membership request fails due to insufficient permissions or that the request does not exist
        return;
    }

    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}