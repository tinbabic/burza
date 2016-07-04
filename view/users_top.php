
<?php require_once '_header.php'; ?>


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


<?php require_once '_footer.php'; ?>
