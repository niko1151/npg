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


Flight::route('/category', function(){
  //$categoryController = new \tec\npg\Controllers\CategoryController();
  //$categories = $categoryController->getAllCategories();
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