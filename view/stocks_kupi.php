
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
<input type="hidden" name="firm_id" value=" <?=$firm_id?> ">
<br/>
<input type="submit" id="kupi" value="Kupi">
</form>
<?php
if(isset($error_msg)) {
    echo $error_msg;
}

?>
</body>

</html>