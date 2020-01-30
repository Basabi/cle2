<?php
$apiKey = "7d937864b063ac3cedce4eb0efefcad0";
$cityId = "2747890";
$googleApiUrl = "http://api.openweathermap.org/data/2.5/weather?id=" . $cityId . "&lang=en&units=metric&APPID=" . $apiKey;

$ch = curl_init();

curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_VERBOSE, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);

curl_close($ch);
$data = json_decode($response);
$currentTime = time();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cle2";

$db = mysqli_connect($servername, $username, $password, $dbname)
or die("Error: " . mysqli_connect_error());

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $stmt = $db->prepare("INSERT INTO `reserveringsysteem`(`voornaam`, `achternaam`, `organisatie`, `Telefoonnummer`, `mail`, `omschrijving`, `datumvan`, `tijdvan`, `datumtot`, `tijdtot`, `jeugd`, `marching`, `concert`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssissssssiii", $voornaam, $achternaam, $organisatie, $telefoonnummer, $mail, $omschrijving, $datevan, $timevan, $datetot, $timetot, $band1, $band2, $band3);

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
    if (empty($errors)) {
        $stmt->execute();
        echo "<a style=\"text-align:right;display:block;\" href=\"login.php.php\">Admin login</a>";
        echo "<img src=\"logo.jpg\" alt=\"Logo\" height=\"100\" width=\"100\">";
        echo "<br>";
        echo "Optreden met succes aangevraagd!";
        echo "<br>";
        echo "<a href=\"https://www.rotterdamaanzee.nl\">Terug naar de website</a>";
        exit;
    } else {
        $errors[] = 'Something went wrong in your database query: ' . mysqli_error($db);
    }
}

//Close connection
mysqli_close($db);

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Reserveringsysteem</title>
        <link rel="stylesheet" type="text/css" href="main.css">
        <style>
            .report-container{
                border: #E0E0E0 1px solid;
                padding: 20px 20px 40px 40px;
                border-radius: 2px;
                width: 550px;
                margin: 0 auto;
            }

            .weather-icon {
                vertical-align: middle;
                marging-right: 20px;
            }

            .weather-forecast{
                color: #212121;
                font-size: 1.2em;
                font-weight: bold;
                margin: 20px 0px;
            }

            span.min-temperature{
                margin-left: 15px;
                color: #929292;
            }

            .time{
                line-height: 25px;
            }
        </style>
    </head>

    <body>
    <a style="text-align:right;display:block;" href="login.php">Admin login</a>
    <div style="float:left">
        <img src="logo.jpg" alt="Logo" height="100" width="100">
        <h2 style="color: RGB(0, 138, 210)"> Boek een optreden </h2>
        <p>U kunt hier, geheel vrijblijvend, een aanvraag doen voor een optreden door onze vereniging. <br> Wij nemen contact met u op en bespreken dan de mogelijkheden.</p>
        <span class="errors"><?= isset($errors['voornaam']) ? $errors['voornaam'] : '' ?></span>
        <span class="errors"><?= isset($errors['achternaam']) ? $errors['achternaam'] : '' ?></span>
        <span class="errors"><?= isset($errors['telefoonnummer']) ? $errors['telefoonnummer'] : '' ?></span>
        <span class="errors"><?= isset($errors['mail']) ? $errors['mail'] : '' ?></span>
        <span class="errors"><?= isset($errors['omschrijving']) ? $errors['omschrijving'] : '' ?></span>
        <span class="errors"><?= isset($errors['datevan']) ? $errors['datevan'] : '' ?></span>
        <span class="errors"><?= isset($errors['datetot']) ? $errors['datetot'] : '' ?></span>
        <span class="errors"><?= isset($errors['timevan']) ? $errors['timevan'] : '' ?></span>
        <span class="errors"><?= isset($errors['timetot']) ? $errors['timetot'] : '' ?></span>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <p><b>Uw naam</b>*</p>
            <input type="text" name="voornaam" value="<?= isset($voornaam) ? $voornaam : '' ?>" placeholder="Voornaam" required>
            <input type="text" name="achternaam" value="<?= isset($achternaam) ? $achternaam : '' ?>" placeholder="Achternaam" required>
            <br>
            <p><b>Naam organisatie</b></p>
            <input type="text" name="organisatie"  value="<?= isset($organisatie) ? $organisatie : '' ?>" placeholder="Organisatie">
            <br>
            <p><b>Telefoonnummer</b>*</p>
            <input type="text" name="telefoonnummer" value="<?= isset($telefoonnummer) ? $telefoonnummer : '' ?>" placeholder="Telefoonnummer" required>
            <br>
            <p><b>E-mail</b>*</p>
            <input type="email" name="mail" value="<?= isset($mail) ? $mail : '' ?>" placeholder="E-mail" required>
            <input type="email" name="mailbev"  value="<?= isset($mail) ? $mail : '' ?>" placeholder="E-mail bevestigen" required>
            <br>
            <p><b>Omschrijving optreden*</b></p>
            <textarea type="text" name="omschrijving" value="<?= isset($omschrijving) ? $omschrijving : '' ?>" rows="5" cols="50" placeholder="Beschrijf hier het optreden..." required></textarea>
            <br>
            <table>
                <th>
                    <p><b>Van datum-tijd*</b></p>
                    <input type="date" name="datevan" value="<?= isset($datevan) ? $datevan : '' ?>" placeholder="" required>
                    <input type="time" name="timevan" value="<?= isset($timevan) ? $timevan : '' ?>" placeholder="" required>
                </th>
                <th>
                    <p><b>Tot datum-tijd*</b></p>
                    <input type="date" name="datetot" value="<?= isset($datetot) ? $datetot : '' ?>" placeholder="" required>
                    <input type="time" name="timetot" value="<?= isset($timetot) ? $timetot : '' ?>" placeholder="" required>
                </th>
            </table>
            <br>
            <p><b>Welke band(s)?</b>*</p>
            <input type="checkbox" name="band1" value="jeugd"> Jeugdorkest<br>
            <input type="checkbox" name="band2" value="mars"> Show & Marching Band<br>
            <input type="checkbox" name="band3" value="concert"> Concert Band<br><br>
            <br>
            <input type="submit" value="submit"  name="submit">
        </form>
    </div>
    <div class="report-container" style="float: right">
        <h2> Is het in de <?php echo $data->name; ?> een mooie dag voor een muziekoptreden?</h2>
        <div class="time">
            <div><?php echo date("l G:i", $currentTime); ?></div>
            <div><?php echo date("j F, Y",$currentTime); ?></div>
            <div><?php echo ucwords($data->weather[0]->description); ?></div>
        </div>
        <div class="weather-forecast">
            <img
                    src="http://openweathermap.org/img/w/<?php echo $data->weather[0]->icon; ?>.png"
                    class="weather-icon" /> <?php echo $data->main->temp_max; ?>°C<span
        </div>
        <div class="time">
            <div>Luchtvochtigheid: <?php echo $data->main->humidity; ?>%</div>
            <div>Wind snelheid: <?php echo $data->wind->speed; ?> km/h</div>
        </div>
    </div>
    </body>
</html>