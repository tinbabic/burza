<?php


class StocksController extends BaseController {
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
        
        //$_GET['firm_id']
        if(isset($_GET['firm_id'])){
            $firm_id = $_GET['firm_id'];
            //$firm_id = 9224;
            
            $firm = $se->getFirmsById($firm_id);
            $name = $firm->name;

            $arr = $se->getStocksByFirmId($firm_id);
            $data = array();
            foreach($arr as $stock){
                $data[$stock->date] = array($stock->price, $stock->volume, $stock->dividend);
            }

            $this->registry->template->data = $data;
            $this->registry->template->name = $name;

            $this->registry->template->show('stock_history');
        }
        
    }
}

?>
