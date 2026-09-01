<?php
/**
 * Navigation main part
 */
?>

  <nav class="nav-main">
    <div class="container">
      <ul>
<? foreach (NAV_MAIN as $page) { ?>
        <li><a href="?p=<?= $page['slug'] ?>"><?= $page['title'] ?></a></li>
<? } ?>
      </ul>
    </div>
  </nav>