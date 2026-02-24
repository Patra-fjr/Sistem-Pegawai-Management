<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Auth
$routes->get('/login', 'AuthController::login');
$routes->post('/login/process', 'AuthController::loginProcess');
$routes->get('/logout', 'AuthController::logout');

// Dashboard
$routes->get('/dashboard', 'DashboardController::index', ['filter' => 'auth']);
// Departments (admin only)
$routes->get('/departments', 'DepartmentController::index', ['filter' => 'auth']);
$routes->get('/departments/create', 'DepartmentController::create', ['filter' => 'auth']);
$routes->post('/departments/store', 'DepartmentController::store', ['filter' => 'auth']);
$routes->get('/departments/edit/(:num)', 'DepartmentController::edit/$1', ['filter' => 'auth']);
$routes->post('/departments/update/(:num)', 'DepartmentController::update/$1', ['filter' => 'auth']);
$routes->get('/departments/delete/(:num)', 'DepartmentController::delete/$1', ['filter' => 'auth']);

// Positions (admin only)
$routes->get('/positions', 'PositionController::index', ['filter' => 'auth']);
$routes->get('/positions/create', 'PositionController::create', ['filter' => 'auth']);
$routes->post('/positions/store', 'PositionController::store', ['filter' => 'auth']);
$routes->get('/positions/edit/(:num)', 'PositionController::edit/$1', ['filter' => 'auth']);
$routes->post('/positions/update/(:num)', 'PositionController::update/$1', ['filter' => 'auth']);
$routes->get('/positions/delete/(:num)', 'PositionController::delete/$1', ['filter' => 'auth']);

// Profile
$routes->get('/profile', 'ProfileController::index', ['filter' => 'auth']);
$routes->get('/profile/edit', 'ProfileController::edit', ['filter' => 'auth']);
$routes->post('/profile/update', 'ProfileController::update', ['filter' => 'auth']);

// Employees
$routes->get('/employees', 'EmployeeController::index', ['filter' => 'auth']);
$routes->get('/employees/create', 'EmployeeController::create', ['filter' => 'auth']);
$routes->post('/employees/store', 'EmployeeController::store', ['filter' => 'auth']);
$routes->get('/employees/show/(:num)', 'EmployeeController::show/$1', ['filter' => 'auth']);
$routes->get('/employees/edit/(:num)', 'EmployeeController::edit/$1', ['filter' => 'auth']);
$routes->post('/employees/update/(:num)', 'EmployeeController::update/$1', ['filter' => 'auth']);
$routes->get('/employees/delete/(:num)', 'EmployeeController::delete/$1', ['filter' => 'auth']);

// REST API - Employees
$routes->get('api/employees', 'Api\EmployeeController::index');
$routes->get('api/employees/(:num)', 'Api\EmployeeController::show/$1');
$routes->post('api/employees', 'Api\EmployeeController::create');
$routes->put('api/employees/(:num)', 'Api\EmployeeController::update/$1');
$routes->delete('api/employees/(:num)', 'Api\EmployeeController::delete/$1');