<?php


class Stock {
    protected $id, $firm_id, $date, $price, $volume, $dividend;

    function __construct( $id, $firm_id, $date, $price, $volume, $dividend ){
		$this->id = $id;
		$this->firm_id = $firm_id;
                $this->date = $date;
                $this->price = $price;
                $this->volume = $volume;
                $this->dividend = $dividend;
    }
    function __get( $prop ) { return $this->$prop; }
    function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}
