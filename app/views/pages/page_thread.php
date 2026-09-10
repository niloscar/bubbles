<?php
/**
 * Page thread view
 */

$threadId = isset($_GET['tid']) 
  ? (int) $_GET['tid'] 
  : null;

if (!$threadId) {
  echo "<p>Ingen tråd vald.</p>";
  return;
}

$data = $data ?? [];

$pdo = db();
$thread = getThreadByIdWithComments($pdo, $threadId);

if ($thread === false) {
  echo "<p>Kunde inte hitta tråden.</p>";
  return;
}

component('breadcrumbs', ['thread' => $thread]); 
?>
<div class="thread">
  <section class="thread-start">
    <div class="thread-start-body">
      <h1 class="h-size-1"><?= $thread['subject'] ?></h1>
      <?= formatUserText($thread['text']) ?>
    </div>
    <div class="thread-start-meta">
      <i class="icon icon-pulse"></i>
      <?= formatTimeAgo($thread['created_at']) ?>
      av
      <strong><a href="?p=user&uid=<?= urlencode($thread['user_id']) ?>"><?= htmlspecialchars($thread['username']) ?></a></strong>
    </div>
  </section>

  <section class="thread-comments">
    <? component('comment_list', ['thread' => $thread]); ?>
  </section>

  <section class="create-comment">
    <? component('create_comment_form', $data); ?>
  </section>
</div>