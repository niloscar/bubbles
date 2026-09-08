<?php

/**
 * Page login view
 * 
 * @var array{error?: string} $data
 */

?>
<h1 class="h-size-1"><?= pageTitle() ?></h1>

<? component('login_form', $data); ?>