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
      $userIsMember = strtolower($user['role']) === 'member';
      $userIsAdmin = strtolower($user['role']) === 'admin';
      ?>
      <li>
        <a href="?p=user&uid=<?= urlencode($user['id']) ?>"><?= htmlspecialchars($user['username']) ?></a>
          <form method="POST" class="handle-member-form">
            <input type="hidden" name="action" value="remove_member">
            <input type="hidden" name="group_id" value="<?= $group['id'] ?>">
            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
            <select name="role" class="role-select small" <?= $userIsAdmin ? 'disabled' : '' ?>>
              <option value="member" <?= $userIsMember ? 'selected' : '' ?>>Medlem</option>
              <option value="admin" <?= $userIsAdmin ? 'selected' : '' ?>>Admin</option>
            </select>
            <button type="submit" class="remove-member-button icon-btn small" <?= $userIsAdmin ? 'disabled' : '' ?>>
              <i class="icon icon-trash error-bg"></i>
            </button>
          </form>
      </li>
    <? } ?>
  </ul>

<h3 class="h-size-4">Inbjudningslänk</h3>

  <? if (!$invitationLink) { ?>
  <form method="POST">
    <button class="small" type="submit">
      <i class="icon icon-link"></i>
      <span>Generera länk</span>
    </button>
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

<script type="text/javascript">
  document.addEventListener('DOMContentLoaded', function() {
    const handleMemberForms = document.querySelectorAll('.handle-member-form');
    handleMemberForms.forEach(function(form) {
      const roleSelect = form.querySelector('.role-select');
      const removeMemberButton = form.querySelector('.remove-member-button');

      roleSelect.addEventListener('change', function() {
        form.submit();
      });
      removeMemberButton.addEventListener('click', function(event) {
        event.preventDefault();
        // ONTODO: Custom confirmation dialog
        if (confirm('Är du säker på att du vill ta bort den här medlemmen?')) {
          form.submit();
        }
      });
    });
  });
</script>