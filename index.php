<?php

// Importer nødvendige klasser og start session
use tec\npg\Controllers\{UserController, CategoryController, ProductController};
session_start();

// Indlæs autoload-fil og konfigurationsfiler
require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

// Håndter ruter og tilhørende funktioner

// Forsiderute
Flight::route('/', function(){
    // Hent tre tilfældige produkter fra ProductController
    $randomProducts = ProductController::getThreeRandomProducts();
    
    // Render 'Frontpage'-visningen med tilfældige produkter
    Flight::render('Frontpage', ["randomProducts" => $randomProducts], 'body_content');
    Flight::render('layout', array('title' => 'Forside - NPG'));
});


// Om os-rute
Flight::route('/about', function(){
    // Render 'about'-visningen
    Flight::render('about', array('body'), 'body_content');
    Flight::render('layout', array('title' => 'Om os - NPG'));
});

// Login-rute
Flight::route('/login', function(){
    // Render 'login'-visningen
    Flight::render('login', array('body'), 'body_content');
    Flight::render('layout', array('title' => 'Login - NPG'));
});

// Check-login-rute
Flight::route('/checklogin', function(){
    // Hent email og adgangskode fra formdata
    $email = Flight::request()->data->mail;
    $adgangskode = Flight::request()->data->password;

    // Tjek brugerlogin ved hjælp af UserController
    if($login = UserController::checkUserLogin($email, $adgangskode))
    {
        // Hvis login er succesfuldt, gem brugeroplysninger i session
        $_SESSION['user_id'] = $login->kunde_id;
        $_SESSION['logged_in'] = true;

        // Vis succesbesked
        Flight::render("error",["error_title" => "Sådan!!", "message" => "Du er nu logget ind"], "body_content");
        Flight::render("layout",["title" => "Login - NPG"]);    
    }
    else
    {
        // Vis fejlbesked ved fejl i login
        Flight::render("error",["error_title" => "ups", "message" => "Din Email og adgangskode passer ikke sammen"], "body_content");
        Flight::render("layout",["title" => "Login - NPG"]);   
    }
});

// Opret-login-rute
Flight::route('/opret_Login', function(){
    // Render 'opret_login'-visningen
    Flight::render('opret_login', array('body'), 'body_content');
    Flight::render('layout', array('title' => 'Login - NPG'));
});

// Gem-login-rute
Flight::route('/save_Login', function(){
    // Hent formdata fra anmodningen
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

    // Opret bruger i databasen ved hjælp af UserController
    UserController::createUser($FirstName, $LastName, $Email, $Telefon, $Pass, $Adresse, $By, $PostNr);

    // Vis succesbesked
    Flight::render("error",["error_title" => "Bruger", "message" => "Din bruger er nu oprettet"], "body_content");
    Flight::render("layout",["title" => "Login - NPG"]);
});

// Logud-rute
Flight::route('/logout', function(){
    // Fjern alle sessionvariabler og ødelæg sessionen
    session_unset();
    session_destroy();
    // Vis logud-besked
    Flight::render("error",["error_title" => "Log ud", "message" => "Du er nu logget ud"], "body_content");
    Flight::render("layout",["title" => "Login - NPG"]);   
});

// Kategori-rute
Flight::route('/category', function(){
    // Hent alle kategorier fra CategoryController
    $categories = CategoryController::getAllCategories();
    // Render 'Category'-visningen med kategorierne
    Flight::render('Category', ["categories" => $categories], 'body_content');
    Flight::render('layout', array('title' => 'Kategori - NPG'));
});

// Profil-rute med dynamisk bruger-id
Flight::route('/profile/@id', function($id){
    // Hent brugeroplysninger ved hjælp af UserController baseret på bruger-id
    $profile = UserController::getUser($id);
    // Render 'profile'-visningen med brugeroplysninger
    Flight::render('profile', ["profile"=>$profile], 'body_content');
    Flight::render('layout', ['title' => 'Profile - NPG']);
});
    
// Produkt-rute
Flight::route('/product', function(){
    // Hent alle produkter fra ProductController
    $Product = ProductController::getAllProducts();
    // Render 'Product'-visningen med produkterne
    Flight::render('Product', ["Product"=>$Product], 'body_content');
    Flight::render('layout', array('title' => 'Produkter - NPG'));
});

// Produkt-detaljer-rute med dynamisk produkt-id
Flight::route('/product_details/@id', function($id){
    // Hent produktdata baseret på produkt-id ved hjælp af ProductController
    $productDetails = ProductController::getProductDetails($id);
    // Render 'product_details'-visningen med produktdata
    Flight::render('product_details', ['productDetails' => $productDetails], 'body_content');
    Flight::render('layout', array('title' => 'Produktdetaljer - NPG'));
});

// Kategori-produkter-rute med dynamisk kategori-id
Flight::route('/category_products/@id', function($id){
    // Hent produktdata baseret på kategori-id ved hjælp af CategoryController
    $categoryProducts = CategoryController::getProductsByCategory($id);
    // Render 'category_products'-visningen med produktdata
    Flight::render('category_products', ['categoryProducts' => $categoryProducts], 'body_content');
    Flight::render('layout', array('title' => 'Produkter efter kategori - NPG'));
});

// Admin-rute
Flight::route('/admin', function(){
    // Hent alle produkter og kategorier fra ProductController og CategoryController
    $Products = ProductController::getAllProducts();
    $Categories = CategoryController::getAllCategories();
    // Render 'admin'-visningen med produkter og kategorier
    Flight::render('admin', ['Categories' => $Categories, 'Products' => $Products], 'body_content');
    Flight::render('layout', array('title' => 'Produkter - NPG'));
});

// Admin-kategorier-process-rute til håndtering af formularindsendelse for kategorier
Flight::route('/admin/categories/process', function(){
    // Hent kategori-id og kategori-navn fra formdata
    $catid = Flight::request()->data->category_id;
    $cat_navn = Flight::request()->data->category_name;
    
    // Opdater eksisterende kategori eller opret ny kategori baseret på kategori-id
    if ($catid) {
        CategoryController::updateCategory($catid, $cat_navn);
    } else {
        CategoryController::addCategory($cat_navn);
    }
    
    // Redirect tilbage til admin dashboard
    Flight::redirect('/admin');
});

// Admin-produkter-process-rute til håndtering af formularindsendelse for produkter
Flight::route('/admin/products/process', function(){
    // Hent produktdata fra formdata
    $productName = Flight::request()->data->product_name;
    $categoryId = Flight::request()->data->product_category;
    $quantity = Flight::request()->data->product_quantity;
    $price = Flight::request()->data->product_price;
    $description = Flight::request()->data->product_description;
    $imageUrl = Flight::request()->data->product_image;
    
    // Opret nyt produkt ved hjælp af ProductController
    ProductController::addProduct($productName, $categoryId,$quantity, $price, $description, $imageUrl);
    
    // Redirect tilbage til admin dashboard
    Flight::redirect('/admin');
});

// Admin-produkter-update-rute til håndtering af formularindsendelse for produktopdatering
Flight::route('/admin/products/update', function(){
    // Hent produktdata fra formdata
    $productId = Flight::request()->data->product_id_to_edit;
    $edit_product_name = Flight::request()->data->edit_product_name;
    $edit_product_category_id = Flight::request()->data->edit_product_category_id;
    $edit_product_quantity = Flight::request()->data->edit_product_quantity;
    $edit_product_price = Flight::request()->data->edit_product_price;
    $edit_product_description = Flight::request()->data->edit_product_description;
    $edit_product_imageUrl = Flight::request()->data->edit_product_imageUrl;
    
    // Opdater produkt ved hjælp af ProductController
    ProductController::updateProduct($productId,$edit_product_name, $edit_product_category_id,$edit_product_quantity, $edit_product_price, $edit_product_description, $edit_product_imageUrl);
    
    // Redirect tilbage til admin dashboard
    Flight::redirect('/admin');
});

// Admin-kategorier-update-rute til håndtering af formularindsendelse for kategoriopdatering
Flight::route('/admin/categories/update', function(){
    // Hent kategori-id og kategori-navn fra formdata
    $categoryId = Flight::request()->data->edit_category_id;
    $edit_Category_Name = Flight::request()->data->edit_category_name;
    
    // Opdater kategori ved hjælp af CategoryController
    CategoryController::updateCategory($categoryId, $edit_Category_Name);
    
    // Redirect tilbage til admin dashboard
    Flight::redirect('/admin');
});

// Admin-kategorier-delete-rute til håndtering af formularindsendelse for kategorisletning
Flight::route('/admin/categories/delete/@id', function($cat_id){
    // Hent kategori-id fra formdata
    $cat_id = Flight::request()->data->category_id_to_delete;
    
    // Slet kategori ved hjælp af CategoryController
    CategoryController::deleteCategory($cat_id);
    
    // Redirect tilbage til admin dashboard
    Flight::redirect('/admin');
});

// Admin-produkter-delete-rute til håndtering af formularindsendelse for produktsletning
Flight::route('/admin/products/delete/@id', function($prod_id){
    // Hent produkt-id fra formdata
    $prod_id = Flight::request()->data->product_id_to_delete;
    
    // Slet produkt ved hjælp af ProductController
    ProductController::deleteProduct($prod_id);
    
    // Redirect tilbage til admin dashboard
    Flight::redirect('/admin');
});

// Admin-rediger-kategori-rute med dynamisk kategori-id
Flight::route('/admin/category/edit/@cat_id', function($cat_id){
    // Hent kategorioplysninger ved hjælp af CategoryController baseret på kategori-id
    $editcategory = CategoryController::getCategoryById($cat_id);
    // Render 'editcategory'-visningen med kategorioplysninger
    Flight::render('editcategory', ["editcategory"=>$editcategory, "cat_id" => $cat_id], 'body_content');
    Flight::render('layout', ['title' => 'editcategory - NPG']);
});

// Admin-rediger-produkt-rute med dynamisk produkt-id
Flight::route('/admin/product/edit/@prod_id', function($prod_id){
    // Hent produktoplysninger ved hjælp af ProductController baseret på produkt-id
    $editproduct = ProductController::getProductById($prod_id);
    // Hent alle kategorier fra CategoryController
    $Categories = CategoryController::getAllCategories();
    // Render 'editproduct'-visningen med produktoplysninger og kategorier
  Flight::render('layout', ['title' => 'Rediger produkt - NPG']);
});

// $searchQuery henter værdien fra name i search box under input
// $ searchResults tager værdien fra searchQuery og sender til kontrolleren som håndtere dataen fra databasen
Flight::route('/product/search', function(){
  $searchQuery = Flight::request()->query['search'];
  $searchResults = ProductController::searchProducts($searchQuery);
  Flight::render('search_live_results', ['searchResults' => $searchResults]);
});

Flight::start();