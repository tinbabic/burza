<?php
require_once 'Model/dbClass.php';
session_start();
//ovo je relic starog authentifikacijskog sustava koji je sada pretvoren u MVC auth ervice
//vise se ne koristi


/*
authenticate(0/1) 0 -> not a autherization page, 1-> auth page; mostly use 0
1. checks if the current session has any1 logged in, if so does nothing
2. if no user is logged in, checks if any1 tried to send data, and goes
on to proper validation
3. doesn't allow any pages to be seen without logging in first
4. if logout is pressed, proceeds accordingly to log the user out
5. if user is logged in, he cannot go to login unti he logs out
*/
function authenticate($is_auth_page) {
    if(isset($_SESSION['username']) && !isset($_POST['logout'])) {
        if($is_auth_page == 1) {
            header('Location:blabla.php'); //set to index later
        }
        return;
    }
    if(isset($_POST['login'])) {
        validate_login();
    }
    if(isset($_POST['register'])) {
        validate_register();
    }
    if(isset($_POST['logout'])) {
        logout();
    }
    if($is_auth_page != 1) {
        header('Location:login.php'); //set to login page later
    }
}
/*
1. error messages saved into $_SESSION['error_msg'] variable, please unset after use
2. checks if username and password are blank, if so, redirects with error
3. checks if username is in proper form, if not, redirects with error
4. gets the related entires from the DB, if not equal to the username, redirects
5. if user didn't complete registration, throws error
6. checks the password, if incorrect, throws error
7. if all passed, logs the user in with the current session.
*/
function validate_login() {
    if(!isset($_POST['username']) || !isset($_POST['password']))
    {
        $_SESSION['error_msg'] = 'Please enter username and password!';
        return;
    }

    if(!preg_match('/^[a-zA-Z]{3,10}$/', $_POST['username']))
    {
        $_SESSION['error_msg'] = 'Username should be between 3 and 10 characters long.';
        return;
    }

    $db = dbClass::getConnection();

    try
    {
        $vt = $db->prepare('SELECT username, password, has_registered FROM users WHERE username=:username');
        $vt->execute(array('username' => $_POST['username']));
    }
    catch(PDOException $e)
    {
        exit('Error' . $e->getMessage());
    }

    $row = $vt->fetch();

    if($row === false)
    {
        $_SESSION['error_msg'] = 'There is no user with that username.';
        return;
    }
    else if($row['has_registered'] === '0')
    {
        $_SESSION['error_msg'] = 'User with this username is not registered. Please check e-mail.';
        return;
    }
    else if(!password_verify($_POST['password'], $row['password']))
    {
        $_SESSION['error_msg'] = 'Password is not correct.';
        return;
    }
    else
    {
        $_SESSION['username'] = $_POST['username'];
        header('Location:blabla.php');
    }
}
function validate_register() {

    if (!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['email'])) {
        $_SESSION['error_msg'] = 'Please enter username, password and email address!';
        return;
    }

    if (!preg_match('/^[A-Za-z]{3,10}$/', $_POST['username'])) {
        $_SESSION['error_msg'] = 'Username is between 3 and 10 characters long.';
        return;
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_msg'] = 'E-mail address not correct!';
        return;
    } else {
        $db = dbClass::getConnection();

        try {
            $zt = $db->prepare('SELECT * FROM users WHERE username=:username');
            $zt->execute(array('username' => $_POST['username']));
        } catch (PDOException $e) {
            exit('Error' . $e->getMessage());
        }

        if ($zt->rowCount() !== 0) {
            $_SESSION['error_msg'] = 'There already exists a user with that username.';
            return;
        }

        // Dodaj novog korisnika u bazu. Prvo mu generiraj random string od 10 znakova za registracijski link.
        $reg_seq = '';
        for ($i = 0; $i < 20; ++$i)
            $reg_seq .= chr(rand(0, 25) + ord('a')); // Zalijepi slučajno odabrano slovo

        try {
            $zt = $db->prepare('INSERT INTO users(username, password, email, reg_seq, has_registered) VALUES ' .
                '(:username, :password, :email, :reg_seq, 0)');

            $zt->execute(array('username' => $_POST['username'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'email' => $_POST['email'],
                'reg_seq' => $reg_seq));
        } catch (PDOException $e) {
            exit('Error' . $e->getMessage());
        }

        // Sad mu još pošalji mail
        $to = $_POST['email'];
        $subject = 'Registration e-mail';
        $message = 'Dear user ' . $_POST['username'] . "!\nTo complete registration click on the link below: ";
        $message .= 'http://' . $_SERVER['SERVER_NAME'] . htmlentities(dirname($_SERVER['PHP_SELF'])) . '/register.php?niz=' . $reg_seq . "\n";
        $headers = 'From: admin@tradecity.hr' . "\r\n" .
            'Reply-To: admin@tradecity.hr' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        $isOK = mail($to, $subject, $message, $headers);

        if (!$isOK)
            exit("Error: Can't send e-mail!");
        header('Location:login.php');
    }
}

function logout() {
    unset($_SESSION['username']);
}


?>