<?php

/*
 | --------------------------------------------------------------------
 | App Namespace
 | --------------------------------------------------------------------
 */
defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');

/*
 | --------------------------------------------------------------------
 | Composer Path
 | --------------------------------------------------------------------
 */
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

/*
 |--------------------------------------------------------------------------
 | Timing Constants
 |--------------------------------------------------------------------------
 */
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2_592_000);
defined('YEAR')   || define('YEAR', 31_536_000);
defined('DECADE') || define('DECADE', 315_360_000);

/*
 | --------------------------------------------------------------------
 | Exit Status Codes
 | --------------------------------------------------------------------
 */
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0);
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1);
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3);
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4);
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5);
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6);
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7);
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8);
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9);
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125);

/**
 * Custom application constants
 */

// Request statuses
defined('STATUS_OPEN')        || define('STATUS_OPEN', 'open');
defined('STATUS_UNDER_REVIEW') || define('STATUS_UNDER_REVIEW', 'under_review');
defined('STATUS_PLANNED')     || define('STATUS_PLANNED', 'planned');
defined('STATUS_IN_PROGRESS') || define('STATUS_IN_PROGRESS', 'in_progress');
defined('STATUS_COMPLETED')   || define('STATUS_COMPLETED', 'completed');
defined('STATUS_CLOSED')      || define('STATUS_CLOSED', 'closed');
defined('STATUS_MERGED')      || define('STATUS_MERGED', 'merged');

// User roles
defined('ROLE_USER')  || define('ROLE_USER', 'user');
defined('ROLE_ADMIN') || define('ROLE_ADMIN', 'admin');
