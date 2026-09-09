<?php

/**
 * Alert helper, used for displaying alert messages
 */

function displayAlert(string $message, string $type = 'info'): void
{
  $typeClass = match ($type) {
    'success' => 'success',
    'error' => 'error',
    'warning' => 'warning',
    default => 'info',
  };

  echo "<div class='alert $typeClass' role='alert'>$message</div>";
}