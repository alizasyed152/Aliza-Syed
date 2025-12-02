<?php
session_start();
if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}

require_once 'db_connect.php';

// Fetch projects and members
$sql = "SELECT p.projectId, p.name, p.description, 
        GROUP_CONCAT(CONCAT(u.firstName, ' ', u.lastName) SEPARATOR ', ') AS members
        FROM projects p
        LEFT JOIN projectMembership pm ON p.projectId = pm.projectId
        LEFT JOIN users u ON pm.memberId = u.userId
        GROUP BY p.projectId";
$result = $conn->query($sql);

include 'header.php';
?>

<h2>Existing Projects</h2>
<table class="projects-table">
    <thead>
        <tr>
            <th>Project Name</th>
            <th>Description</th>
            <th>Members</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td><?= htmlspecialchars($row['members']) ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="3">No projects found.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="centered-button">
    <a href="project.php" class="btn">Add Project</a>
</div>

<?php include 'footer.php'; ?>
