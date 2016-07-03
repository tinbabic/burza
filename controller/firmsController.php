<?php


class FirmsController extends BaseController {
    public function index() {
    
    }
    //ispisuje sve firme
    public function showFirms(){
        $se = new Service();
        
        $firms = $se->getAllFirms();
        
        //skripta za ispis firmi
        require 'allFirms.php';
    }
}
