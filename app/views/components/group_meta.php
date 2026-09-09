<?php

/**
 * Group meta component
 */

$group = $data['group'] ?? null;

$users = $group['users'] ?? [];
$userList = array_map(fn ($user) => htmlspecialchars($user['username']), $users);

?>
<ul class="no-list-style group-meta">
    <? if (isLoggedIn()) { ?>
    <li class="membership-status">
        <? component('membership_status', ['group' => $group]) ?>
    </li>
    <? } ?>
    <li>
        <label>Senaste aktivitet:</label>
        <span><?= ($group['last_activity'] !== null) ? formatTimeAgo(htmlspecialchars($group['last_activity'])) : 'Ingen aktivitet' ?></span>
    </li>
    <li title="<?= implode(', ', $userList) ?>">
        <label>Medlemmar:</label>
        <span><?= htmlspecialchars($group['user_count']) ?></span>
    </li>
</ul>