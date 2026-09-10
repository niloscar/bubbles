<?php

/**
 * Navigation main part
 */

$pdo = db();
$user = currentUser($pdo);

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
    <div class="nav-main-branding">
      <a href="?p=start" class="nav-main-logo">
        <i class="icon icon-chats-circle accent"></i>
      </a>
    </div>
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
              src="<?= getAvatarUrl($user) ?>">
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