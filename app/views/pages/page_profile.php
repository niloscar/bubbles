<?php

/**
 * Page profile view
 */

$pdo = db();
$user = isset($_SESSION['user_id']) 
  ? getUserAndStatsById($pdo, (int) $_SESSION['user_id'])
  : null;

?>

<h1><?= pageTitle() ?> för <?= $user['username'] ?></h1>

<?php

  $profileFormFields = [
    'username' => [
      'label' => 'Användarnamn',
      'type' => 'text',
      'value' => $user['username'],
      'required' => true,
    ],
    'email' => [
      'label' => 'E-postadress',
      'type' => 'email',
      'value' => $user['email'],
      'required' => true,
    ],
    'fname' => [
      'label' => 'Förnamn',
      'type' => 'text',
      'value' => $user['fname'],
      'required' => true,
    ],
    'lname' => [
      'label' => 'Efternamn',
      'type' => 'text',
      'value' => $user['lname'],
      'required' => true,
    ],
    'avatar' => [
      'label' => 'Avatar (url)',
      'type' => 'text',
      'value' => $user['avatar'],
      'required' => false,
    ],
  ];

  $passwordFormFields = [
    'current_password' => [
      'label' => 'Nuvarande lösenord',
      'type' => 'password',
      'value' => '',
      'required' => true,
    ],
    'new_password' => [
      'label' => 'Nytt lösenord',
      'type' => 'password',
      'value' => '',
      'required' => true,
    ],
    'confirm_password' => [
      'label' => 'Bekräfta nytt lösenord',
      'type' => 'password',
      'value' => '',
      'required' => true,
    ],
  ];

?>
<ul class="no-list-style n-cols-2 first-col-auto">
  <li><label>Medlem sedan</label> <span><?= formatDate($user['registered_at']) ?></span></li>
  <li><label>Senaste inloggning</label> <span><?= $user['last_login'] ? $user['last_login'] : 'aldrig' ?></span></li>
  <li><label>Medlem i grupper</label> <span><?= $user['group_count'] ?> st</span></li>
  <li><label>Skapade trådar</label> <span><?= $user['thread_count'] ?> st</span></li>
  <li><label>Antal kommentarer</label> <span><?= $user['comment_count'] ?> st</span></li>
</ul>

<h2>Uppdatera profil</h2>
<form method="post" class="form profile-form">
  <? foreach ($profileFormFields as $fieldName => $field) { ?>
    <div class="form-field">
      <label for="<?= $fieldName ?>"><?= $field['label'] ?></label>
      <input type="<?= $field['type'] ?>" id="<?= $fieldName ?>" name="<?= $fieldName ?>" value="<?= $field['value'] ?>" <?= $field['required'] ? 'required' : '' ?>>
    </div>
  <? } ?>
  <div class="form-actions n-cols-2">
    <button type="reset">Återställ</button>
    <button type="submit">Spara</button>
  </div>
</form>

<h2>Ändra lösenord</h2>
<form method="post" class="form password-form">
  <? foreach ($passwordFormFields as $fieldName => $field) { ?>
    <div class="form-field">
      <label for="<?= $fieldName ?>"><?= $field['label'] ?></label>
      <input type="<?= $field['type'] ?>" id="<?= $fieldName ?>" name="<?= $fieldName ?>" value="<?= $field['value'] ?>" <?= $field['required'] ? 'required' : '' ?>>
    </div>
  <? } ?>
  <div class="form-actions">
    <button type="submit">Uppdatera lösenord</button>
  </div>
</form>

<?php

// ONTODO: Add a form for displaying and updating the user's information.

// ONTODO: Add a form for changing the user's password.

// ONTODO: Add a form for uploading and changing the user's avatar.

// ONTODO: Add a form for deleting the user's account.

// ONTODO: Add a list of the user's groups.

// ONTODO: Add a list of the user's latest comments.

component('pending_requests_list');