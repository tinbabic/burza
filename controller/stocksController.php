<?php


class StocksController extends BaseController {
    //dohvacamo podatke o firmama i dionicama kako bi dionce mogli ispisati sa
    //imenom firme jer je tako ljepse u viewu
    public function index() {
        $se = new Service();
        $firms = $se->getAllFirms();
        $firms_and_stocks = array();
        foreach($firms as $firm) {
            //za svaku firmu nadjemo najnoviju dionicu
            //zatim u element kao array spremimo firmu i pripadnu dionicu pod isti key
            //firms_and_stocks sada za svaki key ima par firme i stocka, za ispis
            $latest_stock = $se->getStocksByFirmIdLastest($firm->id);
            $second = $se->getStocksByFirmId2ndLastest($firm->id);
            $trend = $latest_stock->price > $second->price ? 1 : 0;
            $element['firm'] = $firm;
            $element['stock'] = $latest_stock;
            $element['trend'] = $trend;
            $firms_and_stocks[] = $element;
        }
        $this->registry->template->firms_and_stocks = $firms_and_stocks;
        $this->registry->template->show('stocks_index');
    }
    //ispisuje povijest dionice
    public function showPriceHistory(){
        $se = new Service();
        

        if(isset($_GET['firm_id'])){
            $firm_id = $_GET['firm_id'];
            //$firm_id = 9224;
            
            $firm = $se->getFirmsById($firm_id);
            $name = $firm->name;

            $arr = $se->getStocksByFirmId($firm_id);
            $data = array();
            $dividend = NULL;
            $exDivDate = NULL;
            foreach($arr as $stock){
                if($stock->dividend !== 0 && $dividend !== NULL){
                    $dividend = $stock->dividend;
                    $exDivDate = $stock->date;
                }
                $data[$stock->date] = array($stock->price, $stock->volume, $stock->dividend);
            }
            $low = $arr[0]->price;
            $high = $arr[0]->price;
            $newPrice = $arr[0]->price;
            $lastPrice = $arr[1]->price;
            $changePrevious = $lastPrice - $newPrice;
            
            for($i=0; $i<7; $i++){
                if($arr[$i]->price < $low) { $low=$arr[$i]->price;}
                if($arr[$i]->price > $high) { $high=$arr[$i]->price;}
            }

            $this->registry->template->data = $data;
            $this->registry->template->name = $name;
            $this->registry->template->newPrice = $newPrice;
            $this->registry->template->lastPrice = $lastPrice;
            $this->registry->template->changePrevious = $changePrevious;
            $this->registry->template->low = $low;
            $this->registry->template->high = $high;
            $this->registry->template->dividend = $dividend;
            $this->registry->template->exDivDate = $exDivDate;
            
            

            $this->registry->template->show('stock_history');
        }
        
    }
    //kupi je glavna funkcija za kupovanje i drzanje konzistentnim svih podatka u bazi
    //oko kupnje dionica
    //funkciju pozivamo sa dva nacina, preko post forme (kada zbilja kupujemo, i preko geta /linka
    // kada samo ucitava formu za kupnju.
    //1. funckija kad samo ucitava formu salje samo ime firme ciju dionicu kupujemo za view
    //2. kada se poziva iz forme preko post zahtjeva (tj saljemo podatke bitne za kupnju
    
    public function kupi() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $amount = $_POST['amount'];
            $se = new Service();
            $firm_id = $_POST['firm_id'];
            $stock = $se->getStocksByFirmIdLastest($firm_id);
            $price = $stock->price;
            $user_id = $_SESSION['current_user_id'];
            $user = $se->getUsersById($user_id);
            $money = $user->money;
            if($amount*$price <= $money) {
                $money -= $amount*$price;
                $user->money = $money;
                $transaction = new Transaction(NULL,$stock->id,$user_id,$amount,1,NULL);
                $saldos = $se->getSaldosByUserId($user_id);
                $found_saldo = NULL;
                foreach($saldos as $saldo) {
                    if($saldo->firm_id == $firm_id) {
                        $found_saldo = $saldo;
                        break;
                    }
                }
                if($found_saldo !== NULL) {
                    $found_saldo->total_amount += $amount;
                    $se->insertSaldo($found_saldo);
                } else {
                    $saldo = new Saldo(NULL,$user_id,$firm_id,$amount);
                    $se->insertSaldo($saldo);
                }
                $se->insertUser($user);
                $se->insertTransaction($transaction);
                $this->index();
                return;
            } else {
                $this->registry->template->error_msg = "You don't have enough funds!";
                $this->registry->template->firm_id = $firm_id;
                $firm = $se->getFirmsById($firm_id);

                $this->registry->template->firm_name = $firm->name;
                $this->registry->template->show('stocks_kupi');
            }
        } else {
            $firm_id = $_GET['firm_id'];
            $firm_name = $_GET['firm_name'];
            $this->registry->template->firm_id = $firm_id;
            $this->registry->template->firm_name = $firm_name;
            $this->registry->template->show('stocks_kupi');
        }
    }
    public function prodaj() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $amount = $_POST['amount'];
            $se = new Service();
            $firm_id = $_POST['firm_id'];
            $stock = $se->getStocksByFirmIdLastest($firm_id);
            $price = $stock->price;
            $user_id = $_SESSION['current_user_id'];
            $user = $se->getUsersById($user_id);
            $money = $user->money;
            //postoji li saldo za trenutnu dionicu
            $saldos = $se->getSaldosByUserId($user_id);
            $found_saldo = NULL;
            foreach ($saldos as $saldo) {
                if ($saldo->firm_id == $firm_id) {
                    $found_saldo = $saldo;
                    break;
                }
            }
            if ($found_saldo !== NULL) {
                if ($found_saldo->total_amount >= $amount) {

                    $money += $amount * $price;
                    $user->money = $money;
                    $transaction = new Transaction(NULL, $stock->id, $user_id, $amount, 0, NULL);
                    $found_saldo->total_amount -= $amount;
                    $se->insertSaldo($found_saldo);
                    $se->insertUser($user);
                    $se->insertTransaction($transaction);
                    $this->index();

                } else {
                    $this->registry->template->error_msg = "You don't have enough funds!";
                    $this->registry->template->firm_id = $firm_id;
                    $firm = $se->getFirmsById($firm_id);

                    $this->registry->template->firm_name = $firm->name;
                    $this->registry->template->show('stocks_prodaj');
                }
            } else {

                if ($amount != 0) {
                    //nema dovoljno dionica..
                    $this->registry->template->error_msg = "You don't have enough stocks!";
                    $this->registry->template->firm_id = $firm_id;
                    $firm = $se->getFirmsById($firm_id);

                    $this->registry->template->firm_name = $firm->name;
                    $this->registry->template->show('stocks_prodaj');
                }
            }
        } else {
            $firm_id = $_GET['firm_id'];
            $firm_name = $_GET['firm_name'];
            $this->registry->template->firm_id = $firm_id;
            $this->registry->template->firm_name = $firm_name;
            $this->registry->template->show('stocks_prodaj');
        }
    }
}


?>
