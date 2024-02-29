<?php

global $logged_in;
require 'funkcie.php';
hlavicka('');
require 'navigacia.php';
require 'akcie.php';
    
if (!$logged_in) {
    header('Location: login.php');
    return;
}

$postError = null;
$error = null;
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $uid = $_SESSION['uid'];
    $idc = $_GET['idc'];

    if (isset($_POST['zrus'])) {
        $result = DB::execute(
            "DELETE FROM sportcar_hodnotenie WHERE idc = :idc AND uid = :uid",
            array(':idc' => $idc, ':uid' => $uid)
        );

        if ($result->error) {
            $postError = "Failed to delete rating";
        }
    } elseif (isset($_POST['hodnot'])) {
        $body = $_POST['body'];

        $body = intval($body);
        var_dump($body);
        if ($body < 1 || $body > 5) {
            $postError = "Invalid rating";
        } else {
            $result = DB::execute(
                <<<SQL
                INSERT INTO sportcar_hodnotenie (idc, uid, body)
                VALUES (:idc, :uid, :body) ON DUPLICATE KEY UPDATE body = :body
                SQL,
                array(':idc' => $idc, ':uid' => $uid, ':body' => $body)
            );

            if ($result->error) {
                $postError = "Failed to save rating";
            }
        }
    }
}

if (!isset($_GET['idc'])) {
    header('Location: ponuka.php');
    return;
}

$idc = $_GET['idc'];

$car = DB::queryOne(
<<<SQL
SELECT cars.idc, cars.nazov, rating.body FROM sportcar_auta as cars
    LEFT JOIN sportcar_hodnotenie as rating 
    ON cars.idc = rating.idc AND rating.uid = :uid
WHERE cars.idc = :idc
GROUP BY cars.idc
SQL,
    array(':idc' => $idc, ':uid' => $_SESSION['uid'])
);

if ($car->error) {
    $error = "Failed to load car";
    echo $car->error;
} elseif (!$car->data) {
    $error = "Car not found";
}

?>

<?php function form($car, $postError)
{
    ?>
     <form method="post">
            <fieldset>
            <legend>Hodnotíte</legend>
            testovacie auto: <strong>
            <?php echo $car->data['nazov']; ?>
            </strong><br>
            <label for="body">hodnotenie:</label>
            <select id="body" name="body" >
                <option value="">-</option>
    <?php
    vypis_select(1, 5, intval($car->data['body']));
    ?>
            </select>
            <br>
            </fieldset>    
            <p><input name="hodnot" type="submit" id="hodnot" value="Pridaj / uprav hodnotenie"></p>
   </form>
     <form method="post">
            <p><input name="zrus" type="submit" id="zrus" value="Vymaž hodnotenie"></p>
   </form>
    <?php if ($postError) { ?>
        <p><?php echo $postError; ?></p>
    <?php } ?>
<?php } ?>

<?php if ($error) { ?>
    <section>
        <p><?php echo $error; ?></p>
    </section>
    <?php
} else {
    ?>
<section>
    <?php form($car, $postError); ?> 
</section>
    <?php
}
require 'pata.php';
?>
