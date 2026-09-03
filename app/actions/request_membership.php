<?php

/**
 * Request membership action
 */

function handleMembershipRequest(): void
{
  if (!isLoggedIn()) return;

  $userId = (int) $_SESSION['user_id'];
  $groupId = (int) ($_POST['group_id'] ?? 0);

  if ($groupId <= 0) return;

  $pdo = db();

  if (!createMembershipRequest($pdo, $groupId, $userId)) {
    echo '<p>Förfrågan kunde inte skapas.</p>';
    return;
  }

  header('Location: ' . $_SERVER['REQUEST_URI']);
  exit;
}
