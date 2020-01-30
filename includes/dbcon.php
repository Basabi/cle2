<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cle2";

$db = mysqli_connect($servername, $username, $password, $dbname)
or die("Error: " . mysqli_connect_error());
?>