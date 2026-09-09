<?php

/**
 * Create thread form component
 */

$groups = $data['groups'] ?? [];

$groupOptions = array_map(
  fn($group) => [
    'value' => $group['id'],
    'label' => $group['name'],
  ],
  $groups
);

if (empty($groupOptions) && !isset($_GET['gid'])) return;

$preselectedGroupId = isset($_GET['gid']) ? (int) $_GET['gid'] : null;
$preselectedGroup = $preselectedGroupId !== null;

$formFields = [
  [
    'name' => 'group_id',
    'label' => 'Grupp',
    'type' => 'select',
    'options' => $groupOptions,
    'required' => true,
    'default' => 'Välj en grupp',
  ],
  [
    'name' => 'subject',
    'label' => 'Ämne',
    'type' => 'text',
    'required' => true,
    'placeholder' => 'Vad vill du diskutera?',
  ],
  [
    'name' => 'text',
    'label' => 'Text',
    'type' => 'textarea',
    'required' => true,
    'placeholder' => 'Skriv ditt meddelande här...',
  ]
];

?>
<form method="POST" class="form create-thread-form no-labels" novalidate>

  <? if ($preselectedGroup) { ?>
    <input type="hidden" name="group_id" value="<?= htmlspecialchars((string) $preselectedGroupId) ?>">
  <? } ?>

  <? foreach ($formFields as $field) {
    if ($field['name'] === 'group_id' && $preselectedGroup) continue;

    component('form_field', [
      'field' => $field,
      'formData' => $data['formData'] ?? [],
      'errorMessages' => $data['errorMessages'] ?? [],
    ]);
  } ?>

  <?= displayFormErrorMessage($data['errorMessages'] ?? [], 'general') ?>

  <div class="form-actions">
    <button type="submit" name="action" value="create_thread">
      Skapa diskussionstråd
    </button>
  </div>
</form>