<?php

/**
 * Admin list component view
 */

$group = $data['group'] ?? null;

if (!$group) return;

?>
<p class="group-meta">
  <?= count($group['admins']) === 1 
    ? 'Administratör:' 
    : count($group['admins']) . ' Administratörer:' ?>
</p>

<ul class="no-list-style inline-list group-admins">
  <? foreach ($group['admins'] as $admin) { ?>
    <li>
      <a class="avatar" href="?p=user&uid=<?= urlencode($admin['id']) ?>" title="<?= htmlspecialchars($admin['username']) ?>">
        <img src="<?= htmlspecialchars(getAvatarUrl($admin)) ?>" alt="<?=  htmlspecialchars($admin['username']) ?>">
      </a>
    </li>
  <? } ?>
</ul>