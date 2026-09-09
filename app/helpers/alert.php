<?php

/**
 * Alert helper, used for displaying alert messages
 */

function displayAlert(string $message, string $type = 'info'): void
{
  $typeClass = match ($type) {
    'success' => 'alert-success',
    'error' => 'alert-error',
    'warning' => 'alert-warning',
    default => 'alert-info',
  };

  echo "<div class='alert $typeClass' role='alert'>$message</div>";
}