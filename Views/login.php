<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if (isset($error_message)) : ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form action="checklogin" method="post">
            <input type="text" name="mail" placeholder="Indtast email" required><br><br>
            <input type="password" name="password" placeholder="Indtast kode"required><br><br>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
