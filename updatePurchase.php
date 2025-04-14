<?php session_start();
require_once "conn.php";

function updatePurchase($purchase_id, $animal) {

    global $config;

    $sql = "UPDATE (animal) FROM animals WHERE purchase_id=?";

    $stmt = $config->prepare($sql);
    $stmt->bind_param("si", $animal,  $purchase_id);

    if ($stmt->execute()) {
        return "Your purchase has successfully been updated";
    } else {
        die("Uh oh, we couldn't delete you because: " . $config->error);
    }

}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

    if (isset($_SESSION["username"])) {

        $purchaseID = $_PUT["purchase_id"];
        $animal = $_PUT["animal"];
    
        $message = updatePurchase($purchaseID, $animal);

    } else {
        $message = "Error, User is not logged in";
    }
} else {
    $message = "Error: server request method";
}

?>






<!DOCTYPE HTML>
    <head lan="en">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link rel="stylesheet" href="css/styles.css" />
    </head>

    <body>
        <form action="updatePurchase.php" method="PUT">
            
            <label for="new_email">What is the Purchase ID of the purchase you'd like to update</label>
            <input type="text" id="purchase_id" name="purchase_id" placeholder="00000000" required><br><br>

            <label for="new_email">New Animal:</label>
            <input type="text" id="animal" name="animal" placeholder="Animal" required><br><br>

            <input type="submit" value="Update">
        </form>
    </body>