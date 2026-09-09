<?php

/**
 * Comment actions
 */

function handleCreateCommentRequest(): int
{
  if (!isLoggedIn()) {
    header('Location: ?p=login');
    exit;
  }

  echo "Creating comment...";
  
  return 0; // Placeholder return value, replace with actual comment ID after creation
}