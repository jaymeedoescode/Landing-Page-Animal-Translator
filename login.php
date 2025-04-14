<?php
// Start a PHP session (needed for user authentication)
session_start();

// Initialize the error variable
$error = "";

// Redirect to the main page if the user is already logged in
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Connect to the database
    $config = new mysqli('sql207.infinityfree.com', 'if0_38478569', 'omToGqVcty', 'if0_38478569_Animals');
    if ($config->connect_error) {
        $error = "Database connection failed. Please try again later.";
    } else {
        // Check if the username exists
        $stmt = $config->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        // Verify the password
        if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
            // Start a session and store the username
            $_SESSION['username'] = $username;

            // Redirect to the main page
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid username or password.";
        }

        // Close the database connection
        $stmt->close();
        $config->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <!-- Link to the CSS file -->
    <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
    <h1>Login</h1>
    <!-- Display error messages here (if any) -->
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <!-- Login Form -->
    <form action="login.php" method="POST" onsubmit="return validateLoginForm()">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="register.php">Register here</a>.</p>

    <!-- Link to the JavaScript file -->
    <script src="js/scripts.js"></script>
</body>
</html>