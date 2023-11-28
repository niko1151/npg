<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <title>Brugerprofil - Webshop</title>
    <style>
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

    </style>
</head>
<body>
    <header>
        <h1>Brugerprofil</h1>
    </header>

    <div class="container">
        <!-- Sektion til brugerinformation -->
        <div class="user-info">
            <h2>Brugerinformation</h2>
            <!-- Visning af brugeroplysninger -->
            <p><strong>Navn:</strong> <?= $profile->fornavn." ". $profile->efternavn; ?></p>
            <p><strong>Email:</strong> <?= $profile->email; ?></p>
            <p><strong>Telefon Nr.:</strong> <?= $profile->telefonnummer; ?></p>
            <p><strong>Adresse:</strong> <?= $profile->adresse; ?></p>
            <p><strong>By & Postnummer:</strong> <?= $profile->by_navn." ".$profile->postnummer; ?></p>
        </div>

        <!-- Sektion til ordrehistorik -->
        <div class="order-history">
            <h2>Ordrehistorik</h2>
            <table>
                <thead>
                    <tr>
                        <th>Ordre ID</th>
                        <th>Dato</th>
                        <th>Totalbeløb</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Eksempel for ordrehistorik -->
                    <tr>
                        <td>1</td>
                        <td>2023-11-01</td>
                        <td>$120.00</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</body>
</html>