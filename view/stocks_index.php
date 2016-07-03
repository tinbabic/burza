
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dionice</title>
</head>

<body>
<h2>Popis svih dionica za najnoviji datum</h2>
<?php
$i = 0;
?>
<table>
    <tr>
        <th>Broj</th>
        <th>Ime Firme</th>
        <th>Datum</th>
        <th>Cijena</th>
        <th>Količina</th>
        <th>Dividenda</th>
        <th>Akcije</th>
    </tr>
<?php
foreach($firms_and_stocks as $element) {
    $i++;?>
    <?= '<tr><td>' . $i . '</td>
    <td>' . $element['firm']->name . '</td>
    <td>' . $element['stock']->date . '</td>
    <td>' .$element['stock']->price . '</td>
    <td>' . $element['stock']->volume . '</td>
    <td>' . $element['stock']->dividend .'</td>
    <td>Povijest Kupi Prodaj</td></tr>' ?>
    <?php
    }
    ?>
</table>


</body>

</html>