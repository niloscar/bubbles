<?php

/**
 * Threads data functions
 */

function getThreadsByGroupId(PDO $db, int $groupId): array
{
  $stmt = $db->prepare(
    'SELECT
      threads.id,
      threads.subject,
      threads.text,
      threads.created_at,
      threads.user_id,

      thread_author.username,
      thread_author.fname,
      thread_author.lname,
      thread_author.avatar,

      COALESCE(latest_comment.created_at, threads.created_at) AS last_activity,

      COALESCE(latest_comment.user_id, threads.user_id) AS last_activity_user_id,
      activity_user.username AS last_activity_username

    FROM threads

    JOIN users AS thread_author
      ON thread_author.id = threads.user_id

    LEFT JOIN comments AS latest_comment
      ON latest_comment.id = (
        SELECT comments_inner.id
        FROM comments AS comments_inner
        WHERE comments_inner.thread_id = threads.id
          AND comments_inner.deleted_at IS NULL
        ORDER BY
          comments_inner.created_at DESC,
          comments_inner.id DESC
        LIMIT 1
      )

    JOIN users AS activity_user
      ON activity_user.id = COALESCE(
        latest_comment.user_id,
        threads.user_id
      )

    WHERE threads.group_id = :group_id

    ORDER BY last_activity DESC'
  );

  $stmt->execute(['group_id' => $groupId]);

  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getThreadsByUserId(PDO $db, int $userId): array
{
  $stmt = $db->prepare('SELECT * FROM threads WHERE user_id = :user_id ORDER BY created_at DESC');
  $stmt->execute(['user_id' => $userId]);
  return $stmt->fetchAll();
}

function getThreadById(PDO $db, int $threadId): array|false
{
  $stmt = $db->prepare(
    'SELECT
      groups.id AS group_id,
      groups.name AS group_name,
      threads.id,
      threads.subject,
      threads.text,
      threads.created_at,
      threads.user_id,
      users.username,
      users.fname,
      users.lname,
      users.avatar
    FROM threads
    JOIN users ON users.id = threads.user_id
    JOIN groups ON groups.id = threads.group_id
    WHERE threads.id = :thread_id'
  );

  $stmt->execute(['thread_id' => $threadId]);

  return $stmt->fetch();
}

function getThreadByIdWithComments(PDO $db, int $threadId): array|false
{
  $stmt = $db->prepare(
    'SELECT
            groups.id AS group_id,
            groups.name AS group_name,
            threads.id,
            threads.subject,
            threads.text,
            threads.created_at,
            threads.user_id,
            users.username,
            users.fname,
            users.lname,
            users.avatar

        FROM threads

        JOIN users
            ON users.id = threads.user_id

        JOIN groups
            ON groups.id = threads.group_id

        WHERE threads.id = :thread_id'
  );

  $stmt->execute([
    'thread_id' => $threadId
  ]);

  $thread = $stmt->fetch();

  if (!$thread) return false;

  $stmt = $db->prepare(
    'SELECT
            comments.id,
            comments.text,
            comments.created_at,
            comments.edited_at,
            comments.user_id,
            users.username,
            users.fname,
            users.lname,
            users.avatar

        FROM comments

        JOIN users
            ON users.id = comments.user_id

        WHERE comments.thread_id = :thread_id

        ORDER BY comments.created_at ASC'
  );

  $stmt->execute([
    'thread_id' => $threadId
  ]);

  $thread['comments'] = $stmt->fetchAll();

  return $thread;
}

function createThread(PDO $pdo, int $groupId, int $userId, string $subject, string $text): int
{
  $stmt = $pdo->prepare(
    'INSERT INTO threads (group_id, user_id, subject, text)
         SELECT :group_id, :user_id, :subject, :text
         FROM group_users
         WHERE group_id = :membership_group_id
           AND user_id = :membership_user_id
         LIMIT 1'
  );

  $stmt->execute([
    'group_id' => $groupId,
    'user_id' => $userId,
    'subject' => $subject,
    'text' => $text,
    'membership_group_id' => $groupId,
    'membership_user_id' => $userId
  ]);

  if ($stmt->rowCount() !== 1) throw new RuntimeException('Du måste vara medlem i gruppen för att skapa en tråd.');

  return (int) $pdo->lastInsertId();
}

function getLatestThreadsForUser(PDO $pdo, int $userId, int $limit = 10): array
{
  $stmt = $pdo->prepare('
    SELECT
      t.id,
      t.group_id,
      t.subject,
      t.created_at,
      t.user_id,
      u.username,
      g.name AS group_name,
      GREATEST(
        t.created_at,
        COALESCE(MAX(c.created_at), t.created_at)
      ) AS last_activity
    FROM threads AS t
    JOIN users AS u
      ON u.id = t.user_id
    JOIN groups AS g
      ON g.id = t.group_id
    JOIN group_users AS gu
      ON gu.group_id = t.group_id
      AND gu.user_id = :user_id
    LEFT JOIN comments AS c
      ON c.thread_id = t.id
      AND c.deleted_at IS NULL
    WHERE t.deleted_at IS NULL
    GROUP BY
      t.id,
      t.group_id,
      t.subject,
      t.created_at,
      t.user_id,
      u.username,
      g.name
    ORDER BY last_activity DESC
    LIMIT ' . (int) $limit
  );

  $stmt->execute([
    'user_id' => $userId
  ]);

  return $stmt->fetchAll();
}
