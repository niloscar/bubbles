<?php

/**
 * Group membership invitation data functions
 */

function getMembershipInvitationByToken(PDO $pdo, string $token): array|false
{
  $stmt = $pdo->prepare('
    SELECT 
      i.inviter_id,
      u.username AS inviter_username,
      i.group_id,
      g.name AS group_name,
      i.token,
      i.created_at,
      i.expires_at,
      i.used
      FROM membership_invites AS i
      JOIN users AS u ON i.inviter_id = u.id
      JOIN groups AS g ON i.group_id = g.id
    WHERE token = :token
  ');
  $stmt->execute(['token' => $token]);
  return $stmt->fetch();
}

function markMembershipInvitationAsUsed(PDO $pdo, string $token): bool
{
  $stmt = $pdo->prepare('UPDATE membership_invites SET used = 1 WHERE token = :token');
  $stmt->execute(['token' => $token]);
  return $stmt->rowCount() === 1;
}

function createMembershipInvitation(PDO $pdo, int $inviterId, int $groupId): string
{
  $token = bin2hex(random_bytes(32));

  $stmt = $pdo->prepare('
    INSERT INTO membership_invites (
      inviter_id,
      group_id,
      token,
      expires_at
    )
    VALUES (
      :inviter_id,
      :group_id,
      :token,
      DATE_ADD(NOW(), INTERVAL 24 HOUR)
    )
  ');

  $stmt->execute([
    'inviter_id' => $inviterId,
    'group_id' => $groupId,
    'token' => $token,
  ]);

  return $token;
}

function acceptMembershipInvitation(PDO $pdo, string $token, int $groupId, int $userId): bool
{
  try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("
      INSERT INTO group_users (
        group_id,
        user_id,
        role_id
      )
      SELECT
        :group_id,
        :user_id,
        id
      FROM roles
      WHERE LOWER(name) = 'member'"
    );

    $stmt->execute([
      'group_id' => $groupId,
      'user_id' => $userId
    ]);

    if ($stmt->rowCount() !== 1) {
      $pdo->rollBack();
      return false;
    }

    $stmt = $pdo->prepare('
      UPDATE membership_invites
        SET used = 1
      WHERE token = :token
        AND used = 0
    ');

    $stmt->execute([
      'token' => $token
    ]);

    if ($stmt->rowCount() !== 1) {
      $pdo->rollBack();
      return false;
    }

    $pdo->commit();

    return true;
  } catch (Throwable $error) {
    if ($pdo->inTransaction()) $pdo->rollBack();

    throw $error;
  }
}
