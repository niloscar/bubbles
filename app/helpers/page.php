<?php
/**
 * Page helper
 */

require_once BASE_PATH . '/app/data/mock_data.php';

function pageTitle(): string
{
  $pageSlug = $_GET['p'] ?? 'start';

  foreach (PAGES as $page) {
    if ($page['slug'] === $pageSlug) {
      return $page['title'];
    }
  }

  return SITE_NAME;
}

function output(): void
{
    $startPageSlug = PAGES[0]['slug'];
    $currentPageSlug = $_GET['p'] ?? $startPageSlug;

    $currentPageView = null;
    $startPageView = PAGES[0]['view'];

    foreach (PAGES as $page) {
        if ($page['slug'] === $currentPageSlug) {
            $currentPageView = $page['view'];
            break;
        }
    }

    page($currentPageView ?? $startPageView);
}