<!DOCTYPE HTML>
    <head lan="en">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link rel="stylesheet" href="css/styles.css" />
    </head>

    <body>

        <form action="makePurchase.php" method="POST">
            <label for="animal">What animal would you like to buy:</label>
            <input type="text" id="animal" name="animal" required><br><br>

            <input type="submit" value="submit">
        </form>


        <?php session_start();
require_once "conn.php";

function makePurchase($username, $animal) {
    global $conn;

    $rowcount = "SELECT COUNT(*) FROM animals";
    $result = $conn->query($rowcount);
    $row = $result->fetch_assoc();

    $purchase_id = $row['COUNT(*)'] + 1;

    $currentTimestamp = date('Y-m-d H:i:s');

    $sql = "INSERT INTO `animals` (`purchase_id`, `username`, `animal`, `time_date`) VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $purchase_id, $username, $animal, $currentTimestamp);
    if ($stmt->execute()) {
        return "Congratulations! You can now talk to " . $animal . "s!     Your purchase ID is: " . $purchase_id . "Thank you for shopping with us today!";
    } else {
        die("Uh oh, we couldn't complete your purchase: " . $conn->error);
    }

}

function addUser($name, $email) {
    global $conn; // Use the database connection from config.php
    $sql = "INSERT INTO users (name, email) VALUES (?, ?)"; 
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $name, $email);
    return $stmt->execute(); // Return success (true/false)
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['username']) && isset($_POST['animal'])) {
        $username = $_SESSION['username'];
        $animal = $_POST['animal'];
       
        $message = makePurchase($username, $animal);
    } else {
        $message = "Error: User not logged in.";
    }
} else {
    $message = "Error: server request method";
}


?>

    </body>