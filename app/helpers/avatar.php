<?php

/**
 * Avatar helper functions
 */

function getAvatarUrl(array $user) {
  if (isset($user['avatar']) && !empty($user['avatar'])) {
    return $user['avatar'];
  }

  return "./assets/icons/user.svg";
}