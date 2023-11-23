<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page - Rediger Produkt</title>
    <style>
        h1, h2 {
            color: #333;
        }

        form {
            margin-bottom: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button,
        a {
            padding: 10px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            border-radius: 4px;
            width: auto;
            color: white;
        }

        button[type="submit"] {
            background-color: #4caf50; /* Grøn farve */
        }

        a[type="submit"] {
            background-color: #f44336; /* Rød farve */
        }

        button:hover[type="submit"],
        a:hover[type="submit"] {
            background-color: #45a049; /* Mørkere grøn farve */
        }

        button[type="submit"]:hover,
        a:hover[type="submit"] {
            background-color: #f44336; /* Mørkere rød farve */
        }
    </style>
</head>

<body>
<h1>Admin Page</h1>

<!-- Rediger Produkt Formular -->
    <h2>Rediger Produkt</h2>
    <form method="post" action="<?= getenv('BASE_URL')?>/admin/products/update" id="editProductForm">
        <!-- Inputfelt til fast produktID (kan skjules, hvis det ønskes) -->
        <input type="hidden" name="product_id_to_edit" id="product_id_to_edit" value="<?= $prod_id; ?>">

     <!-- Inputfelter for redigering -->
        <label for="product_name">Produkt Navn:</label>
        <input type="text" name="product_name" id="selectedValue" value="<?= isset($editproduct->produkt_navn) ? $editproduct->produkt_navn : ''; ?>" required>

        <label for="product_category">Vælg kategori:</label>
        <select name="product_category" required>
           <option value="">Vælg kategori</option>
          <?php foreach ($Categories as $category): ?>
              <option value="<?php echo $category->kategori_id; ?>"><?php echo $category->kategori_navn; ?></option>
          <?php endforeach; ?>
        </select>

        <label for="product_quantity">Antal:</label>
        <input type="number" name="product_quantity" value="<?= isset($editproduct->antal) ? $editproduct->antal : ''; ?>" required>

        <label for="product_price">Pris:</label>
        <input type="number" step="0.01" name="product_price" value="<?= isset($editproduct->pris) ? $editproduct->pris : ''; ?>" required>

        <label for="product_description">Beskrivelse:</label>
        <textarea name="product_description" rows="4"><?= isset($editproduct->beskrivelse) ? $editproduct->beskrivelse : ''; ?></textarea>

        <label for="product_image">Billede URL:</label>
        <input type="text" name="product_image" value="<?= isset($editproduct->billede_url) ? $editproduct->billede_url : ''; ?>">

        <!-- Opdater knap -->
        <button type="submit">Opdater</button>
    </form>
</body>

</html>