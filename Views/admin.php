<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <!-- Du kan tilføje yderligere styling her -->
</head>
<body>
    <h1>Admin Page</h1>

    <!-- Kategori Formular -->
    <h2>Kategorier</h2>
    <form method="post" action="<?= getenv('BASE_URL')?>/admin/categories/process">

        <label for="category_name">Kategori Navn:</label>
        <input type="text" name="category_name" required>
        </br>

        <select name="category_id">
            <option value="">Vælg kategori (kun for opdatering)</option>
            <?php foreach ($Categories as $category): ?>
                <option value="<?php echo $category->kategori_id; ?>"><?php echo $category->kategori_navn; ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Gem</button>
    </form>

    <!-- Produkt Formular -->
    <h2>Produkter</h2>
    <form method="post" action="">
        <input type="hidden" name="product_form" value="true">

        <label for="product_name">Produkt Navn:</label>
        <input type="text" name="product_name" required>

        <label for="product_category">Kategori:</label>
        <select name="product_category" required>
            <option value="">Vælg kategori</option>
            <?php foreach ($Categories as $category): ?>
                <option value="<?php echo $category->kategori_id; ?>"><?php echo $category->kategori_navn; ?></option>
            <?php endforeach; ?>
        </select>

        <label for="product_quantity">Antal:</label>
        <input type="number" name="product_quantity" required>

        <label for="product_price">Pris:</label>
        <input type="number" step="0.01" name="product_price" required>

        <label for="product_description">Beskrivelse:</label>
        <textarea name="product_description" rows="4"></textarea>

        <label for="product_image">Billede URL:</label>
        <input type="text" name="product_image">

        <select name="product_id">
            <option value="">Vælg produkt (kun for opdatering)</option>
            <?php foreach ($Products as $product): ?>
                <option value="<?php echo $product->produkt_id; ?>"><?php echo $product->produkt_navn; ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Gem</button>
    </form>

    <!-- Slet Kategori Formular -->
    <h2>Slet Kategori</h2>
    <form method="post" action="<?= getenv('BASE_URL')?>/admin/categories/delete/<?= $category->kategori_id; ?>">
        <select name="category_id_to_delete" required>
            <option value="">Vælg kategori</option>
            <?php foreach ($Categories as $category): ?>
                <option value="<?php echo $category->kategori_id; ?>"><?php echo $category->kategori_navn; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Slet</button>
    </form>

    <!-- Slet Produkt Formular -->
    <h2>Slet Produkt</h2>
    <form method="post" action="">
        <input type="hidden" name="delete_product" value="true">

        <select name="product_id_to_delete" required>
            <option value="">Vælg produkt</option>
            <?php foreach ($Products as $product): ?>
                <option value="<?php echo $product->produkt_id; ?>"><?php echo $product->produkt_navn; ?></option>
            <?php endforeach; ?>
        </select>

        <a type="submit" href="<?= getenv('BASE_URL')?>/admin/products/delete/<?= $product->produkt_id; ?> ">Slet</a>
    </form>

    <!-- Du kan tilføje yderligere HTML eller styling her -->

</body>
</html>