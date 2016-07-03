<?php


class FirmsController extends BaseController {
    public function index() {
        $se = new Service();
        $firms = $se->getAllFirms();
        $this->registry->template->firms = $firms;
        $this->registry->template->show('firms_index');
    }
    //ispisuje sve firme
    public function showFirms(){
        $se = new Service();
        
        $firms = $se->getAllFirms();
        
        //skripta za ispis firmi
        require 'allFirms.php';
    }
}
