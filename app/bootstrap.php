<?php
/**
 * Boostrap, initialize and load the application
 */

session_set_cookie_params([
    'httponly' => true,
    'secure' => true,
    'samesite' => 'Lax',
]);

session_start();

require_once BASE_PATH . '/config/settings.php';
require_once BASE_PATH . '/config/database.php';

require_once BASE_PATH . '/app/request.php';

require_once BASE_PATH . '/app/actions/login.php';
require_once BASE_PATH . '/app/actions/logout.php';
require_once BASE_PATH . '/app/actions/register.php';
require_once BASE_PATH . '/app/actions/request_membership.php';

require_once BASE_PATH . '/app/helpers/view.php';
require_once BASE_PATH . '/app/helpers/page.php';
require_once BASE_PATH . '/app/helpers/debug.php';
require_once BASE_PATH . '/app/helpers/format.php';
require_once BASE_PATH . '/app/helpers/error.php';
require_once BASE_PATH . '/app/helpers/auth.php';

require_once BASE_PATH . '/app/data/users.php';
require_once BASE_PATH . '/app/data/groups.php';
require_once BASE_PATH . '/app/data/threads.php';
require_once BASE_PATH . '/app/data/membership_requests.php';
