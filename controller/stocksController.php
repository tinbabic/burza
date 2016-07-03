<?php


class StocksController extends BaseController {
    public function index() {
    
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
