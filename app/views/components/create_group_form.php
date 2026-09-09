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
var_dump($data['errorMessages'] ?? []);
?>
<form method="POST" class="form create-group-form no-labels" novalidate>
  <?php foreach ($formFields as $field) {
    component('form_field', [
      'field' => $field,
      'formData' => $data['formData'] ?? [],
      'errorMessages' => $data['errorMessages'] ?? [],
    ]);
  } ?>
  <div class="form-actions">
    <button type="submit" name="action" value="create_group">Skapa grupp</button>
  </div>

  <?= displayFormErrorMessage($data['errorMessages'] ?? [], 'general') ?>
</form>