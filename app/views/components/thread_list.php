<?php

/**
 * Thread list component view
 */

$groupId = isset($_GET['gid'])
  ? (int) $_GET['gid']
  : null;

$pdo = db();
$threads = getThreadsByGroupId($pdo, $groupId);

if (empty($threads)) {
    displayAlert('Det finns inga diskussioner i den här gruppen än.', 'info');
    return;
}

?>
<ul class="no-list-style thread-list">
  <?php foreach ($threads as $thread) { ?>
    <li>
      <a href="?p=thread&tid=<?= urlencode($thread['id']) ?>">
        <?= htmlspecialchars($thread['subject']) ?>
      </a>
      <span>
        <i class="icon icon-pulse"></i>
        <?= formatTimeAgo($thread['last_activity']) ?>
        av <a href="?p=user&uid=<?= urlencode($thread['user_id']) ?>"> <?= htmlspecialchars($thread['last_activity_username']) ?></a>
      </span>
    </li>
  <?php } ?>
</ul>