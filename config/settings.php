<?php

/**
 * Settings
 */

const SITE_NAME = 'Bubblor';

const PAGES = [
  ['title' => 'Start', 'slug' => 'start', 'view' => 'page_start'],
  ['title' => 'Tråd', 'slug' => 'thread', 'view' => 'page_thread'],
  ['title' => 'Bubblor', 'slug' => 'groups', 'view' => 'page_groups'],
  ['title' => 'Bubbla', 'slug' => 'group', 'view' => 'page_group_details'],
  ['title' => 'Logga in', 'slug' => 'login', 'view' => 'page_login'],
  ['title' => 'Registrera', 'slug' => 'register', 'view' => 'page_register'],
  ['title' => 'Användare', 'slug' => 'user', 'view' => 'page_user']
];

const NAV_MAIN = [
  ['title' => 'Start', 'slug' => 'start'],
  ['title' => 'Bubblor', 'slug' => 'groups'],
  ['title' => 'Tråd', 'slug' => 'thread'],
  ['title' => 'Logga in', 'slug' => 'login'],
  ['title' => 'Registrera', 'slug' => 'register'],
];
