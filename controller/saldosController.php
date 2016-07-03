<?php


class SaldosController extends BaseController {
    public function index() {
    
    }
    
    //ispisuje sve dionice koje trenutni korisnik posjeduje
    public function showSaldos(){
        $se = new Service();
        

        if(isset($_SESSION["user_id"])) {
            $user_id = $_SESSION["user_id"];
            $userStock = $se->getSaldosByUserId($user_id);
        
            //pozovi view skriptu za ispis dionica
            require '../View/userSaldo.php';
        }
        else {
            //ništa ne radi ili ispiši neku poruku access denied/need to login
            require '../View/accessDenied.php';
        }
    }
    
    //zapisuje nove dionice ili modificira postojeće
    public function inputSaldos(){
        $se = new Service();
        
        //iz dohvatiti nekako id usera i dionice
        
        //skripta za kupnju dionica
        
        //zapis u bazu
        $se->insertSaldo($saldo);
        $se->insertTransaction($transaction);
    }
}

?>
