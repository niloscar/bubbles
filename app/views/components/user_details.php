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
  $user = getUserAndStatsById($pdo, $userId);

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

<h1 class="h-size-1"><?= htmlspecialchars($user['username']) ?></h1>
<ul class="no-list-style n-cols-2 first-col-auto">
  <li><label>Namn</label> <span><?= htmlspecialchars($user['fname'] . ' ' . $user['lname']) ?></span></li>
  <li class="space-beneeth"><label>E-postadress</label> <span><?= htmlspecialchars($user['email']) ?></span></li>
  <li><label>Medlem sedan</label> <span><?= formatDateToText($user['registered_at']) ?></span></li>
  <li class="space-beneeth"><label>Senaste inloggning</label> <span><?= $user['last_login'] ? formatTimeAgo($user['last_login']) : 'aldrig' ?></span></li>
  <li><label>Medlem i grupper</label> <span><?= $user['group_count'] ?> st</span></li>
  <li><label>Skapade trådar</label> <span><?= $user['thread_count'] ?> st</span></li>
  <li><label>Antal kommentarer</label> <span><?= $user['comment_count'] ?> st</span></li>
</ul>
<h2 class="h-size-3">Grupper</h2>
<? if (empty($groups)) { ?>
  <p><?= htmlspecialchars($user['username']) ?> är inte medlem i några grupper.</p>
<? } else { ?>
<ul class="no-list-style">
  <? foreach ($groups as $group) { ?>
    <li><a href="?p=group&gid=<?= urlencode($group['id']) ?>"><?= htmlspecialchars($group['name']) ?></a></li>
  <? } ?>
</ul>
<? } ?>