<?php

/**
 * Settings
 */

const SITE_NAME = 'Bubblor';
const SANDBOX = true;

const PAGES = [
  ['title' => 'Start', 'slug' => 'start', 'view' => 'page_start'],
  ['title' => 'Tråd', 'slug' => 'thread', 'view' => 'page_thread'],
  ['title' => 'Grupper', 'slug' => 'groups', 'view' => 'page_groups'],
  ['title' => 'Grupp', 'slug' => 'group', 'view' => 'page_group_details'],
  ['title' => 'Logga in', 'slug' => 'login', 'view' => 'page_login'],
  ['title' => 'Registrera', 'slug' => 'register', 'view' => 'page_register'],
  ['title' => 'Användare', 'slug' => 'user', 'view' => 'page_user'],
  ['title' => 'Profil', 'slug' => 'profile', 'view' => 'page_profile'],
  ['title' => 'Inbjudan', 'slug' => 'invitation', 'view' => 'page_membership_invitation'],
];

const NAV_MAIN = [
  ['title' => 'Start', 'slug' => 'start'],
  ['title' => 'Grupper', 'slug' => 'groups'],
];
