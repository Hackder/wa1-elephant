<?php
require 'funkcie.php';
hlavicka('');
require 'navigacia.php';
require 'akcie.php';
    
$error = null;
if (!$logged_in) {
    header('Location: login.php');
    return;
}

$message = null;
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['submit'])) {
        $idc = $_GET['idc'];
        $idt = $_POST['datum'];
        $uid = $_SESSION['uid'];

        if (!$idt) {
            $error = "Invalid date";
        } else {
            $result = DB::execute(
                "UPDATE sportcar_terminy SET uid = :uid WHERE idt = :idt AND uid = 0",
                array(':uid' => $uid, ':idt' => $idt)
            );

            if ($result->error) {
                $error = "Failed to reserve date";
            } else {
                $message = "Date reserved";
            }
        }
    }
}

$user = DB::queryOne(
    "SELECT meno, priezvisko FROM sportcar_pouzivatelia WHERE uid = :uid",
    array(':uid' => $_SESSION['uid'])
);

if ($user->error) {
    $error = "Failed to load user data";
} else {
    $fullname = $user->data['meno'] . ' ' . $user->data['priezvisko'];
}

$car = DB::queryOne(
    "SELECT nazov FROM sportcar_auta WHERE idc = :idc",
    array(':idc' => $_GET['idc'])
);

if ($car->error) {
    $error = "Failed to load car data";
} elseif ($car->data === null) {
    header('Location: ponuka.php');
    return;
}

$available_dates = DB::queryAll(
    "SELECT idt, datum FROM sportcar_terminy WHERE idc = :idc AND datum > NOW() AND uid = 0;",
    array(':idc' => $_GET['idc'])
);

if ($available_dates->error) {
    $error = "Failed to load available dates";
    var_dump($available_dates);
}
?>

<?php if ($error) { ?>
    <p><?php echo $error; ?></p>
    <?php 
    return;
} ?>

<section>

     <form method="post">
            <fieldset>
            <legend>Rezervácia</legend>
            Objednávateľ: <strong><?php echo $fullname ?></strong><br>
            testovacie auto: <strong><?php echo $car->data['nazov'] ?></strong><br>
            <label for="datum">dátum testovania:</label>
            <select id="datum" name="datum">
                <option value="">-</option>
                <?php
                foreach ($available_dates->data as $date) {
                    echo '<option value="' . $date['idt'] . '">' . $date['datum'] . '</option>';
                }
                ?>
            </select>
            <br>
            </fieldset>    
            <p><input name="submit" type="submit" id="submit" value="Rezervuj"></p>
            <p><?php echo $message; ?></p>
   </form>

</section>
<?php
require 'pata.php';
?>
