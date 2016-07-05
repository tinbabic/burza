
<?php require_once '_header.php'; ?>
<div class="title">
    <h1>Top users</h1>
</div>

<div class="content">
    <p>

<table>
    <tr>
        <th>#</th>
        <th>Name</th>
        <th>Net Worth</th>
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
