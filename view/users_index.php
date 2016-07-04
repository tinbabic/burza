<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dionice</title>
</head>
<body>
    <?php
        var_dump($money);
    ?>
    <h2>Korisnik <?=$_SESSION['username']?></h2>
    <table>
        <tr>
            <td> <?php echo $money;?></td>
            <td> <?php echo $stockSum?></td>
            <td> <?php ?></td>
           
        </tr>
    </table>
</body>
</html>