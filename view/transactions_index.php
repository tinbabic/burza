<?php require_once '_header.php'; ?>


<h2>Popis Transakcija za korisnika: <?=$_SESSION['username']?></h2>
<?php
$i = 0;
?>
<table>
    <tr>
        <th>#</th>
        <th>Ime Firme</th>
        <th>Iznos</th>
        <th>Vrsta</th>
    </tr>
<?php
foreach($transactions as $transaction) {
    $i++;?>
    <?= '<tr><td>' . $i . '</td>
    <td>' . $firm_names[$transaction->stock_id] . '</td>
    <td>' . $transaction->amount . '</td>
    <td>' . $transaction->buying . '</td></tr>' ?>
    <?php
    }
    ?>
</table>

<?php require_once '_footer.php'; ?>