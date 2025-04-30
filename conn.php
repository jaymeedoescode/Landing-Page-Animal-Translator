<?php
$host = "sql207.infinityfree.com";  // MySQL Hostname
$username = "if0_38478569";          // MySQL Username
$password = "omToGqVcty";            // MySQL Password
$dbname = "if0_38478569_Animals";    // MySQL Database Name

// Connect to the database
$config = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($config->connect_error) {
    die("Connection failed: " . $config->connect_error);
}

$config->set_charset("utf8");
?>
