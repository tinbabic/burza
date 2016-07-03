<?php


class Firm {
    protected $id, $symbol, $name;

    function __construct($id, $symbol, $name){
		$this->id = $id;
		$this->symbol = $symbol;
                $this->name = $name;
    }
    function __get( $prop ) { return $this->$prop; }
    function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}
