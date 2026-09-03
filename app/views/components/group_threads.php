<?php

/**
 * Group threads component view
 */

$groupId = isset($_GET['gid'])
  ? (int) $_GET['gid']
  : null;

$pdo = db();
$threads = getThreadsByGroupId($pdo, $groupId);

?>
<h2>Trådar</h2>
<ul class="no-list-style group-threads">
  <?php foreach ($threads as $thread) { ?>
    <li>
      <p>
        <a href="?p=thread&tid=<?= urlencode($thread['id']) ?>">
          <?= htmlspecialchars($thread['subject']) ?>
        </a>
        <?= formatTimeAgo($thread['created_at']) ?>
        <a href="?p=user&uid=<?= urlencode($thread['user_id']) ?>"> av <?= htmlspecialchars($thread['username']) ?></a>
      </p>
    </li>
  <?php } ?>
</ul>