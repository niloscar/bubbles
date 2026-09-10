<?php

/**
 * Group membership request data functions
 */

function createMembershipRequest(PDO $pdo, int $groupId, int $userId): bool
{
  $stmt = $pdo->prepare('
    INSERT INTO membership_requests (user_id, group_id)

      SELECT candidate.user_id, candidate.group_id
      FROM (
        SELECT :user_id AS user_id, :group_id AS group_id
      ) AS candidate

      WHERE NOT EXISTS (
        SELECT 1
        FROM group_users AS gu
        WHERE gu.user_id = candidate.user_id
          AND gu.group_id = candidate.group_id
      )

      AND NOT EXISTS (
        SELECT 1
        FROM membership_requests AS gmr
        WHERE gmr.user_id = candidate.user_id
          AND gmr.group_id = candidate.group_id
          AND gmr.status = \'pending\'
      )
  ');

  $stmt->execute([
    'user_id' => $userId,
    'group_id' => $groupId
  ]);

  return $stmt->rowCount() === 1;
}

function getPendingMembershipRequests(PDO $pdo, ?int $groupId = null): array|false
{
  $status = 'pending';

  $stmt = $pdo->prepare('
    SELECT 
      mr.id, 
      mr.user_id, 
      u.username, 
      mr.group_id, 
      g.name AS group_name,
      mr.created_at
      FROM membership_requests AS mr
    JOIN users AS u ON mr.user_id = u.id
    JOIN groups AS g ON mr.group_id = g.id
    WHERE status = :status
    AND mr.group_id = :group_id
  ');

  $stmt->execute([
    'status' => $status,
    'group_id' => $groupId
  ]);

  return $stmt->fetchAll();
}

function getMembershipRequestById(PDO $pdo, int $requestId): array|false
{
  $stmt = $pdo->prepare('
    SELECT 
      mr.id, 
      mr.user_id, 
      u.username, 
      mr.group_id, 
      g.name AS group_name,
      mr.status,
      mr.created_at
    FROM membership_requests AS mr
    JOIN users AS u ON mr.user_id = u.id
    JOIN groups AS g ON mr.group_id = g.id
    WHERE mr.id = :request_id
  ');

  $stmt->execute([
    'request_id' => $requestId
  ]);

  return $stmt->fetch();
}

function approveMembershipRequest(PDO $pdo, int $requestId, int $userId): bool
{
  try {
    $pdo->beginTransaction(); // Using transaction to check permissions and update membership request in single operation.

    $stmt = $pdo->prepare('
      SELECT
        mr.user_id,
        mr.group_id
      FROM membership_requests AS mr
      JOIN group_users AS gu
        ON gu.group_id = mr.group_id
        AND gu.user_id = :admin_user_id
      JOIN roles AS admin_role
        ON admin_role.id = gu.role_id
      WHERE mr.id = :request_id
        AND LOWER(mr.status) = "pending"
        AND LOWER(admin_role.name) = "admin"
      FOR UPDATE
    ');

    $stmt->execute([
      'request_id' => $requestId,
      'admin_user_id' => $userId
    ]);

    $request = $stmt->fetch();

    if ($request === false) {
      $pdo->rollBack();
      return false;
    }

    $stmt = $pdo->prepare('
      INSERT INTO group_users (
        group_id,
        user_id,
        role_id
      )
      SELECT
        :group_id,
        :user_id,
        r.id
      FROM roles AS r
      WHERE LOWER(r.name) = "member"
    ');

    $stmt->execute([
      'group_id' => $request['group_id'],
      'user_id' => $request['user_id']
    ]);

    if ($stmt->rowCount() !== 1) {
      $pdo->rollBack();
      return false;
    }

    $stmt = $pdo->prepare('
      UPDATE membership_requests
      SET
        status = "approved",
        handler_user_id = :handler_user_id,
        handled_at = CURRENT_TIMESTAMP
      WHERE id = :request_id
        AND status = "pending"
    ');

    $stmt->execute([
      'request_id' => $requestId,
      'handler_user_id' => $userId
    ]);

    if ($stmt->rowCount() !== 1) {
      $pdo->rollBack();
      return false;
    }

    $pdo->commit();

    return true;
  } catch (Throwable $error) {
    if ($pdo->inTransaction()) {
      $pdo->rollBack();
    }

    throw $error;
  }
}

function rejectMembershipRequest(PDO $pdo, int $requestId, int $userId): bool
{
  $stmt = $pdo->prepare('
  UPDATE membership_requests AS mr
    JOIN group_users AS gu
      ON gu.group_id = mr.group_id
      AND gu.user_id = :handler_user_id
    JOIN roles AS r
      ON r.id = gu.role_id
    SET
      mr.status = "rejected",
      mr.handler_user_id = :handler_user_id,
      mr.handled_at = CURRENT_TIMESTAMP
    WHERE mr.id = :request_id
      AND mr.status = "pending"
      AND LOWER(r.name) = "admin"
  ');

  $stmt->execute([
    'request_id' => $requestId,
    'handler_user_id' => $userId
  ]);

  return $stmt->rowCount() === 1;
}

function updateMemberRole(PDO $pdo, int $groupId, int $userId, string $role): bool
{
  $stmt = $pdo->prepare('
    UPDATE group_users
      SET role_id = (
        SELECT id
        FROM roles
        WHERE name = :role
    )
    WHERE group_id = :group_id
      AND user_id = :user_id
  ');

  $stmt->execute([
    'role' => $role,
    'group_id' => $groupId,
    'user_id' => $userId,
  ]);

  return $stmt->rowCount() > 0;
}

function removeMember(PDO $db, int $groupId, int $userId): bool
{
  $stmt = $db->prepare('
    DELETE FROM group_users
      WHERE group_id = :group_id
        AND user_id = :user_id
  ');

  $stmt->execute([
    'group_id' => $groupId,
    'user_id' => $userId,
  ]);

  return $stmt->rowCount() > 0;
}
