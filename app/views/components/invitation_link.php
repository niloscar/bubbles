<?php

/**
 * Invitation link component view
 */

$group = $data['group'] ?? null;

$invitationLink = $_SESSION['generated_invitation_link'] ?? null;
//unset($_SESSION['generated_invitation_link']);
if (!$invitationLink) { ?>
  <form method="POST">
    <button class="small" type="submit">
      <i class="icon icon-link"></i>
      <span>Generera länk</span>
    </button>
    <input type="hidden" name="action" value="create_membership_invitation">
    <input type="hidden" name="group_id" value="<?= $group['id'] ?>">
  </form>
<? } else { ?>
  <div class="invitation-link-container">
    <a id="invitation-link" href="<?= htmlspecialchars($invitationLink) ?>" class="invitation-link"><?= htmlspecialchars($invitationLink) ?></a>
    <button type="button" class="small copy-invitation-link-btn" id="copy-invitation-link-btn">
      <i class="icon icon-copy"></i>
    </button>
  </div>
<? } ?>

<script type="text/javascript">
  const copyButton = document.querySelector('#copy-invitation-link-btn');

  if (copyButton) {
    const icon = copyButton.querySelector('i');

    copyButton.addEventListener('click', async function() {
      const invitationLink = document.querySelector('#invitation-link');

      if (!invitationLink) return;

      try {
        await navigator.clipboard.writeText(invitationLink.textContent.trim());

        icon.classList.remove('icon-copy');
        icon.classList.add('icon-check');

        setTimeout(function() {
          icon.classList.remove('icon-check');
          icon.classList.add('icon-copy');
        }, 2000);
      } catch (error) {
        console.error('Kunde inte kopiera länken:', error);
      }
    });
  }
</script>