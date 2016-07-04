<?php


class UsersController extends BaseController {
    //ispisuje sve informacije o korisniku za portfolio
    public function index()
    {
        //čita iz sessiona o kojem se korisniku radi

        //iz sessiona nekak izvuc id usera <--------------

        $user_id = $_SESSION['current_user_id'];
        $se = new Service();
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
    //ispisuje sve korisnike
    public function showAllUsers(){
        $se = new Service();
        $userList = $se->getAllUsers();
        
        $list = array();
        
        //racunam neto vrijednost svakog usera
        foreach($userList as $user){
            $userSaldo = $se->getSaldosByUserId($user->id);
            $userNetWorth = $user->money;
            
            //vrijednost dionica
            foreach ($userSaldo as $saldo){
                $idStock = $saldo->stock_id;
                $temp = $se->getStocksById($idStock);
                $firm = $temp->firm_id;
                $stock = $se->getStocksByFirmIdLastest($firm);
                $userNetWorth = $userNetWorth + $stock->price * $saldo->total_amount;
            }
            $list[$user->username] = $userNetWorth;
        }
        
        $this->registry->template->userList = $list;
            
        //skripta za ispis
        $this->registry->template->show('users_top');
    }
};

?>
