<?php

/**
 * Navigation main part
 */

$pdo = db();
$user = currentUser($pdo);

$avatar = $user['avatar'] ?? './assets/icons/user.svg';
$currentPage = $_GET['p'] ?? 'start';

function isActive(string $slug, string $currentPage): bool
{
  foreach (PAGES as $page) {
    if ($page['slug'] !== $currentPage) {
      continue;
    }

    return $slug === $currentPage
      || in_array($slug, $page['ancestors'], true);
  }

  return false;
}

?>

<nav class="nav-main">
  <div class="container v-padding-1">
    <ul>
      <?php foreach (NAV_MAIN as $page) { ?>
        <li>
          <a
            href="?p=<?= $page['slug'] ?>"
            class="<?= isActive($page['slug'], $currentPage) ? 'active' : '' ?>">
            <?= $page['title'] ?>
          </a>
        </li>
      <?
      }
      if ($user) { ?>
        <li><a href="?a=logout">Logga ut</a></li>
        <li class="nav-avatar">
          <a href="?p=profile">
            <img
              alt="Profil (<?= $user['username'] ?>)"
              src="<?= $avatar ?>">
          </a>
        </li>
      <? } else { ?>
        <li>
          <a
            href="?p=login"
            class="<?= $currentPage === 'login' ? 'active' : '' ?>">Logga in</a>
        </li>
      <? } ?>

    </ul>
  </div>
</nav>