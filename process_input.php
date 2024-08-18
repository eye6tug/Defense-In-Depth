<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Process the submitted information
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = htmlspecialchars(trim($_POST['info']));

    // You can now store this info in the database, use it for further processing, etc.
    // For now, let's just display it.
    echo "You submitted: " . $info;
}
?>
