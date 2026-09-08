<?php

/**
 * Form field component, used for rendering form fields with error messages
 * 
 * @var array{field: array<string, mixed>, formData?: array<string, string>, errorMessages?: array<string>} $data
 */

$field = $data['field'];
$formData = $data['formData'] ?? [];
$errorMessages = $data['errorMessages'] ?? [];

$value = '';

if ($field['type'] !== 'password') {
    $value = htmlspecialchars($formData[$field['name']] ?? '');
}

$errorMessage = displayFormErrorMessage(
    $errorMessages,
    $field['name']
);

$errorClass = $errorMessage ? ' error' : '';
$requiredAttr = $field['required'] ? 'required' : '';

?>

<div class="form-field<?= $errorClass ?>">
    <label for="<?= $field['name'] ?>">
        <?= $field['label'] ?>
    </label>

    <input
        type="<?= $field['type'] ?>"
        id="<?= $field['name'] ?>"
        name="<?= $field['name'] ?>"
        value="<?= $value ?>"
        <?= $requiredAttr ?>
    >

    <?= $errorMessage ?>
</div>