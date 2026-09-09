<?php

/**
 * Group details component
 */

$group = $data['group'] ?? null;

if ($group === false) {
  echo "<p>Kunde inte hitta gruppen.</p>";
  return;
}

$groupId = $group['id'];
$pdo = db();

$group['users'] = getUsersByGroupId($pdo, $groupId);

$group['admins'] = array_filter(
    $group['users'],
    fn ($user) => strtolower($user['role']) === 'admin'
);

?>

<h1><?= htmlspecialchars($group['name']) ?></h1>

<p class="group-description"><?= htmlspecialchars($group['description']) ?></p>
<!-- <p class="group-meta">Skapad <?= formatDateToText($group['created_at']) ?></p> -->
<? component('admin_list', ['group' => $group]); ?>
<? component('group_meta', ['group' => $group]); ?>