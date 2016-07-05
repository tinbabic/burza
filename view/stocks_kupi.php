<?php require_once '_header.php'; ?>
<div class="title">
    <h1>Kupi dionicu <?= $firm_name?></h1>
</div>
<div class="content">
    <p>
<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=stocks/kupi'?>"
<label for="user">Iznos za Kupiti:</label>
<input type="text" id="amount" name="amount">
<input type="hidden" name="firm_id" value="<?=$firm_id?>">
<br/>
<input type="submit" id="kupi" value="Kupi">
</form>
<?php
if(isset($error_msg)) {
    echo $error_msg;
}
?>
</p>
</div>
<?php require_once '_footer.php'; ?>

