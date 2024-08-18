<?php
session_start();

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['user_name'])) {
    header("Location: index.php");
    exit();
}

$user_name = htmlspecialchars($_SESSION['user_name']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style.css"> <!-- Assuming you have a style.css for basic styling -->
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo $user_name; ?>!</h1>
        <p>This is your home page. Feel free to explore!</p>

        <h2>Submit Your Information</h2>
        <form method="POST" action="process_input.php">
            <label for="info">Enter some information:</label>
            <input type="text" id="info" name="info" placeholder="Your info here" required>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
