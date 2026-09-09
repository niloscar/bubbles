<?php

/**
 * Registration form component
 * 
 * @var array{errorMessages?: array<string>, formData?: array<string, string>} $data
 */

$errorMessages = $data['errorMessages'] ?? [];
$formData = $data['formData'] ?? [];

$formFields = [
    ['label' => 'Användarnamn', 'name' => 'username', 'type' => 'text', 'required' => true],
    ['label' => 'Mailadress', 'name' => 'email', 'type' => 'email', 'required' => true],
    ['label' => 'Lösenord', 'name' => 'password', 'type' => 'password', 'required' => true],
    ['label' => 'Bekräfta lösenord', 'name' => 'confirm_password', 'type' => 'password', 'required' => true],
];

?>

<form action="?p=register" method="post" class="form registration-form" novalidate>

    <? foreach ($formFields as $field) {
        component('form_field', [
            'field' => $field,
            'formData' => $formData,
            'errorMessages' => $errorMessages
        ]);
    } ?>

    <div class="form-actions n-cols-2">
        <button type="reset">Rensa</button>
        <button type="submit">Registrera</button>
    </div>

    <div class="full-grid-width">
        <?= displayFormErrorMessage($errorMessages, 'general') ?>
    </div>

    <p>Har du redan ett konto? <a href="?p=login">Logga in här.</a></p>

</form>