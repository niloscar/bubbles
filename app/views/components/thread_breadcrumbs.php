<?php

/**
 * Thread breadcrumbs component view
 */

$pdo = db();
$threadId = isset($_GET['tid'])
  ? (int) $_GET['tid']
  : null;

if (!$threadId) return;

$thread = getThreadById($pdo, $threadId);

if ($thread === false) return;
?>

<nav class="nav-breadcrumbs">
  <a href="?p=group&gid=<?= urlencode($thread['group_id']) ?>">
    <?= htmlspecialchars($thread['group_name']) ?>
  </a>
  &raquo;
  <span><?= htmlspecialchars($thread['subject']) ?></span>
</nav>