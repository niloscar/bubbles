<?php
/**
 * Navigation main part
 */

  $pdo = db();
  $user = currentUser($pdo);

  $avatar = $user['avatar'] ?? './assets/icons/user.svg';

?>

  <nav class="nav-main">
    <div class="container">
      <ul>
<? foreach (NAV_MAIN as $page) { ?>
        <li><a href="?p=<?= $page['slug'] ?>"><?= $page['title'] ?></a></li>
<? }

if ($user) { ?>
        <li><a href="?a=logout">Logga ut</a></li>
        <li class="nav-avatar">
          <a href="?p=profile">
            <img 
              alt="Profil (<?= $user['username'] ?>)" 
              src="<?= $avatar ?>"
            >
          </a>
        </li>
<? } else { ?>
        <li><a href="?p=login">Logga in</a></li>
        <li><a href="?p=register">Registrera</a></li>
<? } ?>

      </ul>
    </div>
  </nav>