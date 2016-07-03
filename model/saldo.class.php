<?php


class Saldo {
    protected $id, $user_id, $stock_id, $total_amount;

    function __construct($id, $user_id, $stock_id, $total_amount ){
		$this->id = $id;
		$this->user_id = $user_id;
                $this->stock_id = $stock_id;
                $this->total_amount = $total_amount;
    }
    function __get( $prop ) { return $this->$prop; }
    function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}
