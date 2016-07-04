<?php require_once '_header.php'; ?>

<h2>Prodaj dionicu <?= $firm_name?></h2>
<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=stocks/prodaj'?>"
<label for="user">Iznos za Prodati:</label>
<input type="text" id="amount" name="amount">
<input type="hidden" name="firm_id" value="<?=$firm_id?>">
<br/>
<input type="submit" id="prodaj" value="Prodaj">
</form>
<?php
if(isset($error_msg)) {
    echo $error_msg;
}
?>
<?php require_once '_footer.php'; ?>

