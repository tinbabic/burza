<?php require_once '_header.php'; ?>
<h2>Popis Dionica za korisnika: <?=$_SESSION['username']?></h2>
<?php
$i = 0;
?>
<table>
    <tr>
        <th>#</th>
        <th>Ime Firme</th>
        <th>Ukupno</th>
    </tr>
<?php
foreach($userStocks as $user_stock) {
    $i++;?>
    <?= '<tr><td>' . $i . '</td>
    <td>' . $firm_names[$user_stock->stock_id] . '</td>
    <td>' . $user_stock->total_amount . '</td></tr>' ?>
    <?php
    }
    ?>
</table>


<?php require_once '_footer.php'; ?>