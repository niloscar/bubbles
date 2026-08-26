<?php

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

function pageOutput()
{
  $startPageSlug = PAGES[0]['slug'];  
  $currentPageSlug  = $_GET['p'] ?? $startPageSlug;  
  
  $currentPageView = null;

  foreach (PAGES as $page) {
    if ($page['slug'] === $startPageSlug) {
      $startPageView = $page['view'];
    }

    if ($page['slug'] === $currentPageSlug) {
      $currentPageView = $page['view'];
      return;
    }
  }
  
  include BASE_PATH . '/app/views/pages/' . ($currentPageView ?? $startPageView);
}
