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
    'd MMMM y'
  );

  return $formatted->format($date);
}

function formatTimeAgo(string $dateString): string
{
  $date = new DateTime($dateString);
  $now = new DateTime();

  $interval = $now->diff($date);

  $plural = function (int $value, string $singular, string $plural): string {
    return $value . ' ' . ($value === 1 ? $singular : $plural);
  };

  $return = match (true) {
    $interval->y > 0 => $plural($interval->y, 'år', 'år'),
    $interval->m > 0 => $plural($interval->m, 'månad', 'månader'),
    $interval->d > 0 => $plural($interval->d, 'dag', 'dagar'),
    $interval->h > 0 => $plural($interval->h, 'timme', 'timmar'),
    $interval->i > 0 => $plural($interval->i, 'minut', 'minuter'),
    default => null
  };

  return $return ? $return . ' sedan' : 'just nu';
}
