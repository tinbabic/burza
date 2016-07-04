<?php require_once '_header.php'; ?>
<h2>Popis Firmi</h2>
<?php
$i = 0;
?>
<table>
    <tr>
        <th>#</th>
        <th>Simbol</th>
        <th>Ime</th>
    </tr>
<?php
foreach($firms as $firm) {
    $i++;?>
    <?= '<tr><td>' . $i . '</td>
    <td>' . $firm->symbol . '</td>
    <td>' . $firm->name . '</td></tr>' ?>
<?php
}
?>
</table>


<?php require_once '_footer.php'; ?>