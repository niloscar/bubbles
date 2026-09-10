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

function isAdmin(string $role)
{
  return strtolower($role) === 'admin';
}

$data = $data ?? [];

$pdo = db();
$group = getGroupById($pdo, $groupId);
$role = getGroupRole($pdo, $groupId);
$isMember = $role !== false;
$isAdmin = isAdmin($role);

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

  <? if ($isAdmin) {

    $users = getUsersByGroupId($pdo, $groupId);

  ?>
    <section class="group-admin">
      <h2 class="h-size-3">
        <i class="icon icon-gear"></i>
        <span>Administrera</span>
      </h2>

      <h3 class="h-size-4">Medlemsförfrågningar</h3>
      <? component('pending_requests_list', ['group_id' => $group['id']]); ?>

      <h3 class="h-size-4">Hantera medlemmar</h3>
      <? component('member_roles', ['users' => $users, 'group' => $group]); ?>

      <h3 class="h-size-4">Inbjudningslänk</h3>
      <? component('invitation_link', ['group' => $group]); ?>

    </section>
  <? } ?>

  <? if ($isMember) { ?>
    <section class="group-discussions">
      <h2 class="h-size-3">
        <i class="icon icon-chats-circle"></i>
        <span>Diskussioner</span>
      </h2>
      <? component('thread_list'); ?>
    </section>

    <section class="create-thread">
      <h2 class='h-size-2 text-center'>
        <i class="icon icon-chats-circle"></i>
        <span>Starta en ny diskussion</span>
      </h2>
      <? component('create_thread_form', $data); ?>
    </section>
  <? } ?>
</div>

<script type="text/javascript">
  document.querySelectorAll('.role-form .role-select').forEach(function(select) {
    select.addEventListener('change', function() {
      select.form.requestSubmit();
    });
  });

  document.querySelectorAll('.remove-member-form').forEach(function(form) {
    form.addEventListener('submit', function(event) {
      if (!confirm('Är du säker på att du vill ta bort den här medlemmen?')) {
        event.preventDefault();
      }
    });
  });
</script>