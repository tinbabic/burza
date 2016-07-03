
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login</title>
</head>

<body>

<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=auths/validate_login'?>"
<label for="user">User Name:</label>
<input type="text" id="user" name="username">
<br/>
<label for="pass">Password:</label>
<input type="password" id="pass" name="password">
<br/>
<input type="submit" name="login" value="Login">
</form>
Ako nemate racun, <a href="<?php echo __SITE_URL . '/index.php?rt=auths/validate_register'?>">registrirajte</a> se.
<?php
if(isset($error_msg)) {
    echo $error_msg;
}

?>


</body>

</html>