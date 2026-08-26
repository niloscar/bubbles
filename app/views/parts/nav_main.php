<nav>
  <ul>
    <? foreach (PAGES as $page) { ?>
      <li><a href="?p=<?= $page['slug'] ?>"><?= $page['title'] ?></a></li>
    <? } ?>
  </ul>
</nav>