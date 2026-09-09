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

<? if ($isAdmin) { 

$invitationLink = $_SESSION['generated_invitation_link'] ?? null;
unset($_SESSION['generated_invitation_link']);

$users = getUsersByGroupId($pdo, $groupId);
  
?>
<section class="group-admin">
  <h2 class="h-size-3">Administrera</h2>

  <h3 class="h-size-4">Medlemsförfrågningar</h3>
  <? component('pending_requests_list', ['group_id' => $group['id']]); ?>

  <h3 class="h-size-4">Hantera medlemmar</h3>
  <ul class="no-list-style group-members">
    <? foreach ($users as $user) { 
      $isMember = strtolower($user['role']) === 'member';
      $isAdmin = strtolower($user['role']) === 'admin';
      ?>
      <li>
        <a href="?p=user&uid=<?= urlencode($user['id']) ?>"><?= htmlspecialchars($user['username']) ?></a>
          <form method="POST" class="remove-member-form">
            <input type="hidden" name="action" value="remove_member">
            <input type="hidden" name="group_id" value="<?= $group['id'] ?>">
            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
            <select name="role" class="role-select small" <?= $isAdmin ? 'disabled' : '' ?>>
              <option value="member" <?= $isMember ? 'selected' : '' ?>>Medlem</option>
              <option value="admin" <?= $isAdmin ? 'selected' : '' ?>>Admin</option>
            </select>
            <button type="submit" class="small" <?= $isAdmin ? 'disabled' : '' ?>>Ta bort medlem</button>
          </form>
      </li>
    <? } ?>
  </ul>

<h3 class="h-size-4">Inbjudningslänk</h3>

  <? if (!$invitationLink) { ?>
  <form method="POST">
    <button class="small" type="submit">Generera länk</button>
    <input type="hidden" name="action" value="create_membership_invitation">
    <input type="hidden" name="group_id" value="<?= $group['id'] ?>">
  </form>
  <? } else { ?>
    <a id="invitation-link" href="<?= htmlspecialchars($invitationLink) ?>" class="invitation-link" readonly><?= htmlspecialchars($invitationLink) ?></a>
  <? } ?>

</section>
<? } ?>

<? if ($isMember) { ?>
  <section class="group-discussions">
    <h2 class="h-size-3">Diskussioner</h2>
    <? component('thread_list'); ?>
  </section>

  <section class="create-thread">
    <h2 class='h-size-2 text-center'>Starta en ny diskussion</h2>
    <? component('create_thread_form', $data); ?>
  </section>
<? } ?>
</div>