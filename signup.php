<?php
session_start(); // Start a session

$servername = "localhost";
$username = "veethika";
$password = "veethika@123";
$dbname = "my_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request method.");
}

// Check referer to ensure form submission is from your own site
//if (!isset($_SERVER['HTTP_REFERER']) || parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) !== '192.168.78.103') {
//    die("Unauthorized access.");
//}

// Get and sanitize user inputs
$name = trim($_POST["name"]);
$email = trim($_POST["email"]);
$password = $_POST["password"];

// Validate inputs
$errors = [];

if (empty($name)) {
    $errors[] = "Name is required.";
}

if (empty($email)) {
    $errors[] = "Email is required.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format.";
}

if (empty($password)) {
    $errors[] = "Password is required.";
}

if (!empty($errors)) {
    // Display errors and stop execution
    ?>
    <script>
        alert('<?php echo implode(" ", $errors); ?>');
        window.location = 'index.php';
    </script>
    <?php
    exit;
}

// Secure password encryption
$salt = "veethikabhagwati";
$password_encrypted = sha1($password . $salt);

// Check if email already exists
$stmt = $conn->prepare('SELECT id FROM signup WHERE email = ?');
$stmt->bind_param('s', $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    ?>
    <script>
        alert('Email is already registered.');
        window.location = 'index.php';
    </script>
    <?php
} else {
    $stmt = $conn->prepare('INSERT INTO signup (name, email, password) VALUES (?, ?, ?)');
    $stmt->bind_param('sss', $name, $email, $password_encrypted);
    if ($stmt->execute()) {
        ?>
        <script>
            alert('Account created successfully.');
            window.location = 'index.php';
        </script>
        <?php
    } else {
        ?>
        <script>
            alert('Error occurred. Please try again.');
            window.location = 'index.php';
        </script>
        <?php
    }
}

$stmt->close();
$conn->close();
?>
