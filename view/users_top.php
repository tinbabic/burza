
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Transakcije</title>
</head>

<body>
<h2>Popis najuspješnijih korisnika</h2>

<table>
    <tr>
        <th>#</th>
        <th>Ime</th>
        <th>Neto Vrijednost</th>
    </tr>
<?php
$i=0;
foreach($userList as $user => $netWorth) {
    $i++;?>
    <?= '<tr><td>' . $i . '</td>
    <td>' . $user . '</td>
    <td>' . $netWorth . '</td></tr>' ?>
    <?php
    }
    ?>
</table>


</body>

</html>
