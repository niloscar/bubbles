<?php

/**
 * Login form component
 */

?>

<form action="?p=login" method="post" class="form login-form" novalidate>
  <div class="form-field">
    <label for="email">Mailadress</label>
    <input type="text" id="email" name="email" required>
  </div>
  <div class="form-field">
    <label for="password">Lösenord</label>
    <input type="password" id="password" name="password" required>
  </div>
  <div class="form-actions">
    <button type="submit">Logga in</button>
  </div>
</form>