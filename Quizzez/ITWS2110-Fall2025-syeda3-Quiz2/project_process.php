<?php
session_start();
if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}

require_once 'db_connect.php';

$projectName = trim($_POST['projectName'] ?? '');
$projectDesc = $_POST['projectDesc'] ?? '';
$assignedUsers = $_POST['assignedUsers'] ?? [];

// Validate at least 3 users
if (count($assignedUsers) < 3) {
    $_SESSION['error'] = "You must assign at least 3 members.";
    header("Location: project.php");
    exit();
}

// Check for duplicate project name
$stmtCheck = $conn->prepare("SELECT projectId FROM projects WHERE name = ?");
$stmtCheck->bind_param("s", $projectName);
$stmtCheck->execute();
$stmtCheck->store_result();

if ($stmtCheck->num_rows > 0) {
    $_SESSION['error'] = "A project with this name already exists.";
    $stmtCheck->close();
    header("Location: project.php");
    exit();
}
$stmtCheck->close();

// Insert project
$stmt = $conn->prepare("INSERT INTO projects (name, description) VALUES (?, ?)");
$stmt->bind_param("ss", $projectName, $projectDesc);
$stmt->execute();
$projectId = $stmt->insert_id;
$stmt->close();

// Assign users
$stmt2 = $conn->prepare("INSERT INTO projectMembership (projectId, memberId) VALUES (?, ?)");
foreach ($assignedUsers as $userId) {
    $stmt2->bind_param("ii", $projectId, $userId);
    $stmt2->execute();
}
$stmt2->close();

// Store new project ID for highlighting
$_SESSION['newProjectId'] = $projectId;

header("Location: view_projects.php");
exit();
