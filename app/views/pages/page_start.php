<?php
/**
 * Page start view
 */
?>

<h1><?= pageTitle() ?></h1>
<h2>Det här är startsidan</h2>

<h3>Grupper:</h3>
<? component('group_list') ?>