<?php

use tec\npg\Controllers\UserController;


require __DIR__ . '/vendor/autoload.php';

session_start();
include 'db_config.php';

function isUserLoggedIn() {
  return isset($_SESSION['username']);
}


//Test 1233444
// Load environment variables from .env file in the project root directory.
// $dotenv = Dotenv\Dotenv::create(__DIR__);
// $dotenv->load();

Flight::route('/', function(){
  Flight::render('frontpage', array('body'), 'body_content');
  Flight::render('layout', array('title' => 'Forside - NPG'));
 });

 Flight::route('/about', function(){
  Flight::render('about', array('body'), 'body_content');
  Flight::render('layout', array('title' => 'Om os - NPG'));
});

Flight::route('/login', function(){
  $login = UserController::checkUserLogin();
  Flight::render('login', array('body'), 'body_content');
  Flight::render('layout', array('title' => 'Login - NPG'));
});

Flight::route('/logout', function () {
  // Handle logout logic (destroy session, etc.)
  session_start();
  session_destroy();
  // Redirect to the homepage or login page
  Flight::redirect('/');
});

Flight::route('/category', function(){
  Flight::render('category', array('body'), 'body_content');
  Flight::render('layout', array('title' => 'Kategori - NPG'));
});

Flight::start();