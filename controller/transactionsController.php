<?php


class TransactionsController extends BaseController {
    public function index() {
        $user_id = $_SESSION['current_user_id'];
        $se = new Service();
        $transactions = $se->getTransactionsByUserId($user_id);
        $stock_ids_tmp = array();
        foreach($transactions as $t) {
            $stock_ids_tmp[] = $t->stock_id;
        }
        $stock_ids = array_unique($stock_ids_tmp);
        $firm_names = array();
        foreach($stock_ids as $s_id) {
            //da bi u view-u imali imena firmi jer je to prirodnije za pokazat
            //ovdje spremam u polje p[stock_id]=ime_firme
            $stock = $se->getStocksById($s_id);
            $firm = $se->getFirmsById($stock->firm_id);
            $firm_names[$s_id] = $firm->name;
        }

        $this->registry->template->transactions = $transactions;
        $this->registry->template->firm_names = $firm_names;
        $this->registry->template->show('transactions_index');
    
    }

}
