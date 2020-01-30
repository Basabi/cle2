<?php
require_once "includes/session.php";
require_once "includes/dbcon.php";

$ID = $_GET['ID'];

//Get the record from the database result
$query = "SELECT * FROM reserveringsysteem WHERE id = " . $ID;
$result = mysqli_query($db, $query);
$optreden = mysqli_fetch_assoc($result);

//Close connection
mysqli_close($db);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Details - <?= $optreden['organisatie'] ?></title>
    <link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
<a style="text-align:right;display:block;" href="logout.php">Admin logout</a>
<center>
    <img src="logo.jpg" alt="Logo" height="100" width="100">
<table>
    <ul>
        <tr>Naam: <?= htmlspecialchars($optreden['voornaam']) ?>  <?= htmlspecialchars($optreden['achternaam']) ?></tr>
        <br>
        <tr>Organisatie: <?= htmlspecialchars($optreden['organisatie']) ?></tr>
        <br>
        <tr>Telefoonnummer: <?= htmlspecialchars($optreden['telefoonnummer']) ?></tr>
        <br>
        <tr>E-mail: <?= htmlspecialchars($optreden['mail']) ?></tr>
        <br>
        <tr>Omschrijving: <?= htmlspecialchars($optreden['omschrijving']) ?></tr>
        <br>
        <tr>Start: <?= htmlspecialchars($optreden['datumvan']) ?> Tijd: <?= htmlspecialchars($optreden['tijdvan']) ?></tr>
        <br>
        <tr>Einde: <?= htmlspecialchars($optreden['datumtot']) ?> Tijd:<?= htmlspecialchars($optreden['tijdtot']) ?></tr>
        <br>
        <tr>Orkesten:
            <?php
            if(htmlspecialchars($optreden['jeugd']) == 1)
            {
                echo "Jeugdorkest";
            }?>
            <?php
            if(htmlspecialchars($optreden['marching']) == 1)
            {
                echo "Marching Band";
            }?>
            <?php
            if(htmlspecialchars($optreden['concert']) == 1)
            {
                echo "Concert Band";
            }?>
        </tr>
    </ul>
</table>
<div>
    <a href="tabel.php">Terug naar de aanvragen</a>
</div>
</center>
</body>
</html>