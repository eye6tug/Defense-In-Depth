<?php
// dashboard.php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <!-- Add necessary styles and scripts -->
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['email']); ?>!</h1>
    <p>This is your dashboard.</p>
    <a href="logout.php">Logout</a>
</body>
</html>
