<?php

/**
 * Thread actions
 */

function handleCreateThreadRequest(): int
{
  if (!isLoggedIn()) {
    header('Location: ?p=login');
    exit;
  }

  echo "Creating thread...";

  return 0; // Placeholder return value, replace with actual thread ID after creation
}