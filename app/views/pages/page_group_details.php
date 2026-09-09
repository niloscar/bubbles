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

$data = $data ?? [];

$pdo = db();
$group = getGroupById($pdo, $groupId);
$role = getGroupRole($pdo, $groupId);
$isMember = $role !== false;
$isAdmin = strtolower($role) === 'admin';

component('breadcrumbs', ['group' => $group]);

component('group_details', ['group' => $group]);
?>

<div class="group-content">

<? if (!$isMember) {
  $message = isLoggedIn() 
    ? 'Endast medlemmar kan delta i gruppens diskussioner.' 
    : 'Endast inloggade medlemmar kan delta i gruppens diskussioner. <a href="?p=login">Logga in</a>';

  displayAlert($message, 'info');

} ?>

<? if ($isAdmin) { ?>

<h2 class="h-size-3">Administrera gruppen</h2>

<h3 class="h-size-4">Medlemsförfrågningar</h3>
<? component('pending_requests_list', ['group_id' => $group['id']]); ?>

<? } ?>

<? if ($isMember) { ?>
  <section class="group-discussions">
    <h2 class="h-size-3">Diskussioner</h2>
    <? component('thread_list'); ?>
  </section>

  <section class="create-thread">
    <h2 class='h-size-3'>Starta en ny diskussion</h2>
    <? component('create_thread_form', $data); ?>
  </section>
<? } ?>
</div>