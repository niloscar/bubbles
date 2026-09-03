<?php

/**
 * Header part
 */

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/index.css?v=<?= date(SANDBOX ? "ymd" : "His") ?>" />
  <title><?= SITE_NAME ?></title>
</head>

<body>
  <header class="page-header">
    <div class="container">
      <h1><?= SITE_NAME ?></h1>
      <? if (SANDBOX) { ?>
        <p style="color: red; font-weight: bold;">Sandbox</p>
      <? } ?>
    </div>
  </header>
  <? part('nav_main') ?>

  <main class="page-main">
    <div class="container">