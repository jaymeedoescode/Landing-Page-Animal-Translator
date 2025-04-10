<?php session_start();
require_once "conn.php";

function getPurchase() {
    
    global $conn;

    $username = $_SESSION["username"];

    $sql = "SELECT * FROM `animals` WHERE username=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);

    $stmt->execute();
    $result = $stmt->get_result();

    return $result;
    
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = getPurchase();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Purchase ID: " . $row["purchase_id"] . "<br>";
            echo "Animal: " . $row["animal"] . "<br>";
            echo "Time/Date: " . $row["time_date"] . "<br><br>";
        }
    }
}
?>



<!DOCTYPE HTML>
    <head lang="en">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link rel="stylesheet" href="css/styles.css" />
    </head>

    <body>
    <form action="getPurchase.php" method="POST">
            <button type="submit" id="submit" value="submit">See my purchases</button>
    </form>

    </body>