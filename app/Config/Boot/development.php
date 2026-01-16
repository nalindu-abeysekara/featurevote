<?php

/**
 * Development Environment Bootstrap
 */

// Report all errors
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Show debug backtrace
defined('SHOW_DEBUG_BACKTRACE') || define('SHOW_DEBUG_BACKTRACE', true);

// Enable CI Debug Toolbar
defined('CI_DEBUG') || define('CI_DEBUG', true);
