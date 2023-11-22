<?php


use tec\npg;
use tec\npg\Controllers\{UserController,CategoryController, ProductController};



require __DIR__ . '/vendor/autoload.php';


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
  $id = Flight::request()->query->kunde_id;

  if($login = UserController::checkUserLogin($email, $adgangskode))
  {
    // Set session variables upon successful login
    $_SESSION['user_id'] = $id; // Store user ID or any relevant data
    $_SESSION['logged_in'] = true; // Set a flag to indicate the user is logged in
    Flight::render("error",["error_title" => "Sådan!!", "message" => "Du er nu logget ind"], "body_content");
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
  $categories = CategoryController::getAllCategories();
  Flight::render('Category', ["categories" => $categories], 'body_content');
  Flight::render('layout', array('title' => 'Kategori - NPG'));
});

Flight::route('/product', function(){
  $Product = ProductController::getAllProducts();
  Flight::render('Product', ["Product"=>$Product], 'body_content');
  Flight::render('layout', array('title' => 'Produkter - NPG'));
});

Flight::route('/product_details/@id', function($id){
  // Hent faktiske produktdata baseret på produkt-id
  $productDetails = ProductController::getProductDetails($id);
  // Send produktdata til visning
  Flight::render('product_details', ['productDetails' => $productDetails], 'body_content');
  Flight::render('layout', array('title' => 'Produktdetaljer - NPG'));
});

Flight::route('/category_products/@id', function($id){
  // Hent faktiske produktdata baseret på kategori-id
  $categoryProducts = CategoryController::getProductsByCategory($id);
  // Send produktdata til visning
  Flight::render('category_products', ['categoryProducts' => $categoryProducts], 'body_content');
  Flight::render('layout', array('title' => 'Produkter - NPG'));
});

Flight::start();