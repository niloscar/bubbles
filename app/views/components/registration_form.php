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

<form action="?p=register" method="post" class="form registration-form max-width align-center" novalidate>

    <h2 class="h-size-3">Registrera dig</h2>

    <? foreach ($formFields as $field) {
        component('form_field', [
            'field' => $field,
            'formData' => $formData,
            'errorMessages' => $errorMessages
        ]);
    } ?>

    <div class="form-actions n-cols-2">
        <button type="reset" class="btn-accent-dk">
            <i class="icon icon-backspace"></i>
            <span>Rensa</span>
        </button>
        <button type="submit">
            <i class="icon icon-key"></i>
            <span>Registrera</span>
        </button>
    </div>

    <p>Har du redan ett konto? <a href="?p=login">Logga in här.</a></p>

    <? if (!empty($errorMessages['general'])) { ?>
        <div class="full-grid-width">
            <?= displayFormErrorMessage($errorMessages, 'general') ?>
        </div>
    <? } ?>

</form>