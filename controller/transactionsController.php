<?php


class TransactionsController extends BaseController {
    public function index() {
    
    }
    public function showAllUserTransactions(){
        //iz sessiona nekak izvuc id usera <--------------
        if(isset($_SESSION["user_id"])) {
            $user_id = $_SESSION["user_id"];
            
            $se = new Service();
            $transactions = $se->getTransactionsByUserId($user_id);
            
            //skripta za ispis povijesti transakcija
            require '../View/transactionHistory.php';
            
        } else{ //error
            require '../View/accessDenied.php';
        }
    }
}
