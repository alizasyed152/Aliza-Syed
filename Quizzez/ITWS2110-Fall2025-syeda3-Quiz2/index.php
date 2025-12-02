<?php
session_start();
if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'header.php'; ?>

<main>
    <h2>Welcome!</h2>

    <div class="home-buttons">
        <a href="view_projects.php" class="btn">View Existing Projects</a>
        <a href="project.php" class="btn">Add a Project</a>
    </div>

    <div class="quick-tip">
        <p><strong>Quick Tip:</strong> You can view existing projects or add a new project using the buttons below!</p>
    </div>
</main>

<?php include 'footer.php'; ?>

</body>
</html>
