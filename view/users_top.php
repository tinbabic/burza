
<?php require_once '_header.php'; ?>
<div class="title">
    <h1>Popis najuspješnijih korisnika</h1>
</div>

<div class="content">
    <p>

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

</p>
</div>
<?php require_once '_footer.php'; ?>
