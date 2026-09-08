<?php

/**
 * Membership invitation (hotlink) page view
 * 
 * @var array{invite: array} $data
 */

$invite = $data['invite'];

if ($invite['used']) {
  echo "<p>Inbjudningslänken har redan använts.</p>";
  return;
}

$expiresAt = new DateTime($invite['expires_at']);
$now = new DateTime();
$timeDiff = $expiresAt->getTimestamp() - $now->getTimestamp();

if ($timeDiff <= 0) {
  echo "<p>Tidsgränsen för inbjudningslänken har gått ut.</p>";
  return;
}

?>
<h1 class="h-size-1">Inbjudan till grupp</h1>
<p>
  Du har blivit inbjuden till gruppen 
  <strong><a href="?p=group&gid=<?= urlencode($invite['group_id']) ?>"><?= htmlspecialchars($invite['group_name']) ?></a></strong> 
  av användaren 
  <a href="?p=user&uid=<?= urlencode($invite['inviter_id']) ?>"><?= htmlspecialchars($invite['inviter_username']) ?></a>.
</p>
<form>
  <button class="btn btn-accept">Acceptera inbjudan</button>
</form>
<p class="invitation-expiration">Länken är giltig i ytterligare <span id="countdown"><?= formatSecondsToText($timeDiff) ?></span>.</p>

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