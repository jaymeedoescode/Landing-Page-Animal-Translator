<?php
session_start();
$error = "";
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $conn = new mysqli('sql207.infinityfree.com', 'if0_38478569', 'omToGqVcty', 'if0_38478569_Animals');
    if ($conn->connect_error) {
        $error = "Database connection failed. Please try again later.";
    } else {
        $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid username or password.";
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: "Segoe UI", sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
        }

        .logo-wrapper {
            margin-top: 40px;
        }

        .logo-wrapper img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background-color: #ffffff;
            padding: 10px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.05);
        }

        .form-container {
            background: #fff;
            padding: 30px 40px;
            margin-top: 20px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 90%;
            max-width: 400px;
        }

        h1 {
            margin-bottom: 20px;
        }

        label {
            display: block;
            text-align: left;
            margin-top: 15px;
            color: #187795;
            font-weight: 600;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            margin-top: 20px;
            padding: 12px 25px;
            background-color: #187795;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #145f75;
        }

        .register-link {
            margin-top: 15px;
        }
    </style>
</head>
<body>

<div class="logo-wrapper">
    <img src="pictures/jake.png" alt="Logo">
</div>

<div class="form-container">
    <h1>Login</h1>
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form action="login.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Login</button>
    </form>

    <p class="register-link">Don't have an account? <a href="register.php">Register here</a>.</p>
</div>

</body>
</html>
