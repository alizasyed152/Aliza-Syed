<?php
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logged Out</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'header.php'; ?>

<main>
    <h2>You have been logged out.</h2>
    <p class="centered-links">
        <a href="login.php" class="btn">Login</a>
        <a href="register.php" class="btn">Register</a>
    </p>
</main>

<?php include 'footer.php'; ?>

</body>
</html>
