<?php


class SaldosController extends BaseController {
    //dohvaca sve dionice za trenutno logiranog korisnika i za njih nalazi imena firmi
    //salje ih viewu na prikazivanje
    public function index() {
        $se = new Service();
        $user_id = $_SESSION['current_user_id'];
        $userStocks = $se->getSaldosByUserId($user_id);
        $firm_names = array();
        foreach($userStocks as $user_stock) {
            //da bi u view-u imali imena firmi jer je to prirodnije za pokazat
            //ovdje spremam u polje p[stock_id]=ime_firme
            $firm = $se->getFirmsById($user_stock->firm_id);
            $firm_names[$user_stock->firm_id] = $firm->name;
        }
        $this->registry->template->userStocks = $userStocks;
        $this->registry->template->firm_names = $firm_names;
        $this->registry->template->show('saldos_index');
    }
}

?>
