<?php

/**
 * Comment actions
 */

function handleCreateCommentRequest(): array
{
  if (!isLoggedIn()) {
    header('Location: ?p=login');
    exit;
  }

  $errorMessages = [];
  $formData = [];

  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    return [
      'errorMessages' => $errorMessages,
      'formData' => $formData
    ];
  }

  $threadId = (int) ($_POST['thread_id'] ?? 0);
  $text = trim($_POST['text'] ?? '');

  $formData = [
    'thread_id' => $threadId,
    'text' => $text
  ];

  if ($threadId <= 0) $errorMessages['general'] = 'Ingen giltig tråd angiven.';
  if ($text === '') $errorMessages['text'] = 'Du måste skriva en kommentar.';

  if ($errorMessages) {
    return [
      'errorMessages' => $errorMessages,
      'formData' => $formData
    ];
  }

  $pdo = db();
  $userId = (int) $_SESSION['user_id'];

  try {
    $commentId = createComment($pdo, $threadId, $userId, $text);
  } catch (RuntimeException $e) {
    $errorMessages['general'] = $e->getMessage();

    return [
      'errorMessages' => $errorMessages,
      'formData' => $formData
    ];
  } catch (Throwable $e) {
    $errorMessages['general'] = 'Kommentaren kunde inte skapas. Försök igen.';

    return [
      'errorMessages' => $errorMessages,
      'formData' => $formData
    ];
  }

  header('Location: ?p=thread&tid=' . urlencode($threadId) . '#comment-' . urlencode($commentId));
  exit;
}
