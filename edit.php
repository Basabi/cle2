<?php
require_once "includes/session.php";
require_once "includes/dbcon.php";

//Check if Post isset, else do nothing
if (isset($_POST['submit'])) {
    $id = mysqli_escape_string($db, $_POST['id']);
    //Update the record in the database
    $stmt = $db->prepare("UPDATE reserveringsysteem
            SET voornaam = ?, achternaam = ?, organisatie = ?, telefoonnummer = ?, mail = ?, omschrijving = ?, datumvan = ?, tijdvan = ?, datumtot = ?, tijdtot = ?
            WHERE ID = ?");
    $stmt->bind_param("sssissssssi", $voornaam, $achternaam, $organisatie, $telefoonnummer, $mail, $omschrijving, $datevan, $timevan, $datetot, $timetot, $id);

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

//Check if data is valid & generate error if not so
    $errors = [];
    if ($voornaam == "") {
        $errors['voornaam'] = 'Voornaam mag niet leeg zijn';
    }
    if ($achternaam == "") {
        $errors['achternaam'] = 'Achternaam mag niet leeg zijn';
    }
    if (!is_numeric($telefoonnummer)) {
        $errors['telefoonnummer'] = 'telefoonnummer  mag niet leeg zijn';
    }
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $errors['mail'] = 'Voer een e-mail in';
    }
    if ($omschrijving == "") {
        $errors['omschrijving'] = 'Omschrijving  mag niet leeg zijn';
    }
    if ($datevan == "") {
        $errors['datevan'] = 'Vanaf datum is verkeerd!';
    }
    if ($datetot == "") {
        $errors['datetot'] = 'Tot datum is verkeerd!';
    }
    if ($timevan == "") {
        $errors['timevan'] = 'Vanaf tijd is verkeerd!';
    }
    if ($timetot == "") {
        $errors['timetot'] = 'Tot tijd is verkeerd!';
    }

    if (empty($errors))
    {
        $stmt->execute();
        Header("location: tabel.php");
        Exit();
    }
}
else if(isset($_GET['id'])) {
    //Retrieve the GET parameter from the 'Super global'
    $reserveringId = $_GET['id'];

    //Get the record from the database result
    $query = "SELECT * FROM reserveringsysteem WHERE ID = " . mysqli_escape_string($db, $_GET['id']);
    $result = mysqli_query($db, $query) or die ('Error: ' . $query );
    if(mysqli_num_rows($result) == 1)
    {
        $reservering = mysqli_fetch_assoc($result);
    }
    else {
        // redirect when db returns no result
        header('Location: tabel.php');
        exit;
    }
} else {
    header('Location: tabel.php');
    exit;
}

//Close connection
mysqli_close($db);
?>
<!doctype html>
<html lang="en">
<head>
    <title>Reservering Edit</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
<a style="text-align:right;display:block;" href="logout.php">Admin logout</a>
<center>
    <img src="logo.jpg" alt="Logo" height="100" width="100">
<h1>Bewerk "<?= htmlspecialchars($reservering['voornaam']) . ' ' . htmlspecialchars($reservering['achternaam']) ?>"</h1>

<form action="" method="post" enctype="multipart/form-data">
    <div class="data-field">
        <label for="voornaam">Voornaam</label>
        <input id="voornaam" type="text" name="voornaam" value="<?= htmlspecialchars($reservering['voornaam']) ?>"/>
<!--        <span class="errors">--><?//= isset($errors['voornaam']) ? $errors['voornaam'] : '' ?><!--</span>-->
        <label for="achternaam">Achternaam</label>
        <input id="achternaam" type="text" name="achternaam" value="<?= htmlspecialchars($reservering['achternaam']) ?>"/>
<!--        <span class="errors">--><?//= isset($errors['achternaam']) ? $errors['achternaam'] : '' ?><!--</span>-->
    </div>
    <br>
    <div class="data-field">
        <label for="organisatie">organisatie</label>
        <input id="organisatie" type="text" name="organisatie" value="<?= htmlspecialchars($reservering['organisatie']) ?>"/>
<!--        <span class="errors">--><?//= isset($errors['organisatie']) ? $errors['organisatie'] : '' ?><!--</span>-->
    </div>
    <br>
    <div class="data-field">
        <label for="telefoonnummer">telefoonnummer</label>
        <input id="telefoonnummer" type="number" name="telefoonnummer" value="<?= htmlspecialchars($reservering['telefoonnummer']) ?>"/>
<!--        <span class="errors">--><?//= isset($errors['telefoonnummer']) ? $errors['telefoonnummer'] : '' ?><!--</span>-->
    </div>
    <br>
    <div class="data-field">
        <label for="mail">mail</label>
        <input id="mail" type="email" name="mail" value="<?= htmlspecialchars($reservering['mail']) ?>"/>
<!--        <span class="errors">--><?//= isset($errors['mail']) ? $errors['mail'] : '' ?><!--</span>-->
    </div>
    <br>
    <div class="data-field">
        <label for="omschrijving">omschrijving</label>
        <input id="omschrijving" type="text" name="omschrijving" value="<?= htmlspecialchars($reservering['omschrijving']) ?>"/>
<!--        <span class="errors">--><?//= isset($errors['omschrijving']) ? $errors['omschrijving'] : '' ?><!--</span>-->
    </div>
    <br>
    <div class="data-field">
        <label for="datevan">datum vanaf</label>
        <input id="datevan" type="date" name="datevan" value="<?= htmlspecialchars($reservering['datumvan']) ?>"/>
<!--        <span class="errors">--><?//= isset($errors['datevan']) ? $errors['datevan'] : '' ?><!--</span>-->
        <label for="timevan">tijd vanaf</label>
        <input id="timevan" type="time" name="timevan" value="<?= htmlspecialchars($reservering['tijdvan']) ?>"/>
<!--        <span class="errors">--><?//= isset($errors['timevan']) ? $errors['timevan'] : '' ?><!--</span>-->
    </div>
    <br>
    <div class="data-field">
        <label for="datetot">datum tot</label>
        <input id="datetot" type="date" name="datetot" value="<?= htmlspecialchars($reservering['datumtot']) ?>"/>
<!--        <span class="errors">--><?//= isset($errors['datetot']) ? $errors['datetot'] : '' ?><!--</span>-->
        <label for="timetot">tijd tot</label>
        <input id="timetot" type="time" name="timetot" value="<?= htmlspecialchars($reservering['tijdtot']) ?>"/>
<!--        <span class="errors">--><?//= isset($errors['timetot']) ? $errors['timetot'] : '' ?><!--</span>-->
    </div>
    <br>
    <div class="data-submit">
        <input type="hidden" name="id" value="<?= htmlspecialchars($reserveringId) ?>"/>
        <input type="submit" name="submit" value="submit"/>
    </div>
</form>
<br>
<div>
    <a href="tabel.php">Terug naar de aanvragen</a>
</div>
</center>
</body>
</html>
