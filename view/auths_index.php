
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="<?php echo __SITE_URL;?>/css/style.css">
</head>

<body>
<div class="wrap">
<div class="rightcol">
    <div class="page-content">
        <div class="panel mar-bottom">
            <div class="content">
                <p>
                <form method="post" action="<?php echo __SITE_URL . '/index.php?rt=auths/validate_login'?>">
                <table class="login">  <tr>              
                    
                        <td><label for="user">User Name:</label></td>
                        <td><input type="text" id="user" name="username"></td>
                </tr>  
                <tr>
                    <td><label for="pass">Password:</label></td>
                    <td><input type="password" id="pass" name="password"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="login" value="Login"></td>
</form>
Ako nemate racun, <a href="<?php echo __SITE_URL . '/index.php?rt=auths/validate_register'?>">registrirajte</a> se.
<?php
if(isset($error_msg)) {
    echo $error_msg;
}

?>
                </table>
            </p></div></div></div></div></div>
</body>

</html>