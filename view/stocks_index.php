<?php require_once '_header.php'; ?>


<div class="title">
    <h1>Popis svih dionica za najnoviji datum</h1>
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
        <th>Datum</th>
        <th>Cijena</th>
        <th>Trend</th>
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
    <td>' .$element['trend'] . '</td>
    <td>' . $element['stock']->volume . '</td>
    <td>' . $element['stock']->dividend .'</td>
    <td> <a href="' .  __SITE_URL  . '/index.php?rt=stocks/showPriceHistory&firm_id=' . $element['stock']->firm_id .'">Povijest</a>
        <a href="' .  __SITE_URL  . '/index.php?rt=stocks/kupi&firm_id=' . $element['firm']->id .'&firm_name=' . $element['firm']->name .'">
        Kupi</a> <a href="' .  __SITE_URL  . '/index.php?rt=stocks/prodaj&firm_id=' . $element['firm']->id .'&firm_name=' . $element['firm']->name .'">
        Prodaj</a></td></tr>' ?>
    <?php
    }
    ?>
</table>
</p>
</div>
<?php require_once '_footer.php'; ?>
