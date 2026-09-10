<?php

/**
 * Form field component, used for rendering form fields with error messages
 */

$field = $data['field'] ?? [];
$formData = $data['formData'] ?? [];
$errorMessages = $data['errorMessages'] ?? [];

$value = '';

if ($field['type'] !== 'password') {
    $value = $formData[$field['name']] ?? '';
}

$errorMessage = displayFormErrorMessage(
    $errorMessages,
    $field['name']
);

$errorClass = $errorMessage ? ' error' : '';
$requiredAttr = $field['required'] ? 'required' : '';
$disabledAttr = isset($field['disabled']) && $field['disabled'] ? 'disabled' : '';
$placeholderAttr = !empty($field['placeholder'])
    ? 'placeholder="' . htmlspecialchars($field['placeholder']) . '"'
    : '';

?>

<div class="form-field<?= $errorClass ?>">
    <label for="<?= htmlspecialchars($field['name']) ?>">
        <?= htmlspecialchars($field['label']) ?>
    </label>

    <?php if ($field['type'] === 'textarea') { ?>

        <textarea
            id="<?= htmlspecialchars($field['name']) ?>"
            name="<?= htmlspecialchars($field['name']) ?>"
            <?= $placeholderAttr ?>
            <?= $requiredAttr ?>><?= htmlspecialchars((string) $value) ?></textarea>

    <?php } elseif ($field['type'] === 'select') {

        $options = $field['options'] ?? [];

        if ($value !== '') {
            $selectedValue = $value;
        } elseif (count($options) === 1) {
            $selectedValue = $options[0]['value'];
        } else {
            $selectedValue = '';
        }
    ?>

        <select
            id="<?= htmlspecialchars($field['name']) ?>"
            name="<?= htmlspecialchars($field['name']) ?>"
            <?= $requiredAttr ?>>

            <?php if (count($options) > 1 && !empty($field['default'])) { ?>
                <option value="" disabled <?= $selectedValue === '' ? 'selected' : '' ?>>
                    <?= htmlspecialchars($field['default']) ?>
                </option>
            <?php } ?>

            <?php foreach ($options as $option) { ?>
                <option
                    value="<?= htmlspecialchars((string) $option['value']) ?>"
                    <?= (string) $selectedValue === (string) $option['value'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($option['label']) ?>
                </option>
            <?php } ?>

        </select>

    <?php } else { ?>

        <input
            type="<?= htmlspecialchars($field['type']) ?>"
            id="<?= htmlspecialchars($field['name']) ?>"
            name="<?= htmlspecialchars($field['name']) ?>"
            value="<?= htmlspecialchars((string) $value) ?>"
            <?= $placeholderAttr ?>
            <?= $disabledAttr ?>
            <?= $requiredAttr ?>>

    <?php } ?>

    <?= $errorMessage ?>
</div>