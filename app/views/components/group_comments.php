<?php

/**
 * Group comments component view
 */

$groupId = isset($_GET['gid'])
  ? (int) $_GET['gid']
  : null;

$pdo = db();
$comments = getCommentsByGroupId($pdo, $groupId);

?>

<ul>
  <?php foreach ($comments as $comment) { ?>
    <li>
      <p>
        <a href="?p=user&amp;uid=<?= urlencode($comment['user_id']) ?>">
          <?= htmlspecialchars($comment['username']) ?>
        </a>:
        <?= htmlspecialchars($comment['text']) ?>
        <?= formatTimeAgo($comment['created_at']) ?>
      </p>
    </li>
  <?php } ?>
</ul>