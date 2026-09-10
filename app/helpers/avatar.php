<?php

/**
 * Avatar helper functions
 */

function getAvatarUrl(array $user): string
{
  if (!empty($user['avatar'])) return $user['avatar'];

  if (!empty($user['email'])) {
    $hash = gravatarHash($user['email']);

    return "https://gravatar.com/avatar/$hash?d=identicon";
  }

  return './assets/icons/user.svg';
}

function gravatarHash(string $email): string
{
  return hash('sha256', strtolower(trim($email)));
}
