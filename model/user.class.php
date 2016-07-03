<?php


class User {
    protected $id, $username, $email, $money;

    function __construct( $id, $username, $email, $money ){
		$this->id = $id;
                $this->username = $username;
                $this->email = $email;
                $this->money = $money;
    }
    function __get( $prop ) { return $this->$prop; }
    function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}
