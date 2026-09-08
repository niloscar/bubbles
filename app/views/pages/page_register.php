<?php

/**
 * Page register view
 * 
 * @var array{error?: string} $data
 */

?>
<h1><?= pageTitle() ?></h1>

<? component('registration_form', $data);