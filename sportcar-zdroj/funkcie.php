<?php
function vypis_select($zac, $kon, $default = 0)
{
    for($i = $zac; $i <= $kon; $i++) {
        echo "<option value='$i'";
        if ($i == $default) {
            echo ' selected';
        }
        echo ">$i</option>\n";
    }
}

function h($s)
{
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

function hlavicka($nadpis)
{
    ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php if ($nadpis == '') {
    $nadpis = 'UWT sportcar';
} echo h($nadpis); ?></title>
<link href="styly.css" rel="stylesheet">
</head>
<body>
  <div id="dekoracne_obr">
  <img src="obrazky/m_Maserati-GT-Stradale.jpg" alt="Maserati-GranTurismo-MC-Stradale" title="Maserati-GranTurismo-MC-Stradale" height="59" width="150"> <img src="obrazky/m_Ferrari-458.jpg" alt="Ferrari-458-Italia" title="Ferrari-458-Italia" height="64" width="150"> <img src="obrazky/m_Aston-Martin.jpg" alt="Aston-Martin-DBSCoupe" title="Aston-Martin-DBSCoupe" height="63" width="150"> <img src="obrazky/m_Lamborghini-Gallardo.jpg" alt="Lamborghini-Gallardo-LP-570-4-Superleggera" title="Lamborghini-Gallardo-LP-570-4-Superleggera" height="66" width="150">
  </div>
<div id="main">
    <header>
        <h1><?php echo h($nadpis); ?></h1>
    </header>
    <?php
}

session_start();

$logged_in = isset($_SESSION['uid']);

class Result
{
    public $error;
    public $data;

    public function __construct($data, $error)
    {
        $this->data = $data;
        $this->error = $error;
    }
}

class DB
{
    private static $pdo;

    public static function connect(): PDO
    {
        if (!isset(self::$pdo)) {
            self::$pdo = new PDO('mysql:host=localhost;dbname=skuska_test', 'root', '');
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$pdo;
    }

    public static function queryOne($sql, $params = array()): Result
    {
        try {
            $stmt = self::connect()->prepare($sql);
            $stmt->execute($params);

            return new Result($stmt->fetch(), null);
        } catch (PDOException $e) {
            return new Result(null, $e->getMessage());
        }
    }

    public static function queryAll($sql, $params = array()): Result
    {
        try {
            $stmt = self::connect()->prepare($sql);
            $stmt->execute($params);
            return new Result($stmt->fetchAll(), null);
        } catch (PDOException $e) {
            return new Result(null, $e->getMessage());
        }
    }

    public static function execute($sql, $params = array()): Result
    {
        try {
            $stmt = self::connect()->prepare($sql);
            $stmt->execute($params);
            return new Result(null, null);
        } catch (PDOException $e) {
            return new Result(null, $e->getMessage());
        }
    }
}

?>
