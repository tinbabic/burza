<?php require_once '_header.php'; ?>

<div class="title">
    <h1>All transactions of : <?=$_SESSION['username']?></h1>
</div>

<div class="content">
    <p>
<?php
$i = 0;
?>
<table>
    <tr>
        <th>#</th>
        <th>Name</th>
        <th>Amount</th>
        <th>Buying</th>
        <th>Datetime</th>
    </tr>
<?php
foreach($transactions as $transaction) {
    $i++;?>
    <?= '<tr><td>' . $i . '</td>
    <td>' . $firm_names[$transaction->stock_id] . '</td>
    <td>' . $transaction->amount . '</td>
    <td>' . $transaction->buying . '</td>
    <td>' . $transaction->date . '</td></tr>' ?>
    <?php
    }
    ?>
</table>
</p>
</div>
<?php require_once '_footer.php'; ?>