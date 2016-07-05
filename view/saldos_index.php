<?php require_once '_header.php'; ?>
<div class="title">
    <h1>Popis Dionica za korisnika: <?=$_SESSION['username']?></h1>
</div>
<div class="content">
    <p>
<?php
$i = 0;
?>
<table>
    <tr>
        <th>#</th>
        <th>Ime Firme</th>
        <th>Ukupno</th>
        <th></th>
    </tr>
<?php
foreach($userStocks as $user_stock) {
    $i++;?>
    <?= '<tr><td>' . $i . '</td>
    <td>' . $firm_names[$user_stock->firm_id] . '</td>
    <td>' . $user_stock->total_amount . '</td> 
    <td>' . '<a href="' .  __SITE_URL  . '/index.php?rt=stocks/prodaj&firm_id=' . $user_stock->firm_id.'&firm_name=' . $firm_names[$user_stock->firm_id] .'">
        Prodaj</a>' . '</td></tr>' ?>
    <?php
    }
    ?>
</table>
</p>
</div>

<?php require_once '_footer.php'; ?>