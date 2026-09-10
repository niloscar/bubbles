<?php

/**
 * Footer part
 */
?>

</div>
</main>
<footer class="page-footer">
  <div class="container">
    <section class="footer-branding">
      <a href="?p=home" class="footer-logo">
        <span><?= SITE_NAME ?></span>
        <i class="icon icon-chats-circle accent"></i>
      </a>
    </section>
    <section class="footer-links">
      <ul class="footer-links-list no-list-style">
        <? foreach (NAV_FOOTER as $link) { ?>
          <li>
            <a href="<?= htmlspecialchars($link['url']) ?>" target="_blank" rel="noopener noreferrer">
              <i class="icon icon-<?= htmlspecialchars($link['icon']) ?> accent-dk"></i>
              <span><?= htmlspecialchars($link['title']) ?></span>
            </a>
          </li>
        <? } ?>
      </ul>
    </section>
    <section class="footer-social">
      <ul class="footer-social-list no-list-style">
        <? foreach (NAV_CONTACT as $link) { ?>
          <li>
            <a href="<?= htmlspecialchars($link['url']) ?>" target="_blank" rel="noopener noreferrer">
              <i class="icon icon-<?= htmlspecialchars($link['icon']) ?> accent-dk"></i>
              <span><?= htmlspecialchars($link['title']) ?></span>
            </a>
          </li>
        <? } ?>
      </ul>
    </section>
    <section class="footer-legal">
      <p>Copyright &copy; <?= date('Y') ?> <?= SITE_NAME ?></p>
    </section>
  </div>
</footer>
</body>

</html>