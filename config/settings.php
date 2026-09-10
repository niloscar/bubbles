<?php

/**
 * Settings
 */

const SITE_NAME = 'Bubbles';

define('PAGE_URL', $_ENV['APP_URL'] ?? 'http://localhost:8080');

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

const NAV_FOOTER = [
  ['title' => 'README', 'slug' => 'readme', 'url' => 'https://github.com/niloscar/sysdev-community-forum/blob/main/README.md', 'icon' => 'book-open-text'],
  ['title' => 'Uppgiftsbeskrivning', 'slug' => 'assignment_description', 'url' => 'https://github.com/niloscar/sysdev-community-forum/blob/main/docs/assignment-description.md', 'icon' => 'clipboard-text'],
  ['title' => 'Uppgiftschecklista', 'slug' => 'assignment_checklist', 'url' => 'https://github.com/niloscar/sysdev-community-forum/blob/main/docs/assignment-checklist.md', 'icon' => 'list-checks'],
  ['title' => 'Databasdiagram', 'slug' => 'er_diagram', 'url' => 'https://github.com/niloscar/sysdev-community-forum/blob/main/docs/er-diagram.png', 'icon' => 'database'],
];

const NAV_CONTACT = [
  ['title' => 'GitHub/niloscar', 'slug' => 'github', 'url' => 'https://github.com/niloscar/', 'icon' => 'github-logo'],
  ['title' => 'LinkedIn/oscar-nilsson1', 'slug' => 'linkedin', 'url' => 'https://www.linkedin.com/in/oscar-nilsson1/', 'icon' => 'linkedin-logo'],
  ['title' => 'oscar.nilsson@medieinstitutet.se', 'slug' => 'email', 'url' => 'mailto:oscar.nilsson@medieinstitutet.se', 'icon' => 'mailbox'],
  ['title' => '+46 70-764 50 60', 'slug' => 'tel', 'url' => 'tel:+46707645060', 'icon' => 'device-mobile'],
];