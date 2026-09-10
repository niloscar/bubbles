<?php

/**
 * Comment list component view
 */

$thread = $data['thread'] ?? null;

if (!$thread) return;

$comments = $thread['comments'] ?? [];

if (empty($comments)) {
  displayAlert("Det här inlägget har inga kommentarer än. Bli den första att kommentera.", "info");
  return;
}

?>
<ul class="no-list-style comment-list">
  <?php foreach ($comments as $comment) { ?>
    <li class="comment-list-item">
      <a class="avatar comment-avatar" href="?p=user&uid=<?= urlencode($comment['user_id']) ?>" title="<?= htmlspecialchars($comment['username']) ?>">
        <img src="<?= htmlspecialchars(getAvatarUrl($comment)) ?>" alt="<?= htmlspecialchars($comment['username']) ?>">
      </a>
      <div class="comment-content">
        <div class="comment-body">
          <?= formatUserText($comment['text']) ?>
        </div>
        <div class="comment-meta">
          <i class="icon icon-pulse"></i>
          <?= formatTimeAgo($comment['created_at']) ?>
          av
          <strong><a href="?p=user&uid=<?= urlencode($comment['user_id']) ?>"><?= htmlspecialchars($comment['username']) ?></a></strong>
        </div>
      </div>
    </li>
  <? } ?>
</ul>