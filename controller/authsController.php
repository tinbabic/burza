<?php

class AuthsController extends BaseController {
    public function index() {
        if(isset($_SESSION['username'])) {
            $this->registry->template->show('auths_uspjeh');
        }
        else {
            $this->registry->template->show('auths_index');
        }
    }

    public function validate_login() {
        if(empty($_POST['username']) || empty($_POST['password']))
        {
            $this->registry->template->error_msg = 'Please enter username and password!';
            $this->registry->template->show('auths_index');
            return;
        }

        if(!preg_match('/^[a-zA-Z]{3,10}$/', $_POST['username']))
        {
            $this->registry->template->error_msg = 'Username should be between 3 and 10 characters long.';
            $this->registry->template->show('auths_index');
            return;
        }
        $as = new AuthService();
        $user = $as->getPartialUserByUserName();
        if($user === false)
        {
            $this->registry->template->error_msg ='There is no user with that username.';
            $this->registry->template->show('auths_index');
            return;
        }
        else if($user['has_registered'] === '0')
        {
            $this->registry->template->error_msg = 'User with this username is not registered. Please check e-mail.';
            $this->registry->template->show('auths_index');
            return;
        }
        else if(!password_verify($_POST['password'], $user['password']))
        {
            $this->registry->template->error_msg = 'Password is not correct.';
            $this->registry->template->show('auths_index');
            return;
        }
        else
        {
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['current_user_id'] = $user['id'];
            $this->index();

        }
    }

    public function validate_register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['email'])) {
                $this->registry->template->error_msg = 'Please enter username, password and email address!';
                $this->registry->template->show('auths_register');
                return;
            }
            if (!preg_match('/^[A-Za-z]{3,10}$/', $_POST['username'])) {
                $this->registry->template->error_msg = 'Username is between 3 and 10 characters long.';
                $this->registry->template->show('auths_register');
                return;
            } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $this->registry->template->error_msg = 'E-mail address not correct!';
                $this->registry->template->show('auths_register');
                return;
            } else {
                $as = new AuthService();
                if ($as->checkIfUsernameExists()) {
                    $this->registry->template->error_msg = 'There already exists a user with that username.';
                    $this->registry->template->show('auths_register');
                    return;
                }
                $reg_seq = '';
                for ($i = 0; $i < 20; ++$i)
                    $reg_seq .= chr(rand(0, 25) + ord('a'));
                $as->addUser($_POST['username'], $_POST['password'], $_POST['email'], $reg_seq);
                $to = $_POST['email'];
                $subject = 'Registration e-mail';
                $message = 'Dear user ' . $_POST['username'] . "!\nTo complete registration click on the link below: ";
                $message .= 'http://' . $_SERVER['SERVER_NAME'] . __SITE_URL . '/index.php?rt=auths/register&niz=' . $reg_seq . "\n";
                $headers = 'From: admin@tradecity.hr' . "\r\n" .
                    'Reply-To: admin@tradecity.hr' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

                $isOK = mail($to, $subject, $message, $headers);
                if (!$isOK)
                    exit("Error: Can't send e-mail!");
                $this->registry->template->show('auths_index');
                return;
            }
        }
        $this->registry->template->show('auths_register');
    }
    public function register() {
        $sequence = $_GET['niz'];
        $as = new AuthService();
        if(!$as->checkIfSequenceUnique($sequence))
            exit('Registration sequence has more than 1 user.');
        else
        {
            $as->updateUser($sequence);
            $this->registry->template->error_msg = 'Thank you for authenticating your account!';
            $this->registry->template->show('auths_index');
        }
    }
    public function logout() {
        unset($_SESSION['username']);
        unset($_SESSION['current_user_id']);
        $this->index();
    }
}