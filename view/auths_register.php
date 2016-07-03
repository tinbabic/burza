<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Register</title>
</head>

<body>

<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=auths/validate_register'?>"
<label for="user">User Name:</label>
<input type="text" id="user" name="username">
<br/>
<label for="pass">Password:</label>
<input type="password" id="pass" name="password">
<br/>
<label for="email">Email:</label>
<input type="text" id="email" name="email">
<br/>
<input type="submit" name="register" value="Register">
</form>

<?php
if(isset($error_msg)) {
    echo $error_msg;
}

?>


</body>

</html>