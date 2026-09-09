<?php

/**
 * Latest activity component view
 */

if (!isLoggedIn()) return;

$pdo = db();
$userId = $_SESSION['user_id'];

$threads = getLatestThreadsForUser($pdo, $userId, 5);

if (empty($threads)) {
    displayAlert('Det finns ingen aktivitet att visa än.', 'info');
    return;
}

?>

<ul class="no-list-style thread-list">
  <?php foreach ($threads as $thread) { ?>
    <li>
      <a href="?p=thread&amp;tid=<?= urlencode($thread['id']) ?>">
        <?= htmlspecialchars($thread['subject']) ?>
      </a>

      <span>
        <?= formatTimeAgo($thread['last_activity']) ?>
        i
        <a href="?p=group&amp;gid=<?= urlencode($thread['group_id']) ?>">
          <?= htmlspecialchars($thread['group_name']) ?>
        </a>
      </span>
    </li>
  <?php } ?>
</ul>