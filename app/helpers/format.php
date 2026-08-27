<?php
/**
 * Format helper
 */

function formatDateTime(string $dateString): string
{
  $date = new DateTime($dateString);
  return $date->format('Y-m-d H:i:s');
}

function formatDate(string $dateString): string
{
  $date = new DateTime($dateString);
  return $date->format('Y-m-d');
}

function formatTime(string $dateString): string
{
  $date = new DateTime($dateString);
  return $date->format('H:i:s');
}

function formatDateToText(string $dateString): string
{
  $date = new DateTime('2026-01-01');

  $formatted = new IntlDateFormatter(
      'sv_SE',
      IntlDateFormatter::FULL,
      IntlDateFormatter::NONE,
      null,
      null,
      'EEEE, d MMMM y'
  );

  return $formatted->format($date);
}

function formatTimeAgo(string $dateString): string
{
  $date = new DateTime($dateString);
  $now = new DateTime();
  $interval = $now->diff($date);

  if ($interval->y > 0) {
    return $interval->y . ' år sedan';
  } elseif ($interval->m > 0) {
    return $interval->m . ' månader sedan';
  } elseif ($interval->d > 0) {
    return $interval->d . ' dagar sedan';
  } elseif ($interval->h > 0) {
    return $interval->h . ' timmar sedan';
  } elseif ($interval->i > 0) {
    return $interval->i . ' minuter sedan';
  } else {
    return 'just nu';
  }
}