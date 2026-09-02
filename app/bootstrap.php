<?php
/**
 * Boostrap, initialize and load the application
 */

session_start();

require_once BASE_PATH . '/config/settings.php';
require_once BASE_PATH . '/config/database.php';

require_once BASE_PATH . '/app/helpers/view.php';
require_once BASE_PATH . '/app/helpers/page.php';
require_once BASE_PATH . '/app/helpers/debug.php';
require_once BASE_PATH . '/app/helpers/format.php';
require_once BASE_PATH . '/app/helpers/error.php';

require_once BASE_PATH . '/app/data/comments.php';
require_once BASE_PATH . '/app/data/groups.php';
require_once BASE_PATH . '/app/data/users.php';