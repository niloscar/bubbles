<?php

/**
 * Membership invitation (hotlink) page view
 */

$invite = $data['invite'] ?? null;

if ($invite['used']) {
  displayAlert('Inbjudningslänken har redan använts.', 'error');
  return;
}

$expiresAt = new DateTime($invite['expires_at']);
$now = new DateTime();
$timeDiff = $expiresAt->getTimestamp() - $now->getTimestamp();

if ($timeDiff <= 0) {
  displayAlert('Tidsgränsen för inbjudningslänken har gått ut.', 'warning');
  return;
}

?>
<div class="page-membership-invitation">
  <h1 class="h-size-1 text-center">Inbjudan</h1>
  <p class="text-center">
    Du har blivit inbjuden till gruppen
    <strong><a href="?p=group&gid=<?= urlencode($invite['group_id']) ?>"><?= htmlspecialchars($invite['group_name']) ?></a></strong>
    av användaren
    <strong><a href="?p=user&uid=<?= urlencode($invite['inviter_id']) ?>"><?= htmlspecialchars($invite['inviter_username']) ?></a></strong>.
  </p>
  <? if (!isLoggedIn()) { ?>
    <p class="text-center">För att kunna acceptera inbjudan måste du vara inloggad.</p>
  <? } ?>
  <p class="invitation-expiration">Länken är giltig i <span id="countdown"><?= formatSecondsToText($timeDiff) ?></span>.</p>
  <form class="form form-invitation" method="POST">
    <input type="hidden" name="action" value="accept_membership_invitation">
    <input type="hidden" name="token" value="<?= htmlspecialchars($invite['token']) ?>">
    <div class="form-actions">
      <button class="btn btn-accept" <?= (!isLoggedIn()) ? 'disabled' : '' ?>>Acceptera inbjudan</button>
    </div>
  </form>
</div>

<script type="text/javascript">
  const countdownElement = document.getElementById('countdown')
  let remainingSeconds = <?php echo $timeDiff; ?>

  updateCountdown() // Run immediately to avoid delay before the first update
  setInterval(updateCountdown, 1000)

  function updateCountdown() {
    if (remainingSeconds <= 0) {
      location.reload()
      return
    }

    const counter = {
      hours: Math.floor(remainingSeconds / 3600),
      minutes: Math.floor((remainingSeconds % 3600) / 60),
      seconds: remainingSeconds % 60
    }

    const SWEDISH_PLURAL_RULES = {
      hours: ['timme', 'timmar'],
      minutes: ['minut', 'minuter'],
      seconds: ['sekund', 'sekunder']
    }

    const pluralize = (value, singular, plural) => {
      return value + ' ' + (value === 1 ? singular : plural)
    }

    const parts = Object.entries(counter)
      .filter(([, value]) => value > 0)
      .map(([key, value]) => {
        const [singular, plural] = SWEDISH_PLURAL_RULES[key]
        return pluralize(value, singular, plural)
      })

    const formatList = (items) => {
      if (items.length <= 1) return items.join('')

      return items.slice(0, -1).join(', ') + ' och ' + items.at(-1)
    }

    countdownElement.textContent = formatList(parts)

    remainingSeconds--
  }
</script>