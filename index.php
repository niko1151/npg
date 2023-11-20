<?php

use tec\npg\Controllers\UserController;
use tec\npg\Controllers\CategoryController;


require __DIR__ . '/vendor/autoload.php';


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


Flight::route('/category', function(){
  $Category = CategoryController::getAllCategory();
  Flight::render('Category', ["Category"=>$Category], 'body_content');
  Flight::render('layout', array('title' => 'Kategori - NPG'));
});

Flight::start();