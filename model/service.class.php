<?php

class Service {
    //---------------users--------------------------
    function getUsersById($id){
        try{
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT id, username, email, money FROM users WHERE id=:id' );
            $st->execute( array( 'id' => $id ) );
	}catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

	$row = $st->fetch();
	if( $row === false ){
            return null;
        }
        else{
            return new User( $row['id'], $row['username'], $row['email'], $row['money'] );
        }
    }
    
    function getAllUsers(){
        try{
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT id, username, email, money FROM users ORDER BY username' );
            $st->execute();
	}catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

	$arr = array();
        while($row=$st->fetch()){
            $arr[] = new User( $row['id'], $row['username'], $row['email'], $row['money'] );
        }
        
        return $arr;
    }
    
    function insertUser($user){
        if(is_a($user, 'User')){
            try{
                $db = DB::getConnection();
                $st = $db->prepare("INSERT INTO user (id, username, email, money) "
                        . "VALUES (".$user['id'].",".$user['username'].",".$user['email'].",".$user['money'].")");
                $st->execute();
            }catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
        }else{
            exit('expected variable is not User');
        }        
    }
    //---------------firms--------------------------
    function getFirmsById($id){
        try{
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT id, symbol, name FROM firms WHERE id=:id' );
            $st->execute( array( 'id' => $id ) );
	}catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

	$row = $st->fetch();
	if( $row === false ){
            return null;
        }
        else{
            return new Firm( $row['id'], $row['symbol'], $row['name'] );
        }
    }
    
    function getFirmsBySymbol($symbol){
        try{
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT id, symbol, name FROM firms WHERE symbol=:symbol' );
            $st->execute( array( 'symbol' => $symbol ) );
	}catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

	$row = $st->fetch();
	if( $row === false ){
            return null;
        }
        else{
            return new Firm( $row['id'], $row['symbol'], $row['name'] );
        }
    }
    
    function getAllFirms(){
        try{
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT id, symbol, name FROM firms ORDER BY name' );
            $st->execute();
	}catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

	$arr = array();
        while($row=$st->fetch()){
            $arr[] = new Firm( $row['id'], $row['symbol'], $row['name'] );
        }
        
        return $arr;
    }
    
    //---------------transactions--------------------------
    function getTransactionsById($id){
        try{
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT id, stock_id, user_id, amount, buying FROM transactions WHERE id=:id' );
            $st->execute( array( 'id' => $id ) );
	}catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

	$row = $st->fetch();
	if( $row === false ){
            return null;
        }
        else{
            return new Transaction( $row['id'], $row['stock_id'], $row['user_id'], $row['amount'], $row['buying'] );
        }
    }
    
    function getTransactionsByUserId($user_id){
        try{
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT id, stock_id, user_id, amount, buying FROM transactions WHERE user_id=:user_id ORDER BY id' );
            $st->execute( array( 'user_id' => $user_id ) );
	}catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

	$arr = array();
        while($row=$st->fetch()){
            $arr[] = new Transaction( $row['id'], $row['stock_id'], $row['user_id'], $row['amount'], $row['buying'] );
        }
        
        return $arr;
    }
    
    function getAllTransactions(){
        try{
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT id, stock_id, user_id, amount, buying FROM transactions ORDER BY id' );
            $st->execute();
	}catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

	$arr = array();
        while($row=$st->fetch()){
            $arr[] = new Transaction( $row['id'], $row['stock_id'], $row['user_id'], $row['amount'], $row['buying'] );
        }
        
        return $arr;
    }
    
    function insertTransaction($transaction){
        if(is_a($transaction, 'Transaction')){
            try{
                $db = DB::getConnection();
                $st = $db->prepare("INSERT INTO transactions (stock_id, user_id, amount, buying) "
                        . "VALUES (".$transaction['stock_id'].",".$transaction['user_id'].",".$transaction['amount'].",".$transaction['buying'].")");
                $st->execute();
            }catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
        }else{
            exit('expected variable is not Transaction');
        }
    }
    
    //---------------stocks--------------------------
    function getStocksById($id){
        try{
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT id, firm_id, date, price, volume, dividend FROM stocks WHERE id=:id ORDER BY date DESC' );
            $st->execute( array( 'id' => $id ) );
	}catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

	$row = $st->fetch();
	if( $row === false ){
            return null;
        }
        else{
            return new Stock( $row['id'], $row['firm_id'], $row['date'], $row['price'], $row['volume'], $row['dividend'] );
        }
    }
    
    function getStocksByFirmId($firm_id){
        try{
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT id, firm_id, date, price, volume, dividend FROM stocks WHERE firm_id=:firm_id ORDER BY date DESC' );
            $st->execute( array( 'firm_id' => $firm_id ) );
	}catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

	$arr = array();
        while($row=$st->fetch()){
            $arr[] = new Stock( $row['id'], $row['firm_id'], $row['date'], $row['price'], $row['volume'], $row['dividend'] );
        }
        
        return $arr;
    }
    
    function getStocksByFirmIdLastest($firm_id){
        try{
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT id, firm_id, date, price, volume, dividend FROM stocks WHERE firm_id=:firm_id ORDER BY date DESC LIMIT 1' );
            $st->execute( array( 'firm_id' => $firm_id ) );
	}catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

	$row = $st->fetch();
	if( $row === false ){
            return null;
        }
        else{
            return new Stock( $row['id'], $row['firm_id'], $row['date'], $row['price'], $row['volume'], $row['dividend'] );
        }
    }
    
    //---------------saldos--------------------------
    function getAllSaldos(){
        try{
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT id, user_id, stock_id, total_amount FROM saldos' );
            $st->execute();
	}catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

	$arr = array();
        while($row=$st->fetch()){
            $arr[] = new Saldo( $row['id'], $row['user_id'], $row['stock_id'], $row['total_amount'] );
        }
        
        return $arr;
    }
    
    function getSaldosById($id){
        try{
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT id, user_id, stock_id, total_amount FROM saldos WHERE id=:id' );
            $st->execute( array( 'id' => $id ) );
	}catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
        
        $row = $st->fetch();
	if( $row === false ){
            return null;
        }
        else{
            return new Saldo( $row['id'], $row['user_id'], $row['stock_id'], $row['total_amount'] );
        }
    }
    
    function getSaldosByUserId($user_id){
        try{
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT id, user_id, stock_id, total_amount FROM saldos WHERE user_id=:user_id ORDER BY total_amount' );
            $st->execute( array( 'user_id' => $user_id ) );
	}catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

	$arr = array();
        while($row=$st->fetch()){
            $arr[] = new Saldo( $row['id'], $row['user_id'], $row['stock_id'], $row['total_amount'] );
        }
        
        return $arr;
    }
    
    function getSaldosByStockId($stock_id){
        try{
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT id, user_id, stock_id, total_amount FROM saldos WHERE stock_id=:stock_id ORDER BY total_amount' );
            $st->execute( array( 'stock_id' => $stock_id ) );
	}catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

	$arr = array();
        while($row=$st->fetch()){
            $arr[] = new Saldo( $row['id'], $row['user_id'], $row['stock_id'], $row['total_amount'] );
        }
        
        return $arr;
    }
    
    function insertSaldo($saldo){
        if(is_a($saldo, 'Saldo')){
            try{
                $db = DB::getConnection();
                $st = $db->prepare("INSERT INTO saldos (user_id, stock_id, total_amount) "
                        . "VALUES (".$saldo['user_id'].",".$saldo['stock_id'].",".$saldo['total_amount'].")");
                $st->execute();
            }catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
        }else{
            exit('expected variable is not Saldo');
        }
    }
};

?>

