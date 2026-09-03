<?php

/**
 * Page login view
 */

$data ??= [];

?>

<h1><?= pageTitle() ?></h1>

<? component('login_form', $data); ?>