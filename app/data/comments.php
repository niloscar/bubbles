<?php

/**
 * Comments data access functions
 */

function getCommentsByThreadId(PDO $pdo, int $threadId): array
{
    $stmt = $pdo->prepare(
        'SELECT
            c.id,
            c.thread_id,
            c.user_id,
            u.username,
            u.fname,
            u.lname,
            u.avatar,
            c.text,
            c.created_at
        FROM comments AS c
        JOIN users AS u ON u.id = c.user_id
        WHERE c.thread_id = :thread_id
          AND c.deleted_at IS NULL
        ORDER BY c.created_at ASC'
    );

    $stmt->execute(['thread_id' => $threadId]);

    return $stmt->fetchAll();
}

function createComment(PDO $pdo, int $threadId, int $userId, string $text): int
{
    $stmt = $pdo->prepare(
        'INSERT INTO comments (thread_id, user_id, text)
         SELECT t.id, :user_id, :text
         FROM threads AS t
         JOIN group_users AS gu
           ON gu.group_id = t.group_id
           AND gu.user_id = :membership_user_id
         WHERE t.id = :thread_id
           AND t.deleted_at IS NULL'
    );

    $stmt->execute([
        'user_id' => $userId,
        'text' => $text,
        'membership_user_id' => $userId,
        'thread_id' => $threadId
    ]);

    if ($stmt->rowCount() !== 1) throw new RuntimeException('Du måste vara medlem i gruppen för att kommentera.');

    return (int) $pdo->lastInsertId();
}