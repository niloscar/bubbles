<?php

/**
 * Request membership component view
 */

$data ??= [];
$group = $data['group'];

if ($group['role']) { ?>
  <br><small>Din roll: <?= htmlspecialchars($group['role']) ?></small>
  <? } else {
  if ($group['membership_request_status'] === 'pending') { ?>
    <br><small>Din medlemsförfrågan är under behandling.</small>
  <? } else { ?>
    <form method="POST"">
                    <button name=" action" value="request_membership">Ansök om medlemskap</button>
      <input type="hidden" name="group_id" value="<?php echo htmlspecialchars($group['id']); ?>">
    </form>
<? }
}
