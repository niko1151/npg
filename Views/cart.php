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
    <title>Cart - NPG</title>
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
                    <th>Fjern</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $item): ?>
                    <tr data-product-id="<?= $item->produkt_id; ?>">
                        <td><?= $item->produkt_navn; ?></td>
                        <td><?= formatPrice($item->pris); ?></td>
                        <td>
                            <div class="quantity">
                                <button onclick="decreaseQuantity(this)">-</button>
                                <span>1</span>
                                <button onclick="increaseQuantity(this)">+</button>
                            </div>
                        </td>
                        <td><?= formatPrice($item->pris); ?></td>
                        <td><button onclick="removeItem(this)">Remove</button></td>
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
                    $totalAmount += $item->pris; // Add the price to the total amount
                }
                echo formatPrice($totalAmount);
                ?>
            </h3>
        </div>

        <div>
            <a href="<?= getenv('BASE_URL')?>/checkout" class="btn btn-primary">Gå til kassen</a>
            <a href="<?= getenv('BASE_URL')?>/product" class="btn btn-secondary">Forsæt Shopping</a>
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

    function removeItem(button) {
    var row = button.closest('tr');
    var productId = row.getAttribute('data-product-id'); // Get the product ID from the row

    // Send an AJAX request to your server to remove the item from the session
    fetch('<?= getenv('BASE_URL')?>/removeFromCart', {
        method: 'POST',
        body: JSON.stringify({ productId: productId }),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            row.remove();
            updateTotal();
        } else {
            console.log('Failed to remove the item');
        }
    })
    .catch(error => console.error('Error:', error));
    }

    function updateTotal() {
        var rows = document.querySelectorAll('tbody tr');
        var total = 0;

        rows.forEach(function(row) {
            var priceText = row.querySelector('td:nth-child(2)').textContent;
            var numericPrice = parseFloat(priceText.replace(' Kr.', '').replace(',', '.')); // Parse the price string directly

            var span = row.querySelector('span');
            var quantity = parseInt(span.textContent);

            var rowTotal = numericPrice * quantity;
            row.querySelector('td:nth-child(4)').textContent = formatPrice(rowTotal);
            total += rowTotal;
        });

        document.querySelector('#totalAmount').textContent = 'Total: ' + formatPrice(total);
    }

    function formatPrice(price) {
        return parseFloat(price).toFixed(2) + ' Kr.';
    }

    window.onload = updateTotal;
</script>
</body>
</html>
