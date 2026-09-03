<?php

/**
 * Group details component
 */


$data ??= [];
$group = $data['group'];

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
<p class="group-meta">Skapad <?= formatDateToText($group['created_at']) ?></p>
<p class="group-meta"><?= count($group['admins']) === 1 ? 'Administratör:' : count($group['admins']) . ' Administratörer:' ?></p>

<ul>
  <?php foreach ($group['admins'] as $admin) { ?>
    <li>
      <a href="?p=user&amp;uid=<?= urlencode($admin['id']) ?>">
        <?= htmlspecialchars($admin['fname'] . ' ' . $admin['lname']) ?>
      </a>
    </li>
  <?php } ?>
</ul>