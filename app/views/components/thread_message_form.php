<?php

/**
 * Group message form component
 */

  $pdo = db();
  $groupId = isset($_GET['gid'])
    ? (int) $_GET['gid']
    : null;

  $role = getGroupRole($pdo, $groupId);

?>

<form method="post" class="form group-message-form" novalidate>
  <div class="form-field">
    <label for="message">Meddelande</label>

    <textarea
      id="message"
      name="message"
      required
      <?= ($role !== false) ? '' : 'disabled' ?>
    >
    </textarea>
  </div>

  <div class="form-actions">
    <button 
      type="submit"
      <?= ($role !== false) ? '' : 'disabled' ?>
    >
      Skicka
    </button>
  </div>
</form>