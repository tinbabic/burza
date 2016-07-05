<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Register</title>
    <link rel="stylesheet" href="<?php echo __SITE_URL;?>/css/style.css">
</head>

<body>
<div class="wrap">
<div class="rightcol">
    <div class="page-content">
        <div class="panel mar-bottom">
            <div class="content">
                <p>
<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=auths/validate_register'?>">
    <table class="login"> <tr>
<label for="user">User Name:</label>
<input type="text" id="user" name="username">
</tr>
<tr>
    <td><label for="pass">Password:</label></td>
    <td><input type="password" id="pass" name="password"></td>
</tr>
<tr>
    <td><label for="email">Email:</label></td>
    <td><input type="text" id="email" name="email"></td>
</tr>
    </table>
    <input type="submit" name="register" value="Register">
</form>

<?php
if(isset($error_msg)) {
    echo $error_msg;
}

?>

 </p></div></div></div></div></div>
</body>

</html>