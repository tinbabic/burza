<?php


class Saldo {
    protected $id, $user_id, $stock_id, $total;

    function __construct($id, $user_id, $stock_id, $total ){
		$this->id = $id;
		$this->user_id = $user_id;
                $this->stock_id = $stock_id;
                $this->total = $total;
    }
    function __get( $prop ) { return $this->$prop; }
    function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}
