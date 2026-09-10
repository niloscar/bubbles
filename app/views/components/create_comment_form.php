<?php

/**
 * Create comment form component
 */

$threadId = isset($_GET['tid'])
  ? (int) $_GET['tid']
  : null;

if (!$threadId) return;

$formFields = [
  [
    'name' => 'text',
    'label' => 'Kommentar',
    'type' => 'textarea',
    'required' => true,
    'placeholder' => 'Skriv din kommentar...',
  ]
];

?>
<form method="POST" class="form create-comment-form no-labels" novalidate>
  <input type="hidden" name="thread_id" value="<?= htmlspecialchars((string) $threadId) ?>">

  <?php foreach ($formFields as $field) {
    component('form_field', [
      'field' => $field,
      'formData' => $data['formData'] ?? [],
      'errorMessages' => $data['errorMessages'] ?? [],
    ]);
  } ?>

  <?= displayFormErrorMessage($data['errorMessages'] ?? [], 'general') ?>

  <div class="form-actions">
    <button type="submit" name="action" value="create_comment">
      <i class="icon icon-paper-plane-tilt"></i>
      <span>Skicka kommentar</span>
    </button>
  </div>
</form>