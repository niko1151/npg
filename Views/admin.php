<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <style>
        h1, h2 {
            color: white;
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

    <!-- Kategori Formular -->
    <h2>Kategorier</h2>
    <form method="post" action="<?= getenv('BASE_URL')?>/admin/categories/process">
        <label for="category_name">Kategori Navn:</label>
        <input type="text" name="category_name" required>
        <button type="submit">Opret</button>
    </form>

    <!-- Produkt Formular -->
    <h2>Produkter</h2>
    <form method="post" action="" id="productForm">
        <input type="hidden" name="product_form" value="true">
        <label for="product_name">Produkt Navn:</label>
        <input type="text" name="product_name" id="selectedValue" required>
        <label for="product_category">Vælg kategori:</label>
        <select name="product_category" required>
            <option value="">Vælg kategori</option>
            <?php foreach ($Categories as $category): ?>
                <option value="<?php echo $category->kategori_id; ?>"><?php echo $category->kategori_navn; ?></option>
            <?php endforeach; ?>
        </select>
        <label for="product_quantity">Antal:</label>
        <input type="number" name="product_quantity" value="" required>
        <label for="product_price">Pris:</label>
        <input type="number" step="0.01" name="product_price" required>
        <label for="product_description">Beskrivelse:</label>
        <textarea name="product_description" rows="4"></textarea>
        <label for="product_image">Billede URL:</label>
        <input type="text" name="product_image">
        <button type="submit">Opret</button>
    </form>

    <!-- Slet Kategori Formular -->
    <h2>Slet Kategori</h2>
    <form method="post" action="<?= getenv('BASE_URL')?>/admin/categories/delete/<?= $category->kategori_id; ?>">
        <label for="category_id_to_delete">Vælg kategori:</label>
        <select name="category_id_to_delete" required>
            <option value="">Vælg kategori</option>
            <?php foreach ($Categories as $category): ?>
                <option value="<?php echo $category->kategori_id; ?>"><?php echo $category->kategori_navn; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Slet Kategori</button>
    </form>

    <h2>Rediger Kategori</h2>
<form method="post" action="">
    <label for="category_id_to_edit">Vælg kategori:</label>
    <select name="category_id_to_edit" id="editCategoryDropdown" required>
        <option value="">Vælg kategori</option>
        <?php foreach ($Categories as $category): ?>
            <option value="<?php echo $category->kategori_id; ?>"><?php echo $category->kategori_navn; ?></option>
        <?php endforeach; ?>
    </select>
    <a href="#" id="editCategoryLink">Rediger</a>

    <script>
        document.getElementById('editCategoryDropdown').addEventListener('change', function () {
            var selectedCategoryId = this.value;
            var editCategoryLink = document.getElementById('editCategoryLink');
            editCategoryLink.href = '<?= getenv('BASE_URL')?>/admin/category/edit/' + selectedCategoryId;
        });
    </script>
</form>
    

    
    <!-- Slet Produkt Formular -->
    <h2>Slet Produkt</h2>
    <form method="post" action="">
        <input type="hidden" name="delete_product" value="true">
        <label for="product_id_to_delete">Vælg produkt:</label>
        <select name="product_id_to_delete" required>
            <option value="">Vælg produkt</option>
                <?php foreach ($Products as $product): ?>
                 <option value="<?php echo $product->produkt_id; ?>"><?php echo $product->produkt_navn; ?></option>
                <?php endforeach; ?>
        </select>
        <button type="submit">Slet Produkt</button>
    </form>

    <h2>Rediger Produkt</h2>
<form method="post" action="">
    <label for="product_id_to_edit">Vælg produkt:</label>
    <select name="product_id_to_edit" id="editProductDropdown" required>
        <option value="">Vælg produkt</option>
        <?php foreach ($Products as $product): ?>
            <option value="<?php echo $product->produkt_id; ?>"><?php echo $product->produkt_navn; ?></option>
        <?php endforeach; ?>
    </select>
    <a href="#" id="editProductLink">Rediger</a>

    <script>
        document.getElementById('editProductDropdown').addEventListener('change', function () {
            var selectedProductId = this.value;
            var editProductLink = document.getElementById('editProductLink');
            editProductLink.href = '<?= getenv('BASE_URL')?>/admin/product/edit/' + selectedProductId;
        });
    </script>
</form>

</body>

</html>