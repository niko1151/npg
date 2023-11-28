<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $productDetails->produkt_navn; ?> - Produkt Detaljer</title>
</head>
<body>
        <!-- Udskriver det produkt man har trykket-->
    <h1><?= $productDetails->produkt_navn; ?> - Produkt Detaljer</h1>
    <p><strong>Pris:</strong> <?= number_format($productDetails->pris, 2); ?> DKK</p>
    <p><strong>Kategori:</strong> <?= $productDetails->kategori_navn; ?></p>
    <p><strong>Beskrivelse:</strong> <?= $productDetails->beskrivelse; ?></p>
</body>
</html>