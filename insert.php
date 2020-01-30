<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cle2";

$db = mysqli_connect($servername, $username, $password, $dbname)
or die("Error: " . mysqli_connect_error());

$voornaam = mysqli_escape_string($db, $_POST['voornaam']);
$achternaam = mysqli_escape_string($db, $_POST['achternaam']);
$organisatie = mysqli_escape_string($db, $_POST['organisatie']);
$telefoonnummer = mysqli_escape_string($db, $_POST['telefoonnummer']);
$mail = mysqli_escape_string($db, $_POST['mail']);
$omschrijving = mysqli_escape_string($db, $_POST['omschrijving']);
$datevan = mysqli_escape_string($db, $_POST['datevan']);
$timevan = mysqli_escape_string($db, $_POST['timevan']);
$datetot = mysqli_escape_string($db, $_POST['datetot']);
$timetot = mysqli_escape_string($db, $_POST['timetot']);

if (!isset($_POST['band1'])) {
    $band1 = 0;
} else {
    $band1 = 1;
}

if (!isset($_POST['band2'])) {
    $band2 = 0;
} else {
    $band2 = 1;
}

if (!isset($_POST['band3'])) {
    $band3 = 0;
} else {
    $band3 = 1;
}

$query = "INSERT INTO `reserveringsysteem`(`voornaam`, `achternaam`, `organisatie`, `Telefoonnummer`, `mail`, `omschrijving`, `datumvan`, `tijdvan`, `datumtot`, `tijdtot`, `jeugd`, `marching`, `concert`)
VALUES ('$voornaam', '$achternaam', '$organisatie', '$telefoonnummer', '$mail', '$omschrijving', '$datevan', '$timevan', '$datetot', '$timetot', '$band1', '$band2', '$band3')";
$result = mysqli_query($db, $query)
or die('Error: '.$query);

if ($result) {
    echo "<a style=\"text-align:right;display:block;\" href=\"index.php\">Admin logout</a>";
    echo "<img src=\"logo.jpg\" alt=\"Logo\" height=\"100\" width=\"100\">";
    echo "<br>";
    echo "Optreden met succes aangevraagd!";
    echo "<br>";
    echo "<a href=\"index.php\">Terug naar de website</a>";
    exit;
} else {
    $errors[] = 'Something went wrong in your database query: ' . mysqli_error($db);
}

//Close connection
mysqli_close($db);