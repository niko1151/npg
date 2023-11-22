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

Flight::route('/admin', function(){
  $Products = ProductController::getAllProducts();
  $Categories = CategoryController::getAllCategories();
  Flight::render('admin', ['Categories' => $Categories, 'Products' => $Products], 'body_content');
  Flight::render('layout', array('title' => 'Produkter - NPG'));
});

// Route to handle form submission for categories
Flight::route('/admin/categories/process', function(){
  $catid = Flight::request()->data->category_id;
  $cat_navn = Flight::request()->data->category_name;
  if ($catid) {
    // Opdater eksisterende kategori
    CategoryController::updateCategory($catid, $cat_navn);
} else {
    // Opret ny kategori
    CategoryController::addCategory($cat_navn);
}
  Flight::redirect('/admin'); // Redirect tilbage til admin dashboard
});

// Route to handle form submission for products
Flight::route('/admin/products/process', function(){
  $postData = Flight::request()->data->getData();

  // Process the form data for products
  $productName = $postData['product_name'];
  $categoryId = $postData['product_category'];
  $quantity = $postData['product_quantity'];
  $price = $postData['product_price'];
  $description = $postData['product_description'];
  $imageUrl = $postData['product_image'];
  $productId = $postData['product_id']; // Dette felt vil kun være til stede ved opdatering

  if (isset($productId)) {
      // Opdater eksisterende produkt
      ProductController::updateProduct($productId, $productName, $categoryId, $quantity, $price, $description, $imageUrl);
  } else {
      // Opret nyt produkt
      ProductController::addProduct($productName, $categoryId, $quantity, $price, $description, $imageUrl);
  }

  Flight::redirect('/admin'); // Redirect tilbage til admin dashboard
});

// Route to handle form submission for deleting categories
Flight::route('/admin/categories/delete/@id', function($cat_id){
  $cat_id = Flight::request()->data->category_id_to_delete;

  // Process the form data for deleting categories
  CategoryController::deleteCategory($cat_id);

  Flight::redirect('/admin'); // Redirect tilbage til admin dashboard
});

// Route to handle form submission for deleting products
Flight::route('/admin/products/delete/@id', function($id){


  // Process the form data for deleting products
  ProductController::deleteProduct($id);
  
  Flight::redirect('/admin'); // Redirect tilbage til admin dashboard
});

Flight::start();