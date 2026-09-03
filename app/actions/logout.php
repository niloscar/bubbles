<?php

/**
 * Logout action
 */

function handleLogoutRequest(): void
{
    session_unset();
    session_destroy();

    header('Location: ?p=login');
    exit;
}