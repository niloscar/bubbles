<?php

/**
 * Page group view
 */

$data = $data ?? [];

?>

<? component('breadcrumbs', ['group' => null]); ?>

<? if (!isLoggedIn()) { ?>
  <p class="alert alert-info">Du måste vara inloggad för att kunna skapa eller gå med i grupper. <a href="?p=login">Logga in</a></p>
<? } ?>

<? component('group_list') ?>

<? if (isLoggedIn()) { ?>
  <h2 class="h-size-3">Skapa en ny grupp</h2>
  <? component('create_group_form', $data) ?>
<? } ?>