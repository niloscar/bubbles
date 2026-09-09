<?php

/**
 * Registration action, handles the registration form submission
 */

function handleRegisterRequest(): array
{
    $errorMessages = [];
    $formData = [];

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return [
            'errorMessages' => $errorMessages,
            'formData' => $formData
        ];
    }

    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if (!is_string($username)) $username = '';
    if (!is_string($email)) $email = '';
    if (!is_string($password)) $password = '';
    if (!is_string($confirmPassword)) $confirmPassword = '';

    $username = $formData['username'] = trim($username); // Store in formData for prefilling the form in case of errors.
    $email = $formData['email'] = trim($email);

    $requiredFields = [
        'username' => $username,
        'email' => $email,
        'password' => $password,
        'confirm_password' => $confirmPassword
    ];

    foreach ($requiredFields as $field => $value) {
        if ($value === '') {
            $errorMessages[$field] = 'Fältet är obligatoriskt.';
        }
    }

    if ($username !== '' && !preg_match('/^[a-zA-Z0-9_-]{3,30}$/', $username)) {
        $errorMessages['username'] = 'Användarnamnet får endast innehålla 3–30 bokstäver, siffror, bindestreck och understreck.';
    }

    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessages['email'] = 'Mailadressen är inte giltig.';
    }

    if ($password !== '' && strlen($password) < 8) {
        $errorMessages['password'] = 'Lösenordet måste innehålla minst 8 tecken.';
    }

    if ($password !== '' && $confirmPassword !== '' && $password !== $confirmPassword) {
        $errorMessages['confirm_password'] = 'Lösenorden matchar inte.';
    }

    $pdo = db();

    if ($username !== '' && usernameExists($pdo, $username)) {
        $errorMessages['username'] = 'Användarnamnet är upptaget.';
    }

    if ($email !== '' && filter_var($email, FILTER_VALIDATE_EMAIL) && emailExists($pdo, $email)) {
        $errorMessages['email'] = 'Mailadressen är upptagen.';
    }

    if (empty($errorMessages)) {
        $salt = getenv('SALT');
        $newUser = [
            'username' => $username,
            'email' => $email,
            'password_hash' => password_hash(
                $password . $salt,
                PASSWORD_DEFAULT
            )
        ];

        try {
            createUser($pdo, $newUser);

            header('Location: ?p=login&registered=1');
            exit;
        } catch (PDOException $e) {
            $errorMessages['general'] = 'Ett fel uppstod vid registrering. Vänligen försök igen senare.';
        }
    }

    return [
        'errorMessages' => $errorMessages,
        'formData' => $formData
    ];
}