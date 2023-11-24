<?php
use tec\npg;
use tec\npg\Controllers\{UserController,CategoryController, ProductController};

session_start();

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

  if($login = UserController::checkUserLogin($email, $adgangskode))
  {
    $_SESSION['user_id'] = $login->kunde_id; // Store user ID or any relevant data
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

Flight::route('/opret_Login', function(){
  Flight::render('opret_login', array('body'), 'body_content');
  Flight::render('layout', array('title' => 'Login - NPG'));
});

Flight::route('/save_Login', function(){
  $data = Flight::request()->data;
  $id = Flight::request()->data->id;
  $FirstName = Flight::request()->data->CreateFirstName;
  $LastName = Flight::request()->data->CreateLastName;
  $Email = Flight::request()->data->CreateEmail;
  $Telefon = Flight::request()->data->CreateTelefonNummer;
  $Pass = Flight::request()->data->CreatePassword;
  $Adresse = Flight::request()->data->CreateAdresse;
  $By = Flight::request()->data->CreateByNavn;
  $PostNr = Flight::request()->data->CreatePostNummer;

  UserController::createUser($FirstName, $LastName, $Email, $Telefon, $Pass, $Adresse, $By, $PostNr);

  Flight::render("error",["error_title" => "Bruger", "message" => "Din bruger er nu oprettet"], "body_content");
  Flight::render("layout",["title" => "Login - NPG"]);
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

Flight::route('/profile/@id', function($id){
  $profile = UserController::getUser($id);
  Flight::render('profile', ["profile"=>$profile], 'body_content');
  Flight::render('layout', ['title' => 'Profile - NPG']);
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

Flight::route('/addToCart/@id', function($id){
  // Call the addToCart method in your ProductController
  ProductController::addToCart($id);
});-

Flight::route('/cart', function(){
  // Fetch cart information from the session
  $cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

  // Pass the cart items to the 'cart' view for rendering
  Flight::render('cart', ['cartItems' => $cartItems], 'body_content');
  Flight::render('layout', ['title' => 'Cart - NPG']);
});

Flight::start();