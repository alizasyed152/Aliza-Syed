<?php
session_start();
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nickName = $_POST['nickName'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE nickName = ?");
    $stmt->bind_param("s", $nickName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if ($password === $user['password_hash']) { // (Replace with hashing in real use)
            $_SESSION['userId'] = $user['userId'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="auth-page">


<div class="auth-container">
    <h2>Login</h2>

    <?php if (isset($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="nickName" placeholder="Nickname" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit" class="btn">Login</button>
    </form>

    <p class="register-link">
        Don't have an account?
        <a href="register.php">Register here</a>
    </p>
</div>



</body>
</html>
