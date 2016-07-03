<?php
require_once 'Model/dbClass.php';
session_start();


// Ova skripta analizira $_GET['niz'] i u bazi postavlja has_registered=1 za onog korisnika koji ima taj niz.

if(!isset($_GET['niz']) || !preg_match('/^[a-z]{20}$/', $_GET['niz']))
    exit('Problem with sequence!');

// Nađi korisnika s tim nizom u bazi
$db = dbClass::getConnection();

try
{
    $at = $db->prepare('SELECT * FROM users WHERE reg_seq=:reg_seq');
    $at->execute(array('reg_seq' => $_GET['niz']));
}
catch(PDOException $e)
{
    exit('Error' . $e->getMessage());
}

$row = $at->fetch();

if($at->rowCount() !== 1)
    exit('Registration sequence has ' . $at->rowCount() . 'users, but should have only 1.');
else
{
    // Postavi mu has_registered na 1.
    try
    {
        $at = $db->prepare('UPDATE users SET has_registered=1 WHERE reg_seq=:reg_seq');
        $at->execute(array('reg_seq' => $_GET['niz']));
    }
    catch(PDOException $e)
    {
        exit('Error' . $e->getMessage());
    }
    $_SESSION['error_msg'] = 'Thank you for authenticating your account!';
    header('Location:login.php');
}

?>