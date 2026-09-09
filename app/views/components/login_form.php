<?php

/**
 * Login form component
 */

$errorMessages = $data['errorMessages'] ?? [];
$formData = $data['formData'] ?? [];

$formFields = [
    [
        'name' => 'email',
        'label' => 'Mailadress',
        'type' => 'text',
        'required' => true,
    ],
    [
        'name' => 'password',
        'label' => 'Lösenord',
        'type' => 'password',
        'required' => true,
    ],
];

?>

<form action="?p=login" method="post" class="form login-form max-width align-center" novalidate>

    <h1 class="h-size-3">Logga in</h1>

    <? foreach ($formFields as $field) {
        component('form_field', [
            'field' => $field,
            'formData' => $formData,
            'errorMessages' => $errorMessages
        ]);
    } ?>

    <div class="form-actions">
        <button type="submit">Logga in</button>
    </div>

    <p>Har du inget konto? <a href="?p=register">Registrera dig här.</a></p>

    <? if (!empty($errorMessages['general'])) { ?>
        <div class="full-grid-width">
            <?= displayFormErrorMessage($errorMessages, 'general') ?>
        </div>
    <? } ?>
</form>