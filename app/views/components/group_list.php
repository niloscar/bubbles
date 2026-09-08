<?php
/**
 * Group list component
 */

$pdo = db();
$groups = getGroups($pdo);

if (empty($groups)) {
    echo 'Kunde inte hämta grupper.';
    return;
}

?>

<ul class="no-list-style group-list">
    <?php foreach ($groups as $group) { 
        $isMember = $group['role'] !== null;
        $requestPending = $group['membership_request_status'] ?? false;
        ?>
        <li>
            <h3>
              <a href="?p=group&gid=<?= urlencode($group['id']) ?>">
                <?= htmlspecialchars($group['name']) ?>
              </a>
            </h3>
            <p><?= htmlspecialchars($group['description']) ?></p>
            <ul class="no-list-style group-meta">
                <li>
                    <label>Senaste aktivitet:</label>
                    <span><?= formatTimeAgo(htmlspecialchars($group['last_activity'])) ?></span>
                </li>
                <li>
                    <label>Medlemmar:</label>
                    <span><?= htmlspecialchars($group['user_count']) ?></span>
                </li>
                <? if (isLoggedIn()) { ?>
                <li>
                    <label>Din roll:</label>
                    <? component('membership_status', ['group' => $group]) ?>
                </li>
                <? } ?>
            </ul>
        </li>
    <? } ?>
</ul>