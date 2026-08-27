<?php
/**
 * Group details component
 */

$groupId = isset($_GET['gid'])
  ? (int) $_GET['gid']
  : null;

$pdo = db();
$group = getGroupById($pdo, $groupId);

if ($group === false) {
  echo "<p>Kunde inte hitta gruppen.</p>";
  return;
}

$group['users'] = getUsersByGroupId($pdo, $groupId);

?>

<h1><?= htmlspecialchars($group['name']) ?></h1>
<p>Beskrivning: <?= htmlspecialchars($group['description']) ?></p>
<p>Skapad: <?= formatDateToText($group['created_at']) ?></p>
<ul>
  <?php foreach ($group['users'] as $user) { ?>
    <li>
      <a href="?p=user&amp;uid=<?= urlencode($user['id']) ?>">
        <?= htmlspecialchars($user['fname'] . ' ' . $user['lname']) ?>
        <?= $user['role'] === 'Admin' ? '(admin)' : '' ?>
      </a>
    </li>
  <?php } ?>
</ul>