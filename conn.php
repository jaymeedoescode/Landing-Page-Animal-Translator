<!DOCTYPE HTML>
<HTML lang="en">

    <head>
        <title>First PHP and SQL practice</title>
    </head>

    <body>
        <?php
            $host = "127.0.0.1";
            $username = "root";
            $password = "";
            $dbname = "Softwares_bought_db";

            $conn = new mysqli($host, $username, $password, $dbname);

            if ($conn->connect_error) {
                die ("connection failed: " . $conn->connect_error);
            }
            
            
            $conn->set_charset("utf8");


        ?>

    </body>
</HTML>