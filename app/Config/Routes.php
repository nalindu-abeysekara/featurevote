<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Shield authentication routes
service('auth')->routes($routes);

// Public routes
$routes->get('/', 'Home::index');

// Feature requests routes
$routes->group('requests', static function ($routes) {
    $routes->get('/', 'RequestController::index');
    $routes->get('create', 'RequestController::create', ['filter' => 'session']);
    $routes->post('/', 'RequestController::store', ['filter' => 'session']);
    $routes->get('(:segment)', 'RequestController::show/$1');
});

// Voting routes (requires authentication)
$routes->group('votes', ['filter' => 'session'], static function ($routes) {
    $routes->post('toggle/(:num)', 'VoteController::toggle/$1');
});

// Comments routes
$routes->group('comments', static function ($routes) {
    $routes->post('(:num)', 'CommentController::store/$1', ['filter' => 'session']);
    $routes->delete('(:num)', 'CommentController::delete/$1', ['filter' => 'session']);
});

// Category routes
$routes->get('category/(:segment)', 'RequestController::byCategory/$1');

// Admin routes
$routes->group('admin', ['filter' => 'session', 'namespace' => 'App\Controllers\Admin'], static function ($routes) {
    $routes->get('/', 'DashboardController::index');

    // Request management
    $routes->get('requests', 'RequestController::index');
    $routes->get('requests/(:num)/edit', 'RequestController::edit/$1');
    $routes->post('requests/(:num)', 'RequestController::update/$1');
    $routes->post('requests/(:num)/delete', 'RequestController::delete/$1');
    $routes->post('requests/(:num)/merge', 'RequestController::merge/$1');

    // Category management
    $routes->get('categories', 'CategoryController::index');
    $routes->get('categories/create', 'CategoryController::create');
    $routes->post('categories', 'CategoryController::store');
    $routes->get('categories/(:num)/edit', 'CategoryController::edit/$1');
    $routes->post('categories/(:num)', 'CategoryController::update/$1');
    $routes->post('categories/(:num)/delete', 'CategoryController::delete/$1');
    $routes->post('categories/reorder', 'CategoryController::reorder');

    // User management
    $routes->get('users', 'UserController::index');
    $routes->get('users/(:num)/edit', 'UserController::edit/$1');
    $routes->post('users/(:num)', 'UserController::update/$1');

    // Settings
    $routes->get('settings', 'SettingsController::index');
    $routes->post('settings', 'SettingsController::update');
});

// API routes for HTMX
$routes->group('api', ['namespace' => 'App\Controllers\Api'], static function ($routes) {
    $routes->get('requests', 'RequestController::index');
    $routes->get('requests/search', 'RequestController::search');
});
