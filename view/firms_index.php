<?php require_once '_header.php'; ?>
<div class="title">
    <h1>List of firms</h1>
</div>
<div class="content">
    <p>
<?php
$i = 0;
?>
<table>
    <tr>
        <th>#</th>
        <th>Symbol</th>
        <th>Name</th>
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

</p>
</div>
<?php require_once '_footer.php'; ?>