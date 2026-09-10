<?php

/**
 * Breadcrumbs component view
 */

$group = $data['group'] ?? null;
$thread = $data['thread'] ?? null;
?>

<nav class="nav-breadcrumbs">

  <? if (!$group && !$thread) { ?>

    <h1 class="h-size-inherit">Grupper</h1>

  <? } else { ?>

    <a href="?p=groups">Grupper</a>
    <i class="icon icon-arrow-right"></i>

    <?
    $groupId = $group['id'] ?? $thread['group_id'];
    $groupName = $group['name'] ?? $thread['group_name'];

    if ($thread) { ?>

      <a href="?p=group&amp;gid=<?= urlencode($groupId) ?>"><?= htmlspecialchars($groupName) ?></a>
      <i class="icon icon-arrow-right"></i>
      <span><?= htmlspecialchars($thread['subject']) ?></span>

    <? } else { ?>

      <span><?= htmlspecialchars($groupName) ?></span>

  <? }
  } ?>

</nav>