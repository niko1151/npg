<?php
//require_once 'vendor/autoload.php';

// Få produkt-ID fra URL-parametret
//$productId = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

// Hent produkt detaljer
//$productDetails = ProductController::getProductDetails($productId);

// if (!$productDetails) {
//     // Produktet blev ikke fundet, håndter fejl, f.eks. viderestil til en fejlsiden
//     header("Location: error.php");
//     exit();
// }

// Vis produkt detaljer
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $productDetails->produkt_navn; ?> - Produkt Detaljer</title>
    <!-- Tilføj eventuelt styling eller scripts her -->
</head>
<body>
    <h1><?= $productDetails->produkt_navn; ?> - Produkt Detaljer</h1>
    <p><strong>Pris:</strong> <?= number_format($productDetails->pris, 2); ?> DKK</p>
    <p><strong>Kategori:</strong> <?= $productDetails->kategori_navn; ?></p>
    <p><strong>Beskrivelse:</strong> <?= $productDetails->beskrivelse; ?></p>
</body>
</html>