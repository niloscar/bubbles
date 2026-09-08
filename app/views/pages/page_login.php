<?php

/**
 * Page login view
 * 
 * @var array{error?: string} $data
 */

?>
<h1><?= pageTitle() ?></h1>

<? component('login_form', $data); ?>