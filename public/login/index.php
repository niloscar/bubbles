<?php

/**
 * Login page
 */

$methodWhitelist = ['GET', 'POST'];

if (!in_array($_SERVER['REQUEST_METHOD'], $methodWhitelist)) {
    http_response_code(405);
    echo 'Method not allowed';
    exit;
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        echo 'GET request received';
        break;
    case 'POST':
        $missingParameters = [];

        if (empty($_POST['username'])) {
            $missingParameters[] = 'username';
        }

        if (empty($_POST['password'])) {
            $missingParameters[] = 'password';
        }

        if (!empty($missingParameters)) {
            http_response_code(400);
            echo 'Missing parameters: ' . implode(', ', $missingParameters);
            exit;
        }

        if ($_POST['username'] === 'me' && $_POST['password'] === 'test2') {
            session_start();
            $_SESSION['username'] = $_POST['username'];
            echo 'Login successful';
        } else {
            http_response_code(401);
            echo 'Invalid username or password';
        }

        break;
    case 'PATCH':
        echo 'PATCH request received';
        break;
    case 'PUT':
        echo 'PUT request received';
        break;
    case 'DELETE':
        echo 'DELETE request received';
        break;
    default:
        echo 'Unknown request method';
}

?>