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
$group = getGroupById($pdo, $groupId);
$role = getGroupRole($pdo, $groupId);

component('group_details', ['group' => $group]) ?>

<?

if ($role === false) {
  echo "<p>Eftersom du inte är medlem i gruppen, är du inte behörig att ta del av eller delta i gruppens diskussioner.</p>";
}

component('request_membership', ['group' => $group]) ?>

<? component('group_threads') ?>