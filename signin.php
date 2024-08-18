<?php
session_start();


$servername = "localhost";
$username = "veethika";
$password = "veethika@123";
$dbname = "my_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = trim($_POST["email"]);
$password = $_POST["password"];
$salt = "veethikabhagwati";
$password_encrypted = sha1($password . $salt);

// Fetch user data based on the email
$stmt = $conn->prepare('SELECT id, name, password FROM signup WHERE email = ?');
$stmt->bind_param('s', $email);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($user_id, $user_name, $hashed_password);

if ($stmt->num_rows > 0) {
    $stmt->fetch();
    if (sha1($password . $salt) === $hashed_password) {
        // Store user information in session variables
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $user_name;

        // Redirect to home.php
        header("Location: home.php");
        exit();
    } else {
        ?>
        <script>
            alert('Login failed. Please check your credentials.');
            window.location = 'index.php';
        </script>
        <?php
    }
} else {
    ?>
    <script>
        alert('Login failed. Please check your credentials.');
        window.location = 'index.php';
    </script>
    <?php
}

$stmt->close();
$conn->close();
?>
