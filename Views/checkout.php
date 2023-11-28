<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout - NPG</title>
    <!-- Include your CSS styles and other external resources -->
    <style>
        /* Your CSS styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th:nth-child(2), td:nth-child(2) {
            text-align: right;
        }

        /* Add more styles as needed */
    </style>
</head>
<body>
    <header>
        <h1>Checkout</h1>
    </header>
    <div class="container">
        <div class="checkout-details">
            <h2>Ordre oversigt</h2>
            <table>
                <thead>
                    <tr>
                        <th>Produkt</th>
                        <th>Pris</th>
                        <th>Antal</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Loop through the cart items from the session -->
                    <?php
                    // Fetch cart items from the session if available
                    $cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
                    $totalAmount = 0;

                    foreach ($cartItems as $item):
                        $totalItemPrice = $item->pris; // Calculate individual item total
                        $totalAmount += $totalItemPrice; // Accumulate total amount
                    ?>
                        <tr>
                            <td><?= $item->produkt_navn; ?></td>
                            <td><?= $item->pris; ?> Kr.</td>
                            <td>1</td>
                            <td><?= $totalItemPrice; ?> Kr.</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <h3>Total Amount: <?= $totalAmount; ?> Kr.</h3>
        </div>
        <div>
        <h2>Shipping Details</h2>
            <!-- Add your checkout form fields here -->
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) { ?>
            <form action="<?= getenv('BASE_URL')?>/process_checkout" method="post">
                <p> Vi kan se at du er logget ind, så vi bruger din data fra din profil. </p>
                <button type="submit">Gennemfør betaling</button>
            </form>
            <?php } else { ?>
                <form action="<?= getenv('BASE_URL')?>/process_checkout" method="post">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required><br><br>
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required><br><br>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br><br>
                <button type="submit">Gennemfør betaling</button>
            </form>
            <?php } ?>
        </div>
    </div>
</body>
</html>
