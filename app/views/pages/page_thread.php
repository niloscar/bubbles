<?php
/**
 * Page thread view
 */

$threadId = isset($_GET['tid']) 
  ? (int) $_GET['tid'] 
  : null;

if (!$threadId) {
  echo "<p>Ingen tråd vald.</p>";
  return;
}

$pdo = db();
$thread = getThreadById($pdo, $threadId);

if ($thread === false) {
  echo "<p>Kunde inte hitta tråden.</p>";
  return;
}

component('breadcrumbs', ['thread' => $thread]); 
?>
<h1 class="h-size-1"><?= $thread['subject'] ?></h1>
<p><?= $thread['text'] ?></p>