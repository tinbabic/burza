
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kupi</title>
</head>

<body>
<h2>Kupi dionicu <?= $firm_name?></h2>
<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=stocks/kupi'?>"
<label for="user">Iznos za Kupiti:</label>
<input type="text" id="amount" name="amount">
<br/>
<input type="submit" id="kupi" value="Kupi">
</form>

</body>

</html>