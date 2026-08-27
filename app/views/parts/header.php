<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/index.css?v=<?=date("ymd") ?>" />
  <title><?= SITE_NAME ?></title>
</head>
<body>
  <div id="page">
    <header>
      <h1><?= SITE_NAME ?></h1>
    </header>
    <? part('nav_main') ?>