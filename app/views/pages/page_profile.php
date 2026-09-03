<?php

/**
 * Page profile view
 */

$pdo = db();


$user = isset($_SESSION['user_id']) 
  ? getUserById($pdo, (int) $_SESSION['user_id'])
  : null;

var_dump($user);

?>

<h1><?= pageTitle() ?></h1>
<h2>Det här är profilsidan för <?= $user['username'] ?></h2>

<?php

// ONTODO: Add a form for displaying and updating the user's information.

// ONTODO: Add a form for changing the user's password.

// ONTODO: Add a form for uploading and changing the user's avatar.

// ONTODO: Add a form for deleting the user's account.

// ONTODO: Add a list of the user's groups.

// ONTODO: Add a list of the user's latest comments.