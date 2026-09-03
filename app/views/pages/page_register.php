<?php

/**
 * Page register view
 */

$data ??= [];

?>

<h1><?= pageTitle() ?></h1>

<? component('registration_form', $data); ?>