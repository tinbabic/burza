<?php


class FirmsController extends BaseController {
    //dohvaca podatke za sve firme i salje ih viewu gdje se ispisuju
    public function index() {
        $se = new Service();
        $firms = $se->getAllFirms();
        $this->registry->template->firms = $firms;
        $this->registry->template->show('firms_index');
    }
}
