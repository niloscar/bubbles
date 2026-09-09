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
        "SELECT u.id, u.username, g.name
        FROM users AS u
        JOIN group_users AS gu ON gu.user_id = u.id
        JOIN groups AS g ON g.id = gu.group_id
        JOIN roles AS r ON r.id = gu.role_id
        WHERE u.id = :user_id 
        AND g.id = :group_id
        AND r.name = 'admin'"
    );

    $stmt->execute([
        'user_id' => $_SESSION['user_id'],
        'group_id' => $groupId
    ]);

    $user = $stmt->fetch();

    return (bool) $user['is_member'] ?? false;
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
