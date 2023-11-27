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
    $productName = Flight::request()->data->product_name;
    $categoryId = Flight::request()->data->product_category;
    $quantity = Flight::request()->data->product_quantity;
    $price = Flight::request()->data->product_price;
    $description = Flight::request()->data->product_description;
    $imageUrl = Flight::request()->data->product_image;
    ProductController::addProduct($productName, $categoryId,$quantity, $price, $description, $imageUrl);


  Flight::redirect('/admin'); // Redirect tilbage til admin dashboard
});

Flight::route('/admin/products/update', function(){
  $productId = Flight::request()->data->product_id_to_edit;
  $edit_product_name = Flight::request()->data->edit_product_name;
  $edit_product_category_id = Flight::request()->data->edit_product_category_id;
  $edit_product_quantity = Flight::request()->data->edit_product_quantity;
  $edit_product_price = Flight::request()->data->edit_product_price;
  $edit_product_description = Flight::request()->data->edit_product_description;
  $edit_product_imageUrl = Flight::request()->data->edit_product_imageUrl;
  ProductController::updateProduct($productId,$edit_product_name, $edit_product_category_id,$edit_product_quantity, $edit_product_price, $edit_product_description, $edit_product_imageUrl);
Flight::redirect('/admin'); // Redirect tilbage til admin dashboard
});

Flight::route('/admin/categories/update', function(){
  $categoryId = Flight::request()->data->edit_category_id;
  $edit_Category_Name = Flight::request()->data->edit_category_name;
  CategoryController::updateCategory($categoryId, $edit_Category_Name);

  Flight::redirect('/admin'); // Redirect tilbage til admin dashboard
});

// DELETE
Flight::route('/admin/categories/delete/@id', function($cat_id){
  $cat_id = Flight::request()->data->category_id_to_delete;
  // Process the form data for deleting categories
  CategoryController::deleteCategory($cat_id);

  Flight::redirect('/admin'); // Redirect tilbage til admin dashboard
});

//DELETE
Flight::route('/admin/products/delete/@id', function($prod_id){
  $prod_id = Flight::request()->data->product_id_to_delete;
  // Process the form data for deleting products
  ProductController::deleteProduct($prod_id);

  Flight::redirect('/admin'); // Redirect tilbage til admin dashboard
});

Flight::route('/admin/category/edit/@cat_id', function($cat_id){
  $editcategory = CategoryController::getCategoryById($cat_id);
  Flight::render('editcategory', ["editcategory"=>$editcategory, "cat_id" => $cat_id], 'body_content');
  Flight::render('layout', ['title' => 'editcategory - NPG']);
});
    
Flight::route('/admin/product/edit/@prod_id', function($prod_id){
  $editproduct = ProductController::getProductById($prod_id);
  $Categories = CategoryController::getAllCategories();
  Flight::render('editproduct', ["editproduct" => $editproduct, "Categories" => $Categories, "prod_id" => $prod_id], 'body_content');
  Flight::render('layout', ['title' => 'Rediger produkt - NPG']);
});

// routes.php eller tilsvarende
Flight::route('/product/search', function(){
  $searchQuery = Flight::request()->query['search'];
  $searchResults = ProductController::searchProducts($searchQuery);
  Flight::render('search_live_results', ['searchResults' => $searchResults]);
});

Flight::start();