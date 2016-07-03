
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Firme</title>
</head>

<body>
<h2>Popis Firmi</h2>
<?php
$i = 0;
?>
<table>
    <tr>
        <th>Broj</th>
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


</body>

</html>