<?php
/**
 * Page group view
 */

$groupId = isset($_GET['gid']) 
  ? (int) $_GET['gid'] 
  : null;

if (!$groupId) {
  echo "<p>Ingen grupp vald.</p>";
  return;
}

$pdo = db();
$role = getGroupRole($pdo, $groupId);
?>

<? component('group_details') ?>

<?

if ($role === false) {
  echo "<p>Eftersom du inte är medlem i gruppen, är du inte behörig att ta del av eller delta i gruppens diskussioner. Ansök om att gå med i gruppen <a href='?p=join_group&gid=" . $groupId . "'>här</a>.</p>";
  return;
}

?>

<? component('group_threads') ?>