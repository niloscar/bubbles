<?php

/**
 * User details component
 */

  $userId = isset($_GET['uid']) 
    ? (int) $_GET['uid'] 
    : null;

  if (!$userId) {
    echo "<p>Ingen användare vald.</p>";
    return;
  }

  $pdo = db();
  $user = getUserById($pdo, $userId);

  if ($user === false) {
    echo "<p>Kunde inte hitta användaren.</p>";
    return;
  }

  $groups = getGroupsByUserId($pdo, $userId);
  // if (!empty($groups)) {
  //   $a = [];

  //   foreach ($groups as $group) {
  //     $a[] = '<a href="?p=group&amp;gid=' . urlencode($group['id']) . '">' . htmlspecialchars($group['name']) . '</a>';
  //   }
  //   $groups = (count($a)) ? implode(', ', $a) : "{$user['alias']} är inte medlem i några grupper.";
  // }

?>

<h1><?= htmlspecialchars($user['username']) ?></h1>
<p><?= htmlspecialchars($user['fname'] . ' ' . $user['lname']) ?></p>
<p><?= htmlspecialchars($user['email']) ?></p>
<p>Skapad för <?= formatTimeAgo(htmlspecialchars($user['registered_at'])) ?></p>
<p>Medlem i:</p>
<? if (empty($groups)) { ?>
  <p><?= htmlspecialchars($user['username']) ?> är inte medlem i några grupper.</p>
<? } else { ?>
<ul>
  <? foreach ($groups as $group) { ?>
    <li><a href="?p=group&gid=<?= urlencode($group['id']) ?>"><?= htmlspecialchars($group['name']) ?></a></li>
  <? } ?>
</ul>
<? } ?>