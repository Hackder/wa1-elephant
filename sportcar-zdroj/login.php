<?php
require 'funkcie.php';
hlavicka('');
require 'navigacia.php';
require 'akcie.php';


if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // Is logout
    if (isset($_POST['odhlas'])) {
        session_destroy();
        header('Location: login.php');
        return;
    }

    $username = $_POST['username'];
    $password = $_POST['heslo'];

    $user = DB::queryOne(
        "SELECT uid, username, heslo FROM sportcar_pouzivatelia WHERE username = :username",
        array(':username' => $username)
    );

    if ($user->error) {
        $error = "Login failed";
    } else {
        $password_hash = md5($password);
        if ($password_hash === $user->data['heslo']) {
            $_SESSION['uid'] = $user->data['uid'];
            $_SESSION['username'] = $user->data['username'];
            header('Location: login.php');
            return;
        } else {
            $error = "Nesprávne prihlasovacie meno alebo heslo";
        }
    }
}

if ($logged_in) {
    $uid = $_SESSION['uid'];
    $user = DB::queryOne(
        "SELECT uid, username, meno, priezvisko FROM sportcar_pouzivatelia WHERE uid = :uid",
        array(':uid' => $uid)
    );

    if ($user->error) {
        $error = "Failed to load user data";
    } else {
        $fullname = $user->data['meno'] . ' ' . $user->data['priezvisko'];
    }
}

?>
<section>


<?php if ($logged_in) { ?>
<section>
  Vitaj v systeme, <?php echo h($fullname); ?>.
</section>
<?php } ?>

<form method="post"> 
  <p> 
    <input name="odhlas" type="submit" id="odhlas" value="Odhlás ma"> 
  </p> 
</form> 

<form method="post">
<fieldset>
    <legend>Prihlásenie</legend>
    <label for="username">prihlasovacie meno:</label>
    <input name="username" type="text" id="username" value="" size="20" maxlength="20">
    <br>
    <label for="heslo">heslo:</label>
    <input name="heslo" type="password" id="heslo" size="20" maxlength="20">
    <br>
</fieldset>
<p><input name="submit" type="submit" id="submit" value="Prihlás"></p>
<?php if (isset($error)) { ?>
  <p><?php echo $error; ?></p>
<?php } ?>
</form>

</section>
<?php
require 'pata.php';
?>
