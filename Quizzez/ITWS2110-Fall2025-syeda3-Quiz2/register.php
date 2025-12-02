<?php
session_start();
require 'db_connect.php';

// If already logged in, go home
if (isset($_SESSION['userId'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $nickName = $_POST['nickName'];
    $password = $_POST['password'];

    // check if nickname already exists
    $check = $conn->prepare("SELECT * FROM users WHERE nickName = ?");
    $check->bind_param("s", $nickName);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $error = "This nickname is already taken.";
    } else {
        // Insert new user
        $stmt = $conn->prepare(
            "INSERT INTO users (firstName, lastName, nickName, password_hash, salt)
             VALUES (?, ?, ?, ?, '')"
        );
        $stmt->bind_param("ssss", $firstName, $lastName, $nickName, $password);

        if ($stmt->execute()) {
            // Redirect to login
            header("Location: login.php?registered=1");
            exit();
        } else {
            $error = "Error creating account. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="auth-page">


<div class="auth-container">
    <h2>Create an Account</h2>

    <?php if (isset($error)): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <form method="post">

        <input type="text" name="firstName" placeholder="First Name" required>
        <input type="text" name="lastName" placeholder="Last Name" required>

        <input type="text" name="nickName" placeholder="Nickname" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit" class="btn">Register</button>
    </form>

    <p class="register-link">
        Already have an account?
        <a href="login.php">Log in here</a>
    </p>
</div>


</body>
</html>
