<?php

/**
 * Page start view
 */

?>
<div class="page-start text-center">
  <h1 class="h-size-1">Välkommen till <?= SITE_NAME ?></h1>
  <p class="text-center"><?= SITE_NAME ?> är en webbplats där du kan skapa och gå med i grupper, starta trådar och delta i diskussioner.</p>

  <? if (!isLoggedIn()) { ?>

    <p class="text-center">För att kunna delta i diskussioner och skapa grupper måste du vara inloggad.<br>Om du inte har ett konto kan du registrera dig nedan.</p>

    <? component('registration_form'); ?>

    <? } else {
    $pdo = db();
    $userid = $_SESSION['user_id'];
    $groups = getGroupsByUserId($pdo, $userid);

    if (count($groups) === 0) { ?>
      <p>Du är inte medlem i några grupper. Gå med i en grupp eller skapa en ny.</p>
    <? } else { ?>
      <section>
        <h2 class="h-size-2">Senaste aktivitet i dina grupper</h2>
        <? component('latest_activity', ['groups' => $groups]); ?>
      </section>
      <section>
        <h2 class="h-size-2">Starta en ny diskussion</h2>
        <? component('create_thread_form', ['groups' => $groups]); ?>
      </section>
  <? }
  } ?>
</div>