<?php

/**
 * Settings
 */

const SITE_NAME = 'Bubblor';
const PAGE_URL = 'http://localhost:8080';
const SANDBOX = true;

const PAGES = [
  ['title' => 'Start', 'slug' => 'start', 'view' => 'page_start', 'ancestors' => []],
  ['title' => 'Tråd', 'slug' => 'thread', 'view' => 'page_thread', 'ancestors' => ['groups', 'group']],
  ['title' => 'Grupper', 'slug' => 'groups', 'view' => 'page_groups', 'ancestors' => []],
  ['title' => 'Grupp', 'slug' => 'group', 'view' => 'page_group_details', 'ancestors' => ['groups']],
  ['title' => 'Logga in', 'slug' => 'login', 'view' => 'page_login', 'ancestors' => []],
  ['title' => 'Registrera', 'slug' => 'register', 'view' => 'page_register', 'ancestors' => ['login']],
  ['title' => 'Användare', 'slug' => 'user', 'view' => 'page_user', 'ancestors' => []],
  ['title' => 'Profil', 'slug' => 'profile', 'view' => 'page_profile', 'ancestors' => []],
  ['title' => 'Inbjudan', 'slug' => 'invitation', 'view' => 'page_membership_invitation', 'ancestors' => []],
];

const NAV_MAIN = [
  ['title' => 'Start', 'slug' => 'start'],
  ['title' => 'Grupper', 'slug' => 'groups'],
];
