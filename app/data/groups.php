<?php

/**
 * Groups data
 */

function getGroups(PDO $pdo): array
{
    $stmt = $pdo->prepare(
        'SELECT
            g.id,
            g.name,
            g.description,
            g.created_at,
            (
                SELECT COUNT(*)
                FROM group_users AS gu
                WHERE group_id = g.id
            ) AS user_count,
            (
                SELECT MAX(GREATEST(t.created_at, COALESCE(c.created_at, t.created_at)))
                FROM threads AS t
                LEFT JOIN comments AS c ON c.thread_id = t.id
                WHERE t.group_id = g.id
            ) AS last_activity,
            r.name AS role,
            mr.status AS membership_request_status

        FROM groups AS g

        LEFT JOIN group_users AS my_membership
            ON my_membership.group_id = g.id
            AND my_membership.user_id = :membership_user_id

        LEFT JOIN roles AS r
            ON my_membership.role_id = r.id

        LEFT JOIN membership_requests AS mr
            ON mr.group_id = g.id
            AND mr.user_id = :request_user_id
            AND mr.status = \'pending\'

        ORDER BY
            CASE
                WHEN LOWER(r.name) = \'admin\' THEN 1
                WHEN LOWER(r.name) = \'member\' THEN 2
                WHEN mr.status = \'pending\' THEN 3
                ELSE 4
            END,
            last_activity DESC'
    );

    $userId = $_SESSION['user_id'] ?? null;

    $stmt->execute([
        'membership_user_id' => $userId,
        'request_user_id' => $userId
    ]);

    return $stmt->fetchAll();
}

function getGroupById(PDO $pdo, int $id): array|false
{
    $stmt = $pdo->prepare(
        'SELECT
            g.id,
            g.name,
            g.description,
            g.created_at,
            (
                SELECT COUNT(*)
                FROM group_users AS gu
                WHERE group_id = g.id
            ) AS user_count,
            (
                SELECT MAX(GREATEST(t.created_at, COALESCE(c.created_at, t.created_at)))
                FROM threads AS t
                LEFT JOIN comments AS c ON c.thread_id = t.id
                WHERE t.group_id = g.id
            ) AS last_activity,
            r.name AS role,
            mr.status AS membership_request_status

        FROM groups AS g

        LEFT JOIN group_users AS my_membership
            ON my_membership.group_id = g.id
            AND my_membership.user_id = :membership_user_id

        LEFT JOIN roles AS r
            ON my_membership.role_id = r.id

        LEFT JOIN membership_requests AS mr
            ON mr.group_id = g.id
            AND mr.user_id = :request_user_id
            AND mr.status = \'pending\'
        WHERE g.id = :group_id'
    );

    $userId = $_SESSION['user_id'] ?? null;

    $stmt->execute([
        'group_id' => $id,
        'membership_user_id' => $userId,
        'request_user_id' => $userId
    ]);

    return $stmt->fetch();
}

function getGroupsByUserId(PDO $pdo, int $userId): array
{
    $stmt = $pdo->prepare(
        'SELECT g.id, g.name, g.description, g.created_at, gu.role_id, r.name AS "role"
         FROM groups g
         INNER JOIN group_users gu ON g.id = gu.group_id
         INNER JOIN roles r ON gu.role_id = r.id
         WHERE gu.user_id = :user_id
         ORDER BY g.name ASC'
    );

    $stmt->execute(['user_id' => $userId]);

    return $stmt->fetchAll();
}

function createGroup(PDO $pdo, string $name, string $description, int $userId): int
{
    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare(
            'INSERT INTO groups (name, description)
             VALUES (:name, :description)'
        );

        $stmt->execute([
            'name' => $name,
            'description' => $description
        ]);

        $groupId = (int) $pdo->lastInsertId();

        $stmt = $pdo->prepare(
            'INSERT INTO group_users (group_id, user_id, role_id)
             SELECT :group_id, :user_id, id
             FROM roles
             WHERE LOWER(name) = "admin"'
        );

        $stmt->execute([
            'group_id' => $groupId,
            'user_id' => $userId
        ]);

        if ($stmt->rowCount() !== 1) throw new RuntimeException('Adminrollen kunde inte hittas.');

        $pdo->commit();

        return $groupId;
    } catch (Throwable $error) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        throw $error;
    }
}
