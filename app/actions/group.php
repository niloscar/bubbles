<?php

/**
 * Group actions
 */

function handleCreateGroupRequest(): array
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

    $groupName = trim($_POST['name'] ?? '');
    $groupDescription = trim($_POST['description'] ?? '');

    $formData = [
        'name' => $groupName,
        'description' => $groupDescription
    ];

    if ($groupName === '') $errorMessages['name'] = 'Du måste ange ett namn på gruppen.';
    if ($groupDescription === '') $errorMessages['description'] = 'Du måste ange en beskrivning.';

    if ($errorMessages) {
        return [
            'errorMessages' => $errorMessages,
            'formData' => $formData
        ];
    }

    $pdo = db();
    $userId = (int) $_SESSION['user_id'];

    try {
        $groupId = createGroup($pdo, $groupName, $groupDescription, $userId);
    } catch (Throwable $e) {
        $errorMessages['general'] = $e->getMessage();

        $errorMessages['general'] = 'Gruppen kunde inte skapas. Försök igen.';

        return [
            'errorMessages' => $errorMessages,
            'formData' => $formData
        ];
    }

    header('Location: ?p=group&gid=' . urlencode($groupId));
    exit;
}