<?php
/**
 * Page group view
 */
?>

<h1>Grupper</h1>

<? component('group_list') ?>

<? if (!isLoggedIn()) { ?>
  <p class="alert alert-info">Du måste vara inloggad för att kunna skapa eller gå med i grupper.<br /><a href="?p=login">Logga in</a></p>
<? } ?>


<? if (isLoggedIn()) { ?>
<h2>Skapa ny grupp</h2>
  <!-- // ONTODO: Add a form for creating a new group.
  // component('create_group_form'); -->
<? } ?>