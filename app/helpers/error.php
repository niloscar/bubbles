<?php

/**
 * Error helper, used for handling errors and exceptions
 */

function displayFormErrorMessage(array $errorMessages, $field = null)
{
  if (!isset($errorMessages[$field])) return '';

  return "<span class='error-message'>{$errorMessages[$field]}</span>";
}

function pageNotFound(): void
{
    http_response_code(404);
    echo "<h1>404 Not Found</h1>";
    echo "<p>Sidan du försöker nå finns inte.</p>";
    exit;
}