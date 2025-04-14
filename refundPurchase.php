<?php session_start();
    require_once "conn.php";

    function refundPurchase($purchase_id) {
        global $config;

        $sql = "DELETE FROM `animals` WHERE purchase_id=?";

        $stmt = $config->prepare($sql);
        $stmt->bind_param("i", $purchase_id);

        if ($stmt->execute()) {
            return "your purchase successfully refunded";
        } else {
            die("uh oh, we couldn't delete you bc: " . $config->error); }
    }


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["purchase_id"])) {
            $id = $_POST["purchase_id"];
            refundPurchase($id);
        } else {
            echo "You need to enter a Purchase ID";
        }

    }
?>





<!DOCTYPE HTML>
    <head lan="en">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link rel="stylesheet" href="css/styles.css" />
    </head>

    <body>
    <form action="refundPurchase.php" method="POST">
            <label for="animal">What is the ID number of the purchase you'd like to refund:</label>
            <input type="text" id="purchase_id" name="purchase_id" required><br><br>

            <input type="submit" value="submit">
        </form>


    </body>