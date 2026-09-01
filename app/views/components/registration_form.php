<?php

/**
 * Registration form component
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $requiredFields = ['username', 'email', 'password', 'confirm_password'];

  $swedishFields = [
    'username' => 'användarnamn',
    'email' => 'mail',
    'password' => 'lösenord',
    'confirm_password' => 'bekräfta lösenord'
  ];

  $errorMessages = [];
  $formData = [];

  foreach ($requiredFields as $field) {
    $value = $_POST[$field] ?? '';

    if (!is_string($value)) {
      $value = '';
    }

    if ($field !== 'password' && $field !== 'confirm_password') {
      $value = trim($value);
    }

    $formData[$field] = $value;

    if ($value === '') {
      $errorMessages[] = [
        "name" => $field,
        "text" => "Fältet \"$swedishFields[$field]\" är obligatoriskt."
      ];
    }
  }

  $usernameIsValid = preg_match('/^[a-zA-Z0-9_-]{3,30}$/', trim($formData['username'] ?? ''));

  if (!$usernameIsValid) {
    $errorMessages[] = [
      'name' => 'username',
      'text' => 'Användarnamnet får endast innehålla bokstäver, siffror, bindestreck och understreck.'
    ];
  }

  $emailIsValid = filter_var($formData['email'], FILTER_VALIDATE_EMAIL);

  if (!$emailIsValid) {
    $errorMessages[] = [
      'name' => 'email',
      'text' => 'Mailadressen är inte giltig.'
    ];
  }

  if (strlen($formData['password'] ?? '') < 8) {
    $errorMessages[] = [
      'name' => 'password',
      'text' => 'Lösenordet måste innehålla minst 8 tecken.'
    ];
  }

  if ($formData['password'] !== $formData['confirm_password']) {
    $errorMessages[] = [
      'name' => 'confirm_password',
      'text' => 'Lösenorden matchar inte.'
    ];
  }

  $pdo = db();

  if ($usernameIsValid && usernameExists($pdo, $formData['username'])) {
    $errorMessages[] = [
      'name' => 'username',
      'text' => 'Användarnamnet är upptaget.'
    ];
  }

  if ($emailIsValid && emailExists($pdo, $formData['email'])) {
    $errorMessages[] = [
      'name' => 'email',
      'text' => 'Mailadressen är upptagen.'
    ];
  }

  if (empty($errorMessages)) {
    $newUser = [
      'username' => $formData['username'],
      'email' => $formData['email'],
      'password_hash' => password_hash($formData['password'], PASSWORD_DEFAULT)
    ];

    try {
      $user = createUser($pdo, $newUser);

      echo "<p>Registreringen lyckades! Du kan nu logga in.</p>";
      component('login_form');
      exit;
    } catch (PDOException $e) {
      $errorMessages[] = [
        'name' => 'database',
        'text' => 'Ett fel uppstod vid registrering. Vänligen försök igen senare.'
      ];
    }
  }
}

function displayErrorMessage(array $errorMessages, $field = null)
{
  foreach ($errorMessages as $error) {
    if (($error['name'] ?? null) === $field) {
      return "<span class='error-message'>{$error['text']}</span>";
    }
  }

  return '';
}

function formField(array $field, array $errorMessages): void
{
  $value = htmlspecialchars($_POST[$field['name']] ?? '');
  $requiredAttr = $field['required'] ? 'required' : '';
  $errorMessage = displayErrorMessage($errorMessages, $field['name']);
  $errorClass = empty($errorMessage) ? '' : ' error';

  echo <<<HTML
    <div class="form-field{$errorClass}">
      <label for="{$field['name']}">{$field['label']}</label>
      <input 
        type="{$field['type']}" 
        id="{$field['name']}" 
        name="{$field['name']}" 
        value="{$value}" 
        $requiredAttr
      >
      $errorMessage
    </div>
  HTML;
}

$formFields = [
  ['label' => 'Användarnamn', 'name' => 'username', 'type' => 'text', 'required' => true],
  ['label' => 'Mailadress', 'name' => 'email', 'type' => 'email', 'required' => true],
  ['label' => 'Lösenord', 'name' => 'password', 'type' => 'password', 'required' => true],
  ['label' => 'Bekräfta lösenord', 'name' => 'confirm_password', 'type' => 'password', 'required' => true],
];


?>

<form action="?p=register" method="post" class="form registration-form" novalidate>

  <?php foreach ($formFields as $field) {
    formField($field, $errorMessages ?? []);
  } ?>

  <div class="form-actions n-cols-2">
    <button type="reset">Rensa</button>
    <button type="submit">Registrera</button>
  </div>

  <a href="?p=login">Har du redan ett konto? Logga in här.</a>

</form>