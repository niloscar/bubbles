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
    <?php foreach ($groups as $group) { ?>
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
            </ul>
            <? component('request_membership', ['group' => $group]) ?>
        </li>
    <? } ?>
</ul>