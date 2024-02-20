<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/home', 'Main::index');
$routes->get('/home/thread/(:any)', 'Main::thread/$1');
$routes->post('/home/post_comment/(:any)', 'Main::post_comment/$1');
$routes->post('/home/thread', 'Main::get_search');
$routes->post('/home/post_thread', 'Main::post_thread');

$routes->get('/todo', 'Calender_todo::index');
$routes->post('/todo', 'Calender_todo::add_task');
$routes->get('/todo/1', 'Calender_todo::check_add_task');
$routes->get('/todo/2/(:any)', 'Calender_todo::remove_task/$1');
$routes->get('/todo/3', 'Calender_todo::check_remove_task');

$routes->get('/login', 'Login::index');
$routes->post('/login/check_login', 'Login::check_login');
$routes->post('/login/logout', 'Login::logout');
$routes->get('/login/create_account', 'CreateAccount::index');
$routes->get('/login/(:any)/create_account', 'CreateAccount::index');
$routes->post('/login/create_account', 'CreateAccount::create_account');
$routes->get('/login/(:num)', 'Login::index/$1');
$routes->get('/login/forget_password', 'Login::forget_password');
$routes->get('/login/forget_password/(:any)', 'Login::forget_password/$1');
$routes->post('/login/forget_password/submit', 'Login::check_forget_password');
$routes->get('login/reset/(:any)', 'Login::reset_password/$1');
$routes->post('login/reset/(:any)', 'Login::check_reset_password/$1');///////////////////
$routes->post('login/reseted', 'Login::updated_password');///////////////////

$routes->get('/profile', 'Profile::index');
$routes->post('/profile', 'Profile::index');
$routes->post('/profile/upload', 'Profile::upload_profile_picture');
$routes->post('/profile/upload/dz', 'Profile::dz', ['as' => 'dropzone']);///////////////
$routes->post('/profile/update', 'Profile::update');
$routes->post('/profile/check_update', 'Profile::check_update');
$routes->get('/profile/download', 'Profile::pdf');

$routes->get('/verify', 'Profile::email_verify');
$routes->get('/verify/token/(:any)', 'Profile::verify/$1');

$routes->get('/home/thread/(:any)/ajax', 'Main::like_unlike/$1');
$routes->match(['get','post'],'/home/thread/(:any)/ajax', 'Main::like_unlike/$1');

$routes->get('/home/ajax/(:any)', 'Main::search/$1');
$routes->match(['get','post'],'/home/ajax/(:any)', 'Main::search/$1');





/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
