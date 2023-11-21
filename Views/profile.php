<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile - Webshop</title>
    <!-- Your CSS and other external resources -->
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

        .user-info {
            margin-bottom: 20px;
        }

        .order-history {
            border-top: 1px solid #ccc;
            padding-top: 20px;
        }

        /* Add more styles as needed */
    </style>
</head>
<body>
    <header>
        <h1>User Profile</h1>
    </header>

    <div class="container">
        <div class="user-info">
            <h2>User Information</h2>
            <p><strong>Name:</strong> <?= $profile->fornavn." ". $profile->efternavn; ?></p>
            <p><strong>Email:</strong> johndoe@example.com</p>
            <!-- Add more user-related information here -->
        </div>

        <div class="order-history">
            <h2>Order History</h2>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>2023-11-01</td>
                        <td>$120.00</td>
                    </tr>
                    <!-- Add more rows for order history -->
                </tbody>
            </table>
        </div>

        <!-- Add more sections for account settings, etc. -->

    </div>
</body>
</html>