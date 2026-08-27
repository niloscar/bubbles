<nav>
  <ul>
    <? foreach (NAV_MAIN as $page) { ?>
      <li><a href="?p=<?= $page['slug'] ?>"><?= $page['title'] ?></a></li>
    <? } ?>
  </ul>
</nav>