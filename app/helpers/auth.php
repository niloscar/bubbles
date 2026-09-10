<?php

/**
 * Auth helper, used for handling authentication and authorization
 */

function authenticateUser(PDO $pdo, string $email, string $password): array|null
{
    $stmt = $pdo->prepare(
        'SELECT id, username, email, password_hash
         FROM users
         WHERE email = :email'
    );

    $stmt->execute([
        'email' => $email
    ]);

    $user = $stmt->fetch();

    if (!$user) return null;

    $salt = getenv('SALT');
    if (!password_verify($password . $salt, $user['password_hash'])) {
        return null;
    }

    return $user;
}

function loginUser(array $user): void
{
    session_regenerate_id(true);

    $_SESSION['user_id'] = $user['id'];
}

function currentUser(PDO $pdo): array|null
{
    if (!isLoggedIn()) return null;

    $stmt = $pdo->prepare(
        'SELECT id, fname, lname, username, email, avatar, registered_at
         FROM users
         WHERE id = :id'
    );

    $stmt->execute([
        'id' => $_SESSION['user_id']
    ]);

    return $stmt->fetch();
}

function isLoggedIn(): bool
{
    return isset($_SESSION['user_id']);
}

function getGroupRole(PDO $pdo, int $groupId): string|bool
{
    if (!isLoggedIn()) return false;

    $stmt = $pdo->prepare(
        'SELECT r.name AS "role"
            FROM group_users AS gu
            JOIN roles AS r ON r.id = gu.role_id
            WHERE gu.user_id = :user_id
            AND gu.group_id = :group_id'
    );

    $stmt->execute([
        'user_id' => $_SESSION['user_id'],
        'group_id' => $groupId
    ]);

    $role = $stmt->fetchColumn();

    return ($role !== false) ? (string) $role : false;
}

function isGroupAdmin(PDO $pdo, int $groupId): bool
{
    if (!isLoggedIn()) return false;

    $stmt = $pdo->prepare(
        "SELECT 1
        FROM group_users AS gu
        JOIN roles AS r ON r.id = gu.role_id
        WHERE gu.user_id = :user_id
          AND gu.group_id = :group_id
          AND r.name = 'Admin'
        LIMIT 1"
    );

    $stmt->execute([
        'user_id' => $_SESSION['user_id'],
        'group_id' => $groupId
    ]);

    return (bool) $stmt->fetchColumn();
}

function updateLastLogin(PDO $pdo, int $userId): void
{
    $stmt = $pdo->prepare(
        'UPDATE users
         SET last_login = CURRENT_TIMESTAMP
         WHERE id = :user_id'
    );

    $stmt->execute([
        'user_id' => $userId
    ]);
}

function requireLogin(): void
{
    if (!isLoggedIn()) {
        header('Location: ?p=login');
        exit;
    }
}

function requireThreadAccess(int $threadId): array
{
    requireLogin();

    $pdo = db();
    $thread = getThreadByIdWithComments($pdo, $threadId);

    if (!$thread) pageNotFound();

    if (getGroupRole($pdo, (int) $thread['group_id']) === false) {
        http_response_code(403);
        exit;
    }

    return $thread;
}
