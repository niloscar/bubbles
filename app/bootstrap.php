<?php
/**
 * Boostrap, initialize and load the application
 */

define('BASE_PATH', dirname(__DIR__));

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
require_once BASE_PATH . '/app/actions/membership.php';
require_once BASE_PATH . '/app/actions/invitation.php';
require_once BASE_PATH . '/app/actions/group.php';
require_once BASE_PATH . '/app/actions/thread.php';
require_once BASE_PATH . '/app/actions/comment.php';

require_once BASE_PATH . '/app/helpers/view.php';
require_once BASE_PATH . '/app/helpers/page.php';
require_once BASE_PATH . '/app/helpers/debug.php';
require_once BASE_PATH . '/app/helpers/format.php';
require_once BASE_PATH . '/app/helpers/error.php';
require_once BASE_PATH . '/app/helpers/auth.php';
require_once BASE_PATH . '/app/helpers/translate.php';
require_once BASE_PATH . '/app/helpers/avatar.php';
require_once BASE_PATH . '/app/helpers/alert.php';

require_once BASE_PATH . '/app/data/users.php';
require_once BASE_PATH . '/app/data/groups.php';
require_once BASE_PATH . '/app/data/threads.php';
require_once BASE_PATH . '/app/data/membership_requests.php';
require_once BASE_PATH . '/app/data/membership_invitations.php';
require_once BASE_PATH . '/app/data/comments.php';
