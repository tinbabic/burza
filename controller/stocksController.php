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
            $trend = $latest_stock->price < $second->price;
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
        
        //iz sessiona ili nećeg drugog čita o kojoj firmi se radi
        if(true){
            $firm_id = 1;
        
            $history = $se->getStocksByFirmId($firm_id);
            //pozovi skriptu za ispis i/ili crtanje grafa
            require '../View/priceHistory.php';
        } else {
            require '../View/accessDenied.php';
        }
    }
}

?>
