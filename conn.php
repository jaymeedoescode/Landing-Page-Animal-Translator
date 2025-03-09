<!DOCTYPE HTML>
<HTML lang="en">

    <head>
        <title>First PHP and SQL practice</title>
    </head>

    <body>
        <p>This is the first page to practice building a dynamic php and sql integrated page</p>
        <?php
            $host = "127.0.0.1";
            $username = "root";
            $password = "";
            $dbname = "Softwares_bought_db";

            $conn = new mysqli($host, $username, $password, $dbname);

            if ($conn->connect_error) {
                die ("connection failed: " . $conn->connect_error);
            }
            
            echo "connected successfully";
            $conn->set_charset("utf8");


        ?>

    </body>
</HTML>