<?php
session_start();
if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}

require_once 'db_connect.php';

// Fetch users for checkboxes
$sql = "SELECT userId, firstName, lastName FROM users ORDER BY firstName";
$result = $conn->query($sql);
$users = $result->fetch_all(MYSQLI_ASSOC);
?>

<?php include 'header.php'; ?>

<h2>Add a New Project</h2>

<?php if (isset($_SESSION['error'])): ?>
    <p class="error"><?= htmlspecialchars($_SESSION['error']) ?></p>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>


<form action="project_process.php" method="post" class="project-form">

    <label for="projectName">Project Name:</label>
    <input type="text" name="projectName" id="projectName" required>

    <label for="projectDesc">Project Description:</label>
    <textarea name="projectDesc" id="projectDesc"></textarea>

    <label>Assign At Least 3 Members:</label>
    <div class="checkbox-group">
        <?php foreach ($users as $u): ?>
            <label class="checkbox-item">
                <input type="checkbox" name="assignedUsers[]" value="<?= $u['userId'] ?>">
                <?= htmlspecialchars($u['firstName'] . " " . $u['lastName']) ?>
            </label>
        <?php endforeach; ?>
    </div>

    <button type="submit" class="btn">Add Project</button>
</form>

<?php include 'footer.php'; ?>
