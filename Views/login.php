<?php
// Start a session (if not already started)
// session_start();

// function isUserLoggedIn() {
//     return isset($_SESSION['username']);
// }

// Function to generate the login/logout button
// function loginLogoutButton() {
//     if (isUserLoggedIn()) {
//         // If the user is logged in, show a logout button
//         echo '<form action="/logout" method="post">
//                 <button type="submit">Logout</button>
//               </form>';
//     } else {
//         // If the user is not logged in, show a login link
//         echo '<a href="/login">Login</a>';
//     }
// }

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check the username and password (replace with your authentication logic)
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Replace this with your actual authentication logic (e.g., database query)
    if ($username === 'test' && $password === 'test1') {
        // Authentication successful; store the username in the session
        $_SESSION['username'] = $username;

        // Redirect to the home page or dashboard
        header('Location: /npg');
        exit;
    } else {
        $error_message = 'Invalid username or password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="styles.css"> <!-- You can style your login page using CSS -->
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if (isset($error_message)) : ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form action="/npg" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
