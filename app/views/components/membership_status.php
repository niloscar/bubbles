<?php

/**
 * Membership status component view
 * 
 * @var array{group: array} $data
 */

$group = $data['group'];
$isMember = $group['role'] !== null;
$requestPending = $group['membership_request_status'] ?? false;

if ($isMember) {
  echo "<span>" . htmlspecialchars($group['role']) . "</span>";
} else {
  if ($requestPending) {
    echo "<span>Din medlemsförfrågan är under behandling.</span>";
} else {
  ?>
    <form method="POST">
      <button name="action" value="request_membership">Ansök om medlemskap</button>
      <input type="hidden" name="group_id" value="<?php echo htmlspecialchars($group['id']); ?>">
    </form>
<? }
}
