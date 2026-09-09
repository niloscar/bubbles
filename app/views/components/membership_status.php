<?php

/**
 * Membership status component view
 */

$group = $data['group'] ?? null;
$isMember = $group['role'] !== null;
$requestPending = $group['membership_request_status'] ?? false;
$swedishRoleNames = [
  'admin' => 'Administratör',
  'member' => 'Medlem'
];

if ($isMember) {
  echo "<span class=\"pill success\">" . htmlspecialchars(translate($group['role'], $swedishRoleNames)) . "</span>";
} else {
  if ($requestPending) {
    echo "<span class=\"pill warning\">Din medlemsförfrågan behandlas</span>";
} else {
  ?>
    <form method="POST">
      <button name="action" value="request_membership">Ansök om medlemskap</button>
      <input type="hidden" name="group_id" value="<?= htmlspecialchars($group['id']) ?>">
    </form>
<? }
}
