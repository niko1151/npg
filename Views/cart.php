<?php
// Assuming this is the logic to fetch cart items from the session

// Fetch cart items from the session if available
$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// This function formats the price display by appending 'Kr.'
function formatPrice($price) {
    return number_format($price, 2) . ' Kr.';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart - YourWebShop</title>
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
            padding: 8px;
            text-align: left;
        }

        th:last-child, td:last-child {
            text-align: right;
        }

        .quantity {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 100px;
        }

        /* Add more styles as needed */
    </style>
</head>
<body>
    <header>
        <h1>Cart</h1>
    </header>
    <div class="container">
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
                <?php foreach ($cartItems as $item): ?>
                    <tr>
                        <td><?= $item['product_name']; ?></td>
                        <td><?= formatPrice($item['price']); ?></td>
                        <td>
                            <div class="quantity">
                                <button onclick="decreaseQuantity(this)">-</button>
                                <span><?= $item['quantity']; ?></span>
                                <button onclick="increaseQuantity(this)">+</button>
                            </div>
                        </td>
                        <td><?= formatPrice($item['price'] * $item['quantity']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <hr>

        <div>
            <h3 id="totalAmount">Total: 
                <?php
                $totalAmount = 0;
                foreach ($cartItems as $item) {
                    $totalAmount += $item['price'] * $item['quantity'];
                }
                echo formatPrice($totalAmount);
                ?>
            </h3>
        </div>

        <div>
            <a href="checkout.php" class="btn btn-primary">Gå til kassen</a>
            <a href="shop.php" class="btn btn-secondary">Forsæt Shopping</a>
        </div>
    </div>

    <script>
        function increaseQuantity(button) {
            var span = button.parentElement.querySelector('span');
            var quantity = parseInt(span.textContent);
            quantity++;
            span.textContent = quantity;
            updateTotal();
        }

        function decreaseQuantity(button) {
            var span = button.parentElement.querySelector('span');
            var quantity = parseInt(span.textContent);
            if (quantity > 1) {
                quantity--;
                span.textContent = quantity;
                updateTotal();
            }
        }

        function updateTotal() {
            var rows = document.querySelectorAll('tbody tr');
            var total = 0;

            rows.forEach(function(row) {
                var priceText = row.querySelector('td:nth-child(2)').textContent;
                var numericPrice = parseFloat(priceText); // Parse the price string directly

                var quantity = parseInt(row.querySelector('span').textContent);
                var rowTotal = numericPrice * quantity;
                row.querySelector('td:last-child').textContent = rowTotal.toFixed(2) + ' Kr.';
                total += rowTotal;
            });

            document.querySelector('#totalAmount').textContent = 'Total: ' + total.toFixed(2) + ' Kr.';
        }

        window.onload = updateTotal;
    </script>
</body>
</html>
