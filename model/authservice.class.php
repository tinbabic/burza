<?php
class AuthService {
    public function getPartialUserByUserName() {
        $db = DB::getConnection();

        try
        {
            $vt = $db->prepare('SELECT id, username, password, has_registered FROM users WHERE username=:username');
            $vt->execute(array('username' => $_POST['username']));
        }
        catch(PDOException $e)
        {
            exit('Error' . $e->getMessage());
        }

        $row = $vt->fetch();
        return $row;
    }
    public function checkIfUsernameExists() {
        $db = DB::getConnection();

        try
        {
            $vt = $db->prepare('SELECT * FROM users WHERE username=:username');
            $vt->execute(array('username' => $_POST['username']));
        }
        catch(PDOException $e)
        {
            exit('Error' . $e->getMessage());
        }
        if ($vt->rowCount() !== 0) {
            return true;
        }
        return false;
    }
    public function addUser($username, $password, $email, $reg_seq) {
        $db = DB::getConnection();
        try {
            $vt = $db->prepare('INSERT INTO users(username, password, email, reg_seq, has_registered) VALUES ' .
                '(:username, :password, :email, :reg_seq, 0)');

            $vt->execute(array('username' => $username,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'email' => $email,
                'reg_seq' => $reg_seq));
        } catch (PDOException $e) {
            exit('Error' . $e->getMessage());
        }

    }
    public function checkIfSequenceUnique($sequence) {
        $db = DB::getConnection();
        try
        {
            $vt = $db->prepare('SELECT * FROM users WHERE reg_seq=:reg_seq');
            $vt->execute(array('reg_seq' => $sequence));
        }
        catch(PDOException $e)
        {
            exit('Error' . $e->getMessage());
        }

        if($vt->rowCount() !== 1) {
            return false;
        }
        return true;
    }
    public function updateUser($sequence) {
        $db = DB::getConnection();
        try
        {
            $vt = $db->prepare('UPDATE users SET has_registered=1 WHERE reg_seq=:reg_seq');
            $vt->execute(array('reg_seq' => $sequence));
        }
        catch(PDOException $e)
        {
            exit('Error' . $e->getMessage());
        }

    }

};



?>
