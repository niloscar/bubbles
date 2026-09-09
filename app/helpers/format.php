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

function formatSecondsToTime(int $seconds): string
{
  $hours = floor($seconds / 3600);
  $minutes = floor(($seconds % 3600) / 60);
  $remainingSeconds = $seconds % 60;

  return sprintf('%02d:%02d:%02d', $hours, $minutes, $remainingSeconds);
}

function formatSecondsToText(int $seconds): string
{
  $hours = floor($seconds / 3600);
  $minutes = floor(($seconds % 3600) / 60);
  $remainingSeconds = $seconds % 60;

  $parts = [];
  if ($hours > 0) {
    $parts[] = $hours . ' ' . ($hours === 1 ? 'timme' : 'timmar');
  }
  if ($minutes > 0) {
    $parts[] = $minutes . ' ' . ($minutes === 1 ? 'minut' : 'minuter');
  }
  if ($remainingSeconds > 0 || empty($parts)) {
    $parts[] = $remainingSeconds . ' ' . ($remainingSeconds === 1 ? 'sekund' : 'sekunder');
  }

  return implode(', ', $parts);
}

function formatUserText(string $text): string
{
    $paragraphs = preg_split('/\R{2,}/', trim($text));

    $html = '';

    foreach ($paragraphs as $paragraph) {
        $html .= '<p>' . nl2br(htmlspecialchars($paragraph)) . '</p>';
    }

    return $html;
}