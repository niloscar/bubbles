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

component('group_details', ['group' => $group]);

if (!$isMember) {
  echo "<p>Endast medlemmar kan ta del av eller delta i gruppens diskussioner.</p>";
  component('membership_status', ['group' => $group]);
}

if ($isAdmin) {
?>

<h2>Administrera gruppen</h2>

<h3>Medlemsförfrågningar</h3>
<? component('pending_requests_list', ['group_id' => $group['id']]); ?>

<?
}

if ($isMember) {
  component('group_threads');
}