<?php

/**
 * Group meta component
 */

$group = $data['group'] ?? null;

$users = $group['users'] ?? [];
$userList = array_map(fn ($user) => htmlspecialchars($user['username']), $users);

?>
<ul class="no-list-style group-meta">
    <li class="membership-status">
        <?=  isLoggedIn() ? component('membership_status', ['group' => $group]) : '<a href="?p=login">Logga in för att ansöka</a>' ?>
    </li>
    <li>
        <label title="Senaste aktivitet">
            <i class="icon icon-pulse"></i>
        </label>
        <span><?= ($group['last_activity'] !== null) ? formatTimeAgo(htmlspecialchars($group['last_activity'])) : 'Ingen aktivitet' ?></span>
    </li>
    <li title="<?= implode(', ', $userList) ?>">
        <label title="Medlemmar">
            <i class="icon icon-users"></i>
        </label>
        <span><?= htmlspecialchars($group['user_count']) ?></span>
    </li>
</ul>