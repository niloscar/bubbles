<?php

/**
 * Login action, handles the login form submission and user authentication
 */

function handleLoginRequest(): array
{
    $errorMessages = [];
    $formData = [];
    $user = null;

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return [
            'errorMessages' => $errorMessages,
            'formData' => $formData
        ];
    }

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!is_string($email)) $email = '';
    if (!is_string($password)) $password = '';

    $email = $formData['email'] = trim($email); // Store in formData for prefilling the form in case of errors.

    $requiredFields = [
        'email' => $email,
        'password' => $password,
    ];

    foreach ($requiredFields as $field => $value) {
        if ($value === '') {
            $errorMessages[$field] = 'Fältet är obligatoriskt.';
        }
    }

    if (empty($errorMessages)) {
        $pdo = db();
        $user = authenticateUser($pdo, $email, $password);

        if (!$user) {
            $errorMessages['general'] = 'Fel mailadress eller lösenord. Vänligen försök igen.';
        } else {
            loginUser($user);
            updateLastLogin($pdo, (int) $user['id']);

            header('Location: ?p=start');
            exit;
        }
    }

    return [
        'errorMessages' => $errorMessages,
        'formData' => $formData
    ];
}