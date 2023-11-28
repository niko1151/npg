<?php
// Importer vores controllers og starter session
use tec\npg\Controllers\{UserController, CategoryController, ProductController};
session_start();

// Indlæs autoload-fil og konfigurationsfiler
require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();


// Forside - Her bliver vores forside loaded
// $randomProducts - Henter tre tilfældige produkter fra ProductController, hver gang man refresher vores frontpage
Flight::route('/', function(){
    $randomProducts = ProductController::getThreeRandomProducts();    
    Flight::render('Frontpage', ["randomProducts" => $randomProducts], 'body_content');
    Flight::render('layout', array('title' => 'Forside - NPG'));
});

// En route til "om os" side
Flight::route('/about', function(){
    Flight::render('about', array('body'), 'body_content');
    Flight::render('layout', array('title' => 'Om os - NPG'));
});

// Her bliver bliver vores login side loaded
Flight::route('/login', function(){
    Flight::render('login', array('body'), 'body_content');
    Flight::render('layout', array('title' => 'Login - NPG'));
});

// Checklogin, kigger på om din email allerede er i vores database (fordi vi har not null unique) 
// og så tjekker den også nede i opret_login.php om begge passwords matcher hinanden
Flight::route('/checklogin', function(){
  // Henter email og adgangskode fra formdata, som er posted fra login.php
  $email = Flight::request()->data->mail;
  $adgangskode = Flight::request()->data->password;

  // Tjeker om denne bruger fineds i vores database ved at matche email og kode ved hjælp af UserController
  if($login = UserController::checkUserLogin($email, $adgangskode))
  {
    // Hvis login er succesfuldt, så gemmer vi brugerens kunde_id til $_Session, som er en superviable der gemmes i vores session.
    // $_SESSION['logged_in'] denne session bliver sat til true hvis der er en bruger.
    $_SESSION['user_id'] = $login->kunde_id;
    $_SESSION['logged_in'] = true;

    // Vis succesbesked
    Flight::render("error",["error_title" => "Sådan!!", "message" => "Du er nu logget ind"], "body_content");
    Flight::render("layout",["title" => "Login - NPG"]);    
  }
  else
  {
    // Vis fejlbesked, hvis brugeren har indtasted forkert data
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

// save_login routen håndtere det data, der er sendt fra opret_login.php 
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

  // Tager den data vi har hentet ovenover og sender den videre til creatuser som opretter brugeren
  UserController::createUser($FirstName, $LastName, $Email, $Telefon, $Pass, $Adresse, $By, $PostNr);

  // Vis succesbesked
  Flight::render("error",["error_title" => "Bruger", "message" => "Din bruger er nu oprettet"], "body_content");
  Flight::render("layout",["title" => "Login - NPG"]);
});

// Logout-route
Flight::route('/logout', function(){
  // Fjerner alle sessionvariabler og ødelæger sessionen, da vi ikke skal bruge de data mere fra den session.
  session_unset();
  session_destroy();
  // logud-besked
  Flight::render("error",["error_title" => "Log ud", "message" => "Du er nu logget ud"], "body_content");
  Flight::render("layout",["title" => "Login - NPG"]);   
});

// Kategori-rute
Flight::route('/category', function(){
  // Henter alle kategorier fra CategoryController via getAllCategories
  $categories = CategoryController::getAllCategories();
  // Sender alle kategorier ned til Category view
  Flight::render('Category', ["categories" => $categories], 'body_content');
  Flight::render('layout', array('title' => 'Kategori - NPG'));
});

// Profil-rute med dynamisk bruger-id som bliver sat på knappen i layout hvor den bruger session user_id
Flight::route('/profile/@id', function($id){
    // Henter brugeroplysninger via UserController baseret på session user_id
    $profile = UserController::getUser($id);
    // Render 'profile' - view med brugeroplysninger
    Flight::render('profile', ["profile"=>$profile], 'body_content');
    Flight::render('layout', ['title' => 'Profile - NPG']);
});

    
// Product-route
Flight::route('/product', function(){
    // Henter alle produkter fra ProductController
    $Product = ProductController::getAllProducts();
    Flight::render('Product', ["Product"=>$Product], 'body_content');
    Flight::render('layout', array('title' => 'Produkter - NPG'));
});

// Product-details-route får id sit id fra product view details knappen
Flight::route('/product_details/@id', function($id){
    // Henter produktdata baseret på produkt-id via ProductController
    $productDetails = ProductController::getProductDetails($id);
    Flight::render('product_details', ['productDetails' => $productDetails], 'body_content');
    Flight::render('layout', array('title' => 'Produktdetaljer - NPG'));
});

// Category-products-route får sit id fra den category man trykker på 
Flight::route('/category_products/@id', function($id){
    // Henter produktdata baseret på det kategori-id man har trykket på
    $categoryProducts = CategoryController::getProductsByCategory($id);
    Flight::render('category_products', ['categoryProducts' => $categoryProducts], 'body_content');
    Flight::render('layout', array('title' => 'Produkter efter kategori - NPG'));
});

// Admin-route
Flight::route('/admin', function(){
    // Henter alle produkter og kategorier fra ProductController og CategoryController
    $Products = ProductController::getAllProducts();
    $Categories = CategoryController::getAllCategories();
    // Render 'admin'-view med produkter og kategorier
    Flight::render('admin', ['Categories' => $Categories, 'Products' => $Products], 'body_content');
    Flight::render('layout', array('title' => 'Produkter - NPG'));
});

// Admin-categories-process-route tager kategori navn og opretter ny kategori
Flight::route('/admin/categories/process', function(){
    // Henter kategori-navn fra admin page
    $cat_navn = Flight::request()->data->category_name;
    // Opretter kategori med det angivet navn fra admin page
    CategoryController::addCategory($cat_navn);
    // Redirect tilbage til admin page
    Flight::redirect('/admin');
});

// Admin-products-process-route henter data fra admin page og putter dem ind i variabler som bliver sendt nedtil add product
Flight::route('/admin/products/process', function(){
    // Henter produktdata fra admin page
    $productName = Flight::request()->data->product_name;
    $categoryId = Flight::request()->data->product_category;
    $quantity = Flight::request()->data->product_quantity;
    $price = Flight::request()->data->product_price;
    $description = Flight::request()->data->product_description;
    $imageUrl = Flight::request()->data->product_image;
    // Tilføjer data til de angivet variabler, og opretter et nyt produkt
    ProductController::addProduct($productName, $categoryId,$quantity, $price, $description, $imageUrl);

  Flight::redirect('/admin'); // Redirect tilbage til admin dashboard
});

// admin-products-update-route Modtager det valgte id fra edit_product siden
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

// admin-caregories-update-route modtager id fra edit_category
Flight::route('/admin/categories/update', function(){
  $categoryId = Flight::request()->data->edit_category_id;
  $edit_Category_Name = Flight::request()->data->edit_category_name;
  // opdatere category navn baseret på det valgte id
  CategoryController::updateCategory($categoryId, $edit_Category_Name);

  Flight::redirect('/admin'); // Redirect tilbage til admin dashboard
});

// admin-categories-delete-route modtager id fra admin page, og deleter det id fra databasen
Flight::route('/admin/categories/delete/@id', function($cat_id){
  $cat_id = Flight::request()->data->category_id_to_delete;
  CategoryController::deleteCategory($cat_id);

  Flight::redirect('/admin'); // Redirect tilbage til admin dashboard
});

// admin-products-delete modtager id fra admin page, og deleter det id fra databasen
Flight::route('/admin/products/delete/@id', function($prod_id){
  $prod_id = Flight::request()->data->product_id_to_delete;
  ProductController::deleteProduct($prod_id);

  Flight::redirect('/admin'); // Redirect tilbage til admin dashboard
});

// admin-category-edit modtager sit id fra admin page, hvor den så heneter den kategori fra databasen 
Flight::route('/admin/category/edit/@cat_id', function($cat_id){
  $editcategory = CategoryController::getCategoryById($cat_id);
  Flight::render('editcategory', ["editcategory"=>$editcategory, "cat_id" => $cat_id], 'body_content');
  Flight::render('layout', ['title' => 'editcategory - NPG']);
});

// admin-products-edit modtager sit id fra admin page, hvor den så heneter det produkt fra databasen
Flight::route('/admin/product/edit/@prod_id', function($prod_id){
  $editproduct = ProductController::getProductById($prod_id);
  $Categories = CategoryController::getAllCategories();
  Flight::render('editproduct', ["editproduct" => $editproduct, "Categories" => $Categories, "prod_id" => $prod_id], 'body_content');
  Flight::render('layout', ['title' => 'Rediger produkt - NPG']);
});

// Modtager id via ajax fra tilføj til kurv knappen 
Flight::route('/addToCart/@id', function($id){
  ProductController::addToCart($id);
});

// /cart læser de ting som er i cart som er blevet tilføjet via tilføj i kurv
Flight::route('/cart', function(){
  // Henter cart fra session
  $cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
  Flight::render('cart', ['cartItems' => $cartItems], 'body_content');
  Flight::render('layout', ['title' => 'Cart - NPG']);
});

// Dette bliver kørt når man inde i sin kurv trykker på fjern, hvor den så fjerne det valgte id fra den linje man fjernede
Flight::route('/removeFromCart', function(){
  Flight::render('removeFromCart', [], 'body_content');
});

// udskriver hvad man har i kurven
Flight::route('/checkout', function(){
  // Call the addToCart method in your ProductController
  Flight::render('checkout', [], 'body_content');
  Flight::render('layout', ['title' => 'Cart - NPG']);
});

// tjekker om brugeren har et login eller ej efter det er blevet betalt
Flight::route('/process_checkout', function(){
  if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    // Planen med dette er at vi allerede har den data vi skal bruge fra en bruger, der er logget ind til at opretter data i databsen.
    Flight::render("error",["error_title" => "Checkout", "message" => "Din ordre er nu gennemført - er logget ind"], "body_content");
    Flight::render("layout",["title" => "Login - NPG"]);
    unset($_SESSION['cart']);
    } else { 
    // planen med dette er, at man skulle kunne tage det info som en bruger har oplyst inde i checkout til at kunne oprette deres ordre
    Flight::render("error",["error_title" => "Checkout", "message" => "Din ordre er nu gennemført"], "body_content");
    Flight::render("layout",["title" => "Login - NPG"]);
    unset($_SESSION['cart']);
    }
});

// $searchQuery henter værdien fra name i search box under input
// $ searchResults tager værdien fra searchQuery og sender til kontrolleren som håndtere dataen fra databasen
Flight::route('/product/search', function(){
  $searchQuery = Flight::request()->query['search'];
  $searchResults = ProductController::searchProducts($searchQuery);
  Flight::render('search_live_results', ['searchResults' => $searchResults]);
});

Flight::start();