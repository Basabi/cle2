<?php
require_once "includes/session.php";
require_once "includes/dbcon.php";

$query = "SELECT * FROM reserveringsysteem ";

$result = mysqli_query($db, $query);

$optredenAanvragen = [];

while ($row = mysqli_fetch_assoc($result)) {
    $optredenAanvragen[] = $row;
}

mysqli_close($db);
?>
<!doctype html>
<html lang="en">
<head>
    <title>Optreden aanvragen</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="main.css">
    <style>
        table, th, td, tr{
            border: 1px solid black;
        }
    </style>
</head>
<body>
<div class="bg"></div>
<a style="text-align:right;display:block;" href="logout.php">Admin logout</a>
<center>
<img src="logo.jpg" alt="Logo" height="100" width="100">
<h1>Aanvragen</h1>
<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Voornaam</th>
        <th>Achternaam</th>
        <th>Organisatie</th>
        <th>Datum</th>
        <th>Details</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($optredenAanvragen as $optredenAanvraag) { ?>
        <tr>
            <td><?= htmlspecialchars($optredenAanvraag['ID']) ?></td>
            <td><?= htmlspecialchars($optredenAanvraag['voornaam']) ?></td>
            <td><?= htmlspecialchars($optredenAanvraag['achternaam']) ?></td>
            <td><?= htmlspecialchars($optredenAanvraag['organisatie']) ?></td>
            <td><?= htmlspecialchars($optredenAanvraag['datumvan']) ?></td>
            <td><a href="detail.php?ID=<?= htmlspecialchars($optredenAanvraag['ID']) ?>">Details</a></td>
            <td><a href="edit.php?id=<?= htmlspecialchars($optredenAanvraag['ID']) ?>">Edit</a></td>
            <td><a href="delete.php?id=<?= htmlspecialchars($optredenAanvraag['ID']) ?>">Delete</a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</center>
</body>
</html>