<?php
require_once "includes/session.php";
require_once "includes/dbcon.php";

if (isset($_POST['submit'])) {
    $query = "DELETE FROM reserveringsysteem WHERE ID = " . mysqli_escape_string($db, $_POST['id']);

    mysqli_query($db, $query)
    or die ('Error: '.mysqli_error($db));

    //Close connection
    mysqli_close($db);

    //Redirect to homepage after deletion & exit script
    header("Location: tabel.php");
    exit;

} else if(isset($_GET['id'])) {
    $reserveringsysteemId = $_GET['id'];

    $query = "SELECT * FROM reserveringsysteem WHERE ID = " . mysqli_escape_string($db, $reserveringsysteemId);
    $result = mysqli_query($db, $query) or die ('Error: ' . $query );

    if(mysqli_num_rows($result) == 1)
    {
        $reserveringsysteem = mysqli_fetch_assoc($result);
    }
    else {
        header('Location: tabel.php');
    exit;
    }

} else {
    header('Location: tabel.php');
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verwijder reservering van <?= htmlspecialchars($reserveringsysteem['voornaam']) . " " .  htmlspecialchars($reserveringsysteem['achternaam']) ?></title>
    <link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
<a style="text-align:right;display:block;" href="logout.php">Admin logout</a>
<center>
<img src="logo.jpg" alt="Logo" height="100" width="100">
<h2>Verwijder de reservering van <?= htmlspecialchars($reserveringsysteem['voornaam']) . " " . htmlspecialchars($reserveringsysteem['achternaam']) ?></h2>
<form action="" method="post">
    <p>
        Weet u zeker dat u de reservering van  "<?= htmlspecialchars($reserveringsysteem['voornaam']) . " " . htmlspecialchars($reserveringsysteem['achternaam']) ?> op de datum van <?= htmlspecialchars($reserveringsysteem['datumvan'])?>" wilt verwijderen?
    </p>
    <input type="hidden" name="id" value="<?= htmlspecialchars($reserveringsysteem['ID']) ?>"/>
    <input type="submit" name="submit" value="Verwijderen"/>
    <br>
    <br>
    <a href="tabel.php">Terug naar de aanvragen</a>
</form>
</center>
</body>
</html>