<?php

require_once '_header.php';
echo 'Bravo' . ' ' . $_SESSION['username']?>

<a href="<?php echo __SITE_URL . '/index.php?rt=auths/logout'?>">LogOut</a>

<?php
    require_once '_footer.php';
?>