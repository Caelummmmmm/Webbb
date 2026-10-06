<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin');
$routes->get('logout', 'Auth::logout');

$routes->get('dashboard', 'Accounts::index');

$routes->get('account/new', 'Accounts::new');
$routes->post('account', 'Accounts::create');

$routes->get('account/(:num)', 'Accounts::show/$1');
$routes->get('account/(:num)/edit', 'Accounts::edit/$1');
$routes->post('account/(:num)', 'Accounts::update/$1');
$routes->post('account/(:num)/delete', 'Accounts::delete/$1');

$routes->get('about', 'About::index');
$routes->get('services', 'Services::index');
$routes->match(['get', 'post'], 'contact', 'Contact::index');
$routes->get('register', 'Register::index');
$routes->post('register', 'Register::create');