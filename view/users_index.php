<?php require_once '_header.php'; ?>
<div class="title">
    <h1>Korisnik <?=$_SESSION['username']?></h1>
</div>

<div class="content">
    <p>

    <table>
        <tr>
            <th> Rank </th>
            <th> Money </th>
            <th> Value of stocks</th>
            <th> Net Worth</th>
            <th> Overall Gains</th>
            <th> Overall Returns </th>
        </tr>
        <tr>
            <td> <?php echo $rank;?></td>
            <td> <?php echo $money;?></td>
            <td> <?php echo $stockSum;?></td>
            <td> <?php echo $money + $stockSum;?></td>
            <td> <?php echo $money + $stockSum - 100000.00;?></td>
            <td> <?php echo ($money + $stockSum - 100000.00)/100000.00*100;?>%</td>
           
        </tr>
    </table>
</p>
</div>
<?php require_once '_footer.php'; ?>