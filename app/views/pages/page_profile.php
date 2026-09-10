<?php

/**
 * Page profile view
 */

$pdo = db();
$user = isset($_SESSION['user_id']) 
  ? getUserAndStatsById($pdo, (int) $_SESSION['user_id'])
  : null;

?>

<h1 class="h-size-1">
  <i class="icon icon-user"></i>
  <span>Din profil</span>
</h1>

<?php

  $profileFormFields = [
    'username' => [
      'label' => 'Användarnamn',
      'name' => 'username',
      'type' => 'text',
      'value' => $user['username'],
      'required' => true,
      'disabled' => true,
    ],
    'email' => [
      'label' => 'E-postadress',
      'name' => 'email',
      'type' => 'email',
      'value' => $user['email'],
      'required' => true,
      'disabled' => true,
    ],
    'fname' => [
      'label' => 'Förnamn',
      'name' => 'fname',
      'type' => 'text',
      'value' => $user['fname'],
      'required' => true,
      'disabled' => true,
    ],
    'lname' => [
      'label' => 'Efternamn',
      'name' => 'lname',
      'type' => 'text',
      'value' => $user['lname'],
      'required' => true,
      'disabled' => true,
    ],
    'avatar' => [
      'label' => 'Avatar (url)',
      'name' => 'avatar',
      'type' => 'text',
      'value' => $user['avatar'],
      'required' => false,
      'disabled' => true,
    ],
  ];

  $passwordFormFields = [
    'current_password' => [
      'label' => 'Nuvarande lösenord',
      'name' => 'current_password',
      'type' => 'password',
      'value' => '',
      'required' => true,
      'disabled' => true,
    ],
    'new_password' => [
      'label' => 'Nytt lösenord',
      'name' => 'new_password',
      'type' => 'password',
      'value' => '',
      'required' => true,
      'disabled' => true,
    ],
    'confirm_password' => [
      'label' => 'Bekräfta nytt lösenord',
      'name' => 'confirm_password',
      'type' => 'password',
      'value' => '',
      'required' => true,
      'disabled' => true,
    ],
  ];

?>
<ul class="no-list-style n-cols-2 first-col-auto">
  <li><label>Medlem sedan</label> <span><?= formatDateToText($user['registered_at']) ?></span></li>
  <li class="space-beneath"><label>Senaste inloggning</label> <span><?= $user['last_login'] ? formatTimeAgo($user['last_login']) : 'aldrig' ?></span></li>
  <li><label>Medlem i grupper</label> <span><?= $user['group_count'] ?> st</span></li>
  <li><label>Skapade trådar</label> <span><?= $user['thread_count'] ?> st</span></li>
  <li><label>Antal kommentarer</label> <span><?= $user['comment_count'] ?> st</span></li>
</ul>

<h2 class="h-size-3">Uppdatera profil</h2>
<form method="post" class="form profile-form">
  <? foreach ($profileFormFields as $fieldName => $field) { 
    $formData = [$fieldName => $field['value']];
    component('form_field', ['field' => $field, 'formData' => $formData, 'errorMessages' => []]);
  } ?>
  <div class="form-actions n-cols-2">
    <button type="reset" class="btn-accent-dk">
      <i class="icon icon-arrow-u-up-left"></i>
      <span>Återställ</span>
    </button>
    <button type="submit" disabled>
      <i class="icon icon-floppy-disk"></i>
      <span>Spara</span>
    </button>
  </div>
</form>

<h2 class="h-size-3">Ändra lösenord</h2>
<form method="post" class="form password-form">
  <? foreach ($passwordFormFields as $fieldName => $field) {
    component('form_field', ['field' => $field, 'formData' => [], 'errorMessages' => []]);
  } ?>
  <div class="form-actions">
    <button type="submit" disabled>
      <i class="icon icon-key"></i>
      <span>Ändra lösenord</span>
    </button>
  </div>
</form>

<?php

// ONTODO: Add a form for uploading and changing the user's avatar.

// ONTODO: Add a form for deleting the user's account.

// ONTODO: Add a list of the user's groups.

// ONTODO: Add a list of the user's latest comments.

?>