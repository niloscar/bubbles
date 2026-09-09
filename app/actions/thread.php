<?php

/**
 * Thread actions
 */

function handleCreateThreadRequest(): array
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

    $groupId = (int) ($_POST['group_id'] ?? 0);
    $subject = trim($_POST['subject'] ?? '');
    $text = trim($_POST['text'] ?? '');

    $formData = [
        'group_id' => $groupId,
        'subject' => $subject,
        'text' => $text
    ];

    if ($groupId <= 0) $errorMessages['group_id'] = 'Du måste välja en grupp.';
    if ($subject === '') $errorMessages['subject'] = 'Du måste ange en rubrik.';
    if ($text === '') $errorMessages['text'] = 'Du måste skriva ett inlägg.';

    if ($errorMessages) {
        return [
            'errorMessages' => $errorMessages,
            'formData' => $formData
        ];
    }

    $pdo = db();
    $userId = (int) $_SESSION['user_id'];

    try {
        $threadId = createThread($pdo, $groupId, $userId, $subject, $text);
    } catch (RuntimeException $e) {
        $errorMessages['group_id'] = $e->getMessage();

        return [
            'errorMessages' => $errorMessages,
            'formData' => $formData
        ];
    } catch (Throwable $e) {
        $errorMessages['general'] = 'Tråden kunde inte skapas. Försök igen.';

        return [
            'errorMessages' => $errorMessages,
            'formData' => $formData
        ];
    }

    header('Location: ?p=thread&tid=' . urlencode($threadId));
    exit;
}