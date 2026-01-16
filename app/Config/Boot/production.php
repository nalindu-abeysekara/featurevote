<?php

/**
 * Production Environment Bootstrap
 */

// Don't show errors in production
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
ini_set('display_errors', '0');

// Hide debug backtrace
defined('SHOW_DEBUG_BACKTRACE') || define('SHOW_DEBUG_BACKTRACE', false);

// Disable CI Debug
defined('CI_DEBUG') || define('CI_DEBUG', false);
