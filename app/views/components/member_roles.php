<?php

/**
 * Member roles component view
 */

$users = $data['users'] ?? [];
$group = $data['group'] ?? null;

$numAdmins = count(array_filter($users, fn ($user) => isAdmin($user['role'])));

?>
<ul class="no-list-style group-members">
  <? foreach ($users as $user) {
    $userIsMember = strtolower($user['role']) === 'member';
    $userIsAdmin = isAdmin($user['role']);
  ?>
    <li>
      <a href="?p=user&uid=<?= urlencode($user['id']) ?>">
        <?= htmlspecialchars($user['username']) ?>
      </a>

      <form method="POST" class="role-form">
        <input type="hidden" name="action" value="update_member_role">
        <input type="hidden" name="group_id" value="<?= $group['id'] ?>">
        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">

        <select name="role" class="role-select small" <?= $userIsAdmin && $numAdmins <= 1 ? 'disabled' : '' ?> title="Ändra roll">
          <option value="member" <?= $userIsMember ? 'selected' : '' ?>>Medlem</option>
          <option value="admin" <?= $userIsAdmin ? 'selected' : '' ?>>Admin</option>
        </select>
      </form>

      <form method="POST" class="remove-member-form">
        <input type="hidden" name="action" value="remove_member">
        <input type="hidden" name="group_id" value="<?= $group['id'] ?>">
        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">

        <button
          type="submit"
          class="remove-member-btn icon-btn small" <?= $userIsAdmin ? 'disabled' : '' ?>
          title="Ta bort <?= htmlspecialchars($user['username']) ?> från gruppen">
          <i class="icon icon-trash error"></i>
        </button>
      </form>
    </li>
  <? } ?>
</ul>