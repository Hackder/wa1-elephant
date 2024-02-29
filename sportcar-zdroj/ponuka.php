<?php
require 'funkcie.php';
hlavicka('');
require 'navigacia.php';
require 'akcie.php';

$cars = DB::queryAll(
<<<SQL
SELECT cars.idc, cars.nazov, cars.vykon, cars.rychlost, AVG(ratings.body) as rating
FROM sportcar_auta as cars
    LEFT JOIN sportcar_hodnotenie as ratings ON cars.idc = ratings.idc
    LEFT JOIN sportcar_terminy as dates ON cars.idc = dates.idc
WHERE dates.uid = 0
GROUP BY cars.idc ORDER BY cars.nazov
SQL
);

?>
<section>

<?php if ($cars->error) { ?>
    <p>Failed to load cars</p>
    <p><?php echo $cars->error; ?></p>
<?php } elseif (count($cars->data) <= 0) { ?>
    <p>No cars found</p>
<?php } else { ?>

    <?php function tableRow($car)
    {
        $image = "obrazky/" . $car['idc'] . ".jpg";
        ?>
  <tr>
  <td><?php echo $car['nazov'] ?></td>
    <td><?php echo $car['vykon'] ?> kW</td>
    <td><?php echo $car['rychlost'] ?> km/h</td>
    <td>
    <img src=<?php echo '"' . $image . '"' ?> alt=<?php echo '"' . $car['nazov'] . '"' ?> width="150" />
    </td>
    <td class="centruj">
        <?php
        if ($car['rating']) {
            echo number_format($car['rating'], 1);
        } else {
            echo 'bez hodnotenia';
        }
        ?>
    </td>
    <td>
    <a href="hodnotenie.php?idc=<?php echo $car['idc'] ?>">hodnoť</a>
    </td>
    <td>
    <a href="jazda.php?idc=<?php echo $car['idc'] ?>">rezervuj jazdu</a>
    </td>
  </tr>
    <?php } ?>

<table>
  <tr>
    <th>auto</th>
    <th>výkon</th>
    <th>max. rýchlosť</th>
    <th>foto</th>
    <th>hodnotenie</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
  </tr>
    <?php foreach ($cars->data as $car) {
        tableRow($car);
    } ?>
</table>
<?php } ?>

</section>
<?php
require 'pata.php';
?>
