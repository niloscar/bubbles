<?php

/**
 * Page start view
 */

?>
<h1 class="h-size-1">Välkommen till <?= SITE_NAME ?></h1>
<p><?= SITE_NAME ?> är en webbplats där du kan skapa och gå med i grupper, starta trådar och delta i diskussioner.</p>

<? if (!isLoggedIn()) { ?>
  <p>För att kunna delta i diskussioner och skapa grupper måste du vara inloggad. Om du inte har ett konto kan du registrera dig nedan.</p>
  <h2 class="h-size-3">Registrera dig</h2>
  <? component('registration_form'); ?>
<? } else { 
    $pdo = db();
    $userid = $_SESSION['user_id'];
    $groups = getGroupsByUserId($pdo, $userid);

    if (count($groups) === 0) {
        echo "<p>Du är inte medlem i några grupper. Gå med i en grupp eller skapa en ny.</p>";
    } else {
      ?>
  <h2 class="h-size-3">Starta en ny diskussion</h2>
  <? component('create_thread_form', ['groups' => $groups]);
    }
  ?>

<? } ?>