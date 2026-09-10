<?php

/**
 * Create group form component
 */

$formFields = [
  [
    'name' => 'name',
    'label' => 'Gruppnamn',
    'type' => 'text',
    'required' => true,
    'placeholder' => 'Vad ska gruppen heta?',
  ],
  [
    'name' => 'description',
    'label' => 'Gruppbeskrivning',
    'type' => 'textarea',
    'required' => true,
    'placeholder' => 'Beskriv vad gruppen ska diskutera...',
  ]
];

?>
<form method="POST" class="form create-group-form no-labels" novalidate>
  <?php foreach ($formFields as $field) {
    component('form_field', [
      'field' => $field,
      'formData' => $data['formData'] ?? [],
      'errorMessages' => $data['errorMessages'] ?? [],
    ]);
  } ?>
  <?= displayFormErrorMessage($data['errorMessages'] ?? [], 'general') ?>
  <div class="form-actions">
    <button type="submit" name="action" value="create_group">
      <span>Skapa grupp</span>
      <i class="icon icon-plus"></i>
    </button>
  </div>
</form>