<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page - Rediger Kategori</title>
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

    <!-- Rediger Kategori Formular -->
    <h2>Rediger Kategori</h2>
    <form method="post" action="<?= getenv('BASE_URL')?>/admin/categories/update" id="editCategoryForm">
        <!-- Inputfelt til fast kategoriID (kan skjules, hvis det ønskes) -->
        <input type="hidden" name="category_id_to_edit" id="category_id_to_edit" value="<?= $cat_id; ?>">

        <!-- Inputfelter for redigering -->
        <label for="category_name">Kategori Navn:</label>
        <input type="text" name="category_name" value="<?= isset($editcategory->kategori_navn) ? $editcategory->kategori_navn : ''; ?>" required>

        <!-- Opdater knap -->
        <button type="submit">Opdater</button>
    </form>
</body>

</html>