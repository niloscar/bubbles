<?php
/**
 * Registration field component
 */

$errorMessages = [];

if ($_POST) {  
  $requiredFields = ['username', 'email', 'password', 'confirm_password'];
  $swedishFields = ['username' => 'användarnamn', 'email' => 'mail', 'password' => 'lösenord', 'confirm_password' => 'bekräfta lösenord'];

  foreach ($requiredFields as $field) {
    if (empty($_POST[$field])) {
      $errorMessages[] = [
        "name" => $field,
        "text" => "Fältet '{$swedishFields[$field]}' är obligatoriskt."
        ];
    }
  }

  if (
    isset($_POST['password'], $_POST['confirm_password']) &&
    $_POST['password'] !== $_POST['confirm_password']
  ) {
    $errorMessages[] = [
      'name' => 'confirm_password',
      'text' => 'Lösenorden matchar inte.'
    ];
  }

  if (empty($errorMessages)) {
    $pdo = db();
    $existingUser = userExists($pdo, $_POST['username'], $_POST['email']);

    if ($existingUser) {
      $errorMessages[] = [
        'name' => 'username',
        'text' => 'Aliaset eller mailadressen är upptagen.'
      ];
    } else {
      echo "<p>Registrering lyckades! Du kan nu logga in.</p>";
    }
  }
}

function displayErrorMessage($errorMessages, $field = null) {
  foreach ($errorMessages as $error) {
    if (($error['name'] ?? null) === $field) {
      return $error['text'];
    }
  }

  return '';
}

?>

<form action="?p=register" method="post">
  <label for="username">Alias</label>
  <input type="text" id="username" name="username" required>
  <?= displayErrorMessage($errorMessages, 'username') ?>
  <br>

  <label for="email">E-post</label>
  <input type="email" id="email" name="email" required>
  <?= displayErrorMessage($errorMessages, 'email') ?>
  <br>

  <label for="password">Lösenord</label>
  <input type="password" id="password" name="password" required>
  <?= displayErrorMessage($errorMessages, 'password') ?>
  <br>

  <label for="confirm_password">Bekräfta lösenord</label>
  <input type="password" id="confirm_password" name="confirm_password" required>
  <?= displayErrorMessage($errorMessages, 'confirm_password') ?>
  <br>

  <input type="submit" value="Registrera">
</form>

