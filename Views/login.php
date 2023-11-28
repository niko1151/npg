<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>

    <!-- CSS-styling for opret-login-knappen -->
    <style>
        .create-login-btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
        }

        .create-login-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <!-- Container til login-formularen -->
    <div class="container">
        <h2>Login</h2>

        <!-- Vis fejlmeddelelse, hvis en fejl opstår under login-processen -->
        <?php if (isset($error_message)) : ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <!-- Login-formular -->
        <form action="checklogin" method="post">
            <input type="text" name="mail" placeholder="Indtast email" required><br><br>
            <input type="password" name="password" placeholder="Indtast kode" required><br><br>
            <button class="create-login-btn" type="submit">Login</button>
        </form>

        <br>

        <!-- Link til oprettelse af login -->
        <a class="create-login-btn"  href="<?= getenv('BASE_URL')?>/opret_login">Opret Login</a>
    </div>
</body>
</html>