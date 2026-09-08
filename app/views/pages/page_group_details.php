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
$isMember = $role !== false;
$isAdmin = strtolower($role) === 'admin';

component('breadcrumbs', ['group' => $group]);

component('group_details', ['group' => $group]);

if (!$isMember) {
  echo "<p>Endast medlemmar kan ta del av eller delta i gruppens diskussioner.</p>";
  if (isLoggedIn()) {
    component('membership_status', ['group' => $group]);
  } else {
    echo "<a href='?p=login'>Logga in</a>";
  }
}

if ($isAdmin) {
?>

<h2 class="h-size-3">Administrera gruppen</h2>

<h3 class="h-size-4">Medlemsförfrågningar</h3>
<? component('pending_requests_list', ['group_id' => $group['id']]); ?>

<?
}

if ($isMember) {
  component('group_threads');
}