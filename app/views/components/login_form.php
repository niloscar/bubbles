<?php

/**
 * Login form component
 */

$data ??= [];

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

<form action="?p=login" method="post" class="form login-form" novalidate>

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

    <? if (!empty($errorMessages['general'])) { ?>
        <div class="full-grid-width">
            <?= displayFormErrorMessage($errorMessages, 'general') ?>
        </div>
    <? } ?>

    <p>Har du inget konto? <a href="?p=register">Registrera dig här</a>.</p>
</form>