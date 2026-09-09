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
        <li class="group-list-item">
            <h3>
              <a href="?p=group&gid=<?= urlencode($group['id']) ?>">
                <?= htmlspecialchars($group['name']) ?>
              </a>
            </h3>
            <p><?= htmlspecialchars($group['description']) ?></p>
            <? component('group_meta', ['group' => $group]); ?>
        </li>
    <? } ?>
</ul>