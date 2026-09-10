<?php

/**
 * Page start view
 */

?>
<div class="page-start text-center">

  <div class="welcome-message">
    <h1 class="h-size-1">Välkommen till <?= SITE_NAME ?> <i class="icon icon-chats-circle accent-dk"></i></h1>
    <p><?= SITE_NAME ?> är en webbplats där du kan skapa och gå med i grupper, starta trådar och delta i diskussioner.</p>
    <? if (!isLoggedIn()) { ?>
      <p>För att kunna delta i diskussioner och skapa grupper måste du vara inloggad.<br>Om du inte har ett konto kan du registrera dig nedan.</p>
    <? } ?>
  </div>

  <? if (!isLoggedIn()) { ?>

    <? component('registration_form'); ?>

    <? } else {
    $pdo = db();
    $userid = $_SESSION['user_id'];
    $groups = getGroupsByUserId($pdo, $userid);

    if (count($groups) === 0) { ?>
      <p>Du är inte medlem i några grupper. Gå med i en grupp eller skapa en ny.</p>
    <? } else { ?>
      <section>
        <h2 class="h-size-2">
          <i class="icon icon-pulse"></i>
          <span>Senaste aktivitet i dina grupper</span>
        </h2>
        <? component('latest_activity', ['groups' => $groups]); ?>
      </section>
      <section>
        <h2 class="h-size-2">
          <i class="icon icon-chats-circle"></i>
          <span>Starta en ny diskussion</span>
        </h2>
        <? component('create_thread_form', ['groups' => $groups]); ?>
      </section>
  <? }
  } ?>
</div>