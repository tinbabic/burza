<?php
/*
 * VAŽNO! stock_id bi trebao ostat fiksan za jednog usera i jedan stock u ovoj tablici, i samo mu updejtat broj
 * programski rijesiti....bazno rijesit..nesto bla
 *
 * ILI da update daily jednostavno updejta i sve brojeve salda na najnovije stock ideve .. za razmislit sutra
 */




class SaldosController extends BaseController {
    public function index() {
        $se = new Service();
        $user_id = $_SESSION['current_user_id'];
        $userStocks = $se->getSaldosByUserId($user_id);
        $firm_names = array();
        foreach($userStocks as $user_stock) {
            //da bi u view-u imali imena firmi jer je to prirodnije za pokazat
            //ovdje spremam u polje p[stock_id]=ime_firme
            $stock = $se->getStocksById($user_stock->stock_id);
            $firm = $se->getFirmsById($stock->firm_id);
            $firm_names[$user_stock->stock_id] = $firm->name;
        }
        $this->registry->template->userStocks = $userStocks;
        $this->registry->template->firm_names = $firm_names;
        $this->registry->template->show('saldos_index');
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
