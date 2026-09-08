<?php

/**
 * Breadcrumbs component view
 */

$group = $data['group'] ?? null;
$thread = $data['thread'] ?? null;

if (!$group && !$thread) return;

$groupId = $group['id'] ?? $thread['group_id'];
$groupName = $group['name'] ?? $thread['group_name'];
?>

<nav class="nav-breadcrumbs">
  <a href="?p=groups">Grupper</a>
  <img src="assets/icons/arrow-right.svg" alt="&raquo;" class="icon icon-arrow-right">

  <?php if ($thread): ?>
    <a href="?p=group&amp;gid=<?= urlencode($groupId) ?>">
      <?= htmlspecialchars($groupName) ?>
    </a>
    <img src="assets/icons/arrow-right.svg" alt="&raquo;" class="icon icon-arrow-right">
    <span><?= htmlspecialchars($thread['subject']) ?></span>
  <?php else: ?>
    <span><?= htmlspecialchars($groupName) ?></span>
  <?php endif; ?>
</nav>