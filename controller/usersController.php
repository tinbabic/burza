<?php


class UsersController extends BaseController {
    public function index() {
        //čita iz sessiona o kojem se korisniku radi
        
        //iz sessiona nekak izvuc id usera <--------------
        if(isset($_SESSION["user_id"])) {
            $user_id = $_SESSION['current_user_id'];
            
            $userSaldos = $se->getSaldosByUserId($user_id);
            //suma vrijednosti svhih dionica
            $stockSum = 0;
            foreach ($userSaldos as $saldo) {
                $stock = $se->getStocksById($saldo->stock_id);
                $lastestStock = $se->getStocksByFirmIdLastest($stock->firm_id);
                $stockSum = $stockSum + $lastestStock->price * $saldo->total_amount;
            }
            
            //novac
            $user = $se->getUsersById($user_id);
            $money = $user->money;
            
            $this->registry->template->money = $money;
            $this->registry->template->stockSum = $stockSum;
            
            //pozovi view skriptu za ispis (money, stockSum)
            $this->registry->template->show('users_index');
            
        }
    }    
    //ispisuje sve korisnike
    public function showAllUsers(){
        $se = new Service();
        $userList = $se->getAllUsers();
        
        //pozovi view skriptu za ispis korisnika
        require '../View/allUsers.php';
    }
    
    //ispisuje sve informacije o korisniku za portfolio
    public function  showUser(){
        //čita iz sessiona o kojem se korisniku radi
        
        //iz sessiona nekak izvuc id usera <--------------
        if(isset($_SESSION["user_id"])) {
            $user_id = $_SESSION['current_user_id'];
            
            $userSaldos = $se->getSaldosByUserId($user_id);
            //suma vrijednosti svhih dionica
            $stockSum = 0;
            foreach ($userSaldos as $saldo) {
                $stock = $se->getStocksById($saldo->stock_id);
                $lastestStock = $se->getStocksByFirmIdLastest($stock->firm_id);
                $stockSum = $stockSum + $lastestStock->price * $saldo->total_amount;
            }
            
            //novac
            $user = $se->getUsersById($user_id);
            $money = $user->money;
            
            $this->registry->template->money = $money;
            $this->registry->template->stockSum = $stockSum;
            
            //pozovi view skriptu za ispis (money, stockSum)
            
        }
        
    }
};

?>
