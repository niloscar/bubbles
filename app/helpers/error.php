<?php

/**
 * Error helper, used for handling errors and exceptions
 */

function displayFormErrorMessage(array $errorMessages, $field = null)
{
  foreach ($errorMessages as $error) {
    if (($error['field'] ?? null) === $field) {
      return "<span class='error-message'>{$error['message']}</span>";
    }
  }

  return '';
}