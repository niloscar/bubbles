<?php
/**
 * Group details component
 */

  $groupId = isset($_GET['gid']) 
    ? (int) $_GET['gid'] 
    : null;

  if (!$groupId) {
    echo "<p>Ingen grupp vald.</p>";
    return;
  }

  $group = null;

  foreach (GROUPS as $item) {
    if ($item['id'] === $groupId) {
      $group = $item;
      break;
    }
  }

  if ($group === null) {
    echo "<p>Kunde inte hitta gruppen.</p>";
    return;
  }

?>

<h1><?= htmlspecialchars($group['name']) ?></h1>
<p><?= htmlspecialchars($group['description']) ?></p>