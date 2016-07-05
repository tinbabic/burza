<?php


class Transaction {
    protected $id, $stock_id, $user_id, $amount, $buying, $date;

    function __construct( $id, $stock_id, $user_id, $amount, $buying, $date ){
		$this->id = $id;
                $this->stock_id = $stock_id;
                $this->user_id = $user_id;
                $this->amount = $amount;
                $this->buying = $buying;
                $this->buying = $date;
    }
    function __get( $prop ) { return $this->$prop; }
    function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}
