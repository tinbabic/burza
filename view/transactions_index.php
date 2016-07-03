
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Transakcije</title>
</head>

<body>
<h2>Popis Transakcija za korisnika: <?=$_SESSION['username']?></h2>
<?php
$i = 0;

foreach($transactions as $transaction) {
$i++;?>
<table>
    <tr>
        <th>Broj</th>
        <th>Ime Firme</th>
        <th>Iznos</th>
        <th>Vrsta</th>
    </tr>
    <?= '<tr><td>' . $i . '</td><td>' . $firm_names[$transaction->stock_id] . '</td><td>' . $transaction->amount . '</td><td>' . $transaction->buying . '</td></tr>' ?>
    <?php
    }
    ?>
</table>


</body>

</html>