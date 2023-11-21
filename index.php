<?php
use tec\npg\Controllers\UserController;
use tec\npg\Controllers\CategoryController;

require __DIR__ . '/vendor/autoload.php';

session_start();



//Load environment variables from .env file in the project root directory.
$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

Flight::route('/', function(){
  Flight::render('frontpage', array('body'), 'body_content');
  Flight::render('layout', array('title' => 'Forside - NPG'));
 });

 Flight::route('/about', function(){
  Flight::render('about', array('body'), 'body_content');
  Flight::render('layout', array('title' => 'Om os - NPG'));
});

Flight::route('/login', function(){
  Flight::render('login', array('body'), 'body_content');
  Flight::render('layout', array('title' => 'Login - NPG'));
});

Flight::route('/checklogin', function(){
  $email = Flight::request()->data->mail;
  $adgangskode = Flight::request()->data->password;
  $id = Flight::request()->data->kunde_id;

  if($login = UserController::checkUserLogin($email, $adgangskode))
  {
    // Set session variables upon successful login
    //$_SESSION['user_id'] = $login->kunde_id; // Store user ID or any relevant data
    $_SESSION['logged_in'] = true; // Set a flag to indicate the user is logged in

    Flight::set('login_id', $login->kunde_id);

  // Elsewhere in your application
    Flight::render("error",["error_title" => "Sådan!!", "message" => "Du er nu logget ind"], "body_content");
    //Flight::redirect(getenv('BASE_URL')."/profile/".$login->kunde_id);
    Flight::render("layout",["title" => "Login - NPG"]);    

  }
  else
  {
    Flight::render("error",["error_title" => "ups", "message" => "Din Email og adgangskode passer ikke sammer"], "body_content");
    Flight::render("layout",["title" => "Login - NPG"]);   
  }
});

Flight::route('/logout', function(){
  // Unset all session variables
  session_unset();

  // Destroy the session
  session_destroy();
  Flight::render("error",["error_title" => "Log ud", "message" => "Du er nu logget ud"], "body_content");
  Flight::render("layout",["title" => "Login - NPG"]);   
});

Flight::route('/category', function(){
  $Category = CategoryController::getAllCategory();
  Flight::render('Category', ["Category"=>$Category], 'body_content');
  Flight::render('layout', array('title' => 'Kategori - NPG'));
});

Flight::route('/profile/@id', function($id){
  $profile = UserController::getUser($id);
  Flight::render('profile', ["profile"=>$profile], 'body_content');
  Flight::render('layout', ['title' => 'Profile - NPG']);
});

Flight::start();