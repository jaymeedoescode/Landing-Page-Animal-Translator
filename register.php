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
    $confirm_password = $_POST['confirm_password'];

    // Validate passwords match
    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Connect to the database
        $conn = new mysqli('sql207.infinityfree.com', 'if0_38478569', 'omToGqVcty', 'if0_38478569_Animals');
        if ($conn->connect_error) {
            $error = "Database connection failed. Please try again later.";
        } else {
            // Check if the username already exists
            $stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $error = "Username already exists.";
            } else {
                // Hash the password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Insert the new user into the database
                $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
                $stmt->bind_param("ss", $username, $hashed_password);

                if ($stmt->execute()) {
                    // Redirect to the login page after successful registration
                    header("Location: login.php");
                    exit();
                } else {
                    $error = "Registration failed. Please try again.";
                }
            }

            // Close the database connection
            $stmt->close();
            $conn->close();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <!-- Link to the CSS file -->
    <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
    <h1>Register</h1>
    <!-- Display error messages here (if any) -->
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <!-- Registration Form -->
    <form action="register.php" method="POST" onsubmit="return validateForm()">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required minlength="10"><br>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br>

        <input type="submit">Register</input>
    </form>

    <p>Already have an account? <a href="login.php">Login here</a>.</p>

    <!-- Link to the JavaScript file -->
    <script src="js/scripts.js"></script>
</body>
</html>