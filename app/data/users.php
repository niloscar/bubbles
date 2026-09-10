<?php

/**
 * Users data
 */

const ROLE_ADMIN = 2;

function getUsers(PDO $pdo): array
{
  $stmt = $pdo->query(
    'SELECT id, fname, lname, username, email, avatar, registered_at
         FROM users
         ORDER BY fname, lname ASC'
  );

  return $stmt->fetchAll();
}

function getUserById(PDO $pdo, int $id): array|false
{
  $stmt = $pdo->prepare(
    'SELECT id, fname, lname, username, email, avatar, registered_at
         FROM users
         WHERE id = :id'
  );

  $stmt->execute(['id' => $id]);

  return $stmt->fetch();
}

function getUserAndStatsById(PDO $pdo, int $id): array|false
{
  $stmt = $pdo->prepare(
    'SELECT 
          u.id, 
          u.fname, 
          u.lname, 
          u.username, 
          u.email, 
          u.avatar, 
          u.registered_at, 
          u.last_login,

          (
              SELECT COUNT(*)
              FROM group_users AS gu
              WHERE gu.user_id = u.id
          ) AS group_count,

          (
              SELECT COUNT(*)
              FROM threads AS t
              WHERE t.user_id = u.id
          ) AS thread_count,

          (
              SELECT COUNT(*)
              FROM comments AS c
              WHERE c.user_id = u.id
          ) AS comment_count

      FROM users AS u
      WHERE u.id = :id'
  );

  $stmt->execute(['id' => $id]);

  return $stmt->fetch();
}

function usernameExists(PDO $pdo, string $username): bool
{
  $stmt = $pdo->prepare(
    'SELECT COUNT(id) FROM users
    WHERE username = :username'
  );

  $stmt->execute([
    'username' => $username
  ]);

  return $stmt->fetchColumn() > 0;
}

function emailExists(PDO $pdo, string $email): bool
{
  $stmt = $pdo->prepare(
    'SELECT COUNT(id) FROM users
    WHERE email = :email'
  );

  $stmt->execute([
    'email' => $email
  ]);

  return $stmt->fetchColumn() > 0;
}

function getUsersByGroupId(PDO $pdo, int $groupId): array
{
  $stmt = $pdo->prepare(
    'SELECT u.id, u.fname, u.lname, u.username, u.email, u.avatar, u.registered_at, gu.role_id, r.name AS "role"
         FROM users u
         INNER JOIN group_users gu ON u.id = gu.user_id
         INNER JOIN roles r ON gu.role_id = r.id
         WHERE gu.group_id = :group_id
         ORDER BY u.fname, u.lname ASC'
  );

  $stmt->execute(['group_id' => $groupId]);

  return $stmt->fetchAll();
}

function getAdminsByGroupId(PDO $pdo, int $groupId): array
{
  $stmt = $pdo->prepare(
    'SELECT u.id, u.fname, u.lname, u.username, u.email, u.avatar, u.registered_at
         FROM users u
         INNER JOIN group_users gu ON u.id = gu.user_id
         WHERE gu.group_id = :group_id AND gu.role_id = :admin_role_id
         ORDER BY u.fname, u.lname ASC'
  );

  $stmt->execute([
    'group_id' => $groupId,
    'admin_role_id' => ROLE_ADMIN
  ]);

  return $stmt->fetchAll();
}

function createUser(PDO $pdo, array $userData): array
{
  $stmt = $pdo->prepare(
    'INSERT INTO users (username, email, password_hash)
     VALUES (:username, :email, :password_hash)'
  );

  $stmt->execute([
    'username' => $userData['username'],
    'email' => $userData['email'],
    'password_hash' => $userData['password_hash']
  ]);

  $userId = (int) $pdo->lastInsertId();

  return [
    'id' => $userId,
    'username' => $userData['username'],
    'email' => $userData['email']
  ];
}