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
            //prebroji usere sa username
            try{
                $db = DB::getConnection();
                $st = $db->prepare("SELECT EXISTS (SELECT * FROM users WHERE username = '".$user->username."')");
                $st->execute();
            } catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
            
            //ako ne postoji taj user unesi novi
            $tmo = $st->fetch();
            if($tmo[0] == 0){
                try{
                    $db = DB::getConnection();
                    $st = $db->prepare("INSERT INTO users (id, username, email, money, has_registered) "
                            . "VALUES (".$user->id.",".$user->username.",".$user->email.",".$user->money.", 1)");
                    $st->execute();
                }catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
            } else{ //inace modificiraj postojeci
                try{
                    $db = DB::getConnection();
                    $st = $db->prepare("UPDATE users SET money='".$user->money."', email='".$user->email."'"
                            . "WHERE username='".$user->username."'");
                    $st->execute();
                }catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
            }
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
            $st = $db->prepare( 'SELECT id, stock_id, user_id, amount, buying, date FROM transactions WHERE id=:id' );
            $st->execute( array( 'id' => $id ) );
	}catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

	$row = $st->fetch();
	if( $row === false ){
            return null;
        }
        else{
            return new Transaction( $row['id'], $row['stock_id'], $row['user_id'], $row['amount'], $row['buying'],  $row['date']);
        }
    }
    
    function getTransactionsByUserId($user_id){
        try{
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT id, stock_id, user_id, amount, buying, date FROM transactions WHERE user_id=:user_id ORDER BY id' );
            $st->execute( array( 'user_id' => $user_id ) );
	}catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

	$arr = array();
        while($row=$st->fetch()){
            $arr[] = new Transaction( $row['id'], $row['stock_id'], $row['user_id'], $row['amount'], $row['buying'], $row['date'] );
        }
        
        return $arr;
    }
    
    function getAllTransactions(){
        try{
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT id, stock_id, user_id, amount, buying, date FROM transactions ORDER BY id' );
            $st->execute();
	}catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

	$arr = array();
        while($row=$st->fetch()){
            $arr[] = new Transaction( $row['id'], $row['stock_id'], $row['user_id'], $row['amount'], $row['buying'], $row['date'] );
        }
        
        return $arr;
    }
    
    function insertTransaction($transaction){
        if(is_a($transaction, 'Transaction')){
            try{
                $db = DB::getConnection();
                $st = $db->prepare("INSERT INTO transactions (stock_id, user_id, amount, buying, date) "
                        . "VALUES (".$transaction->stock_id.",".$transaction->user_id.",".$transaction->amount.",".$transaction->buying.",".$transaction->date.")");
                $st->execute();
            }catch( PDOException $e ) { exit( 'PDO error insertTransaction ' . $e->getMessage() ); }
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
    
    function getStocksByFirmId2ndLastest($firm_id){
        try{
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT id, firm_id, date, price, volume, dividend FROM stocks WHERE firm_id=:firm_id ORDER BY date DESC LIMIT 2,1' );
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
            $st = $db->prepare( 'SELECT id, user_id, firm_id, total_amount FROM saldos' );
            $st->execute();
	}catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

	$arr = array();
        while($row=$st->fetch()){
            $arr[] = new Saldo( $row['id'], $row['user_id'], $row['firm_id'], $row['total_amount'] );
        }
        
        return $arr;
    }
    
    function getSaldosById($id){
        try{
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT id, user_id, firm_id, total_amount FROM saldos WHERE id=:id' );
            $st->execute( array( 'id' => $id ) );
	}catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
        
        $row = $st->fetch();
	if( $row === false ){
            return null;
        }
        else{
            return new Saldo( $row['id'], $row['user_id'], $row['firm_id'], $row['total_amount'] );
        }
    }
    
    function getSaldosByUserId($user_id){
        try{
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT id, user_id, firm_id, total_amount FROM saldos WHERE user_id=:user_id ORDER BY total_amount' );
            $st->execute( array( 'user_id' => $user_id ) );
	}catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

	$arr = array();
        while($row=$st->fetch()){
            $arr[] = new Saldo( $row['id'], $row['user_id'], $row['firm_id'], $row['total_amount'] );
        }
        
        return $arr;
    }
    
    function getSaldosByFirmId($firm_id){
        try{
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT id, user_id, firm_id, total_amount FROM saldos WHERE firm_id=:firm_id ORDER BY total_amount' );
            $st->execute( array( 'firm_id' => $firm_id ) );
	}catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

	$arr = array();
        while($row=$st->fetch()){
            $arr[] = new Saldo( $row['id'], $row['user_id'], $row['firm_id'], $row['total_amount'] );
        }
        
        return $arr;
    }
    
    function insertSaldo($saldo)
    {
        if (is_a($saldo, 'Saldo')) {
            //prebroji usere sa username
            try {
                $db = DB::getConnection();
                $st = $db->prepare("SELECT EXISTS (SELECT * FROM saldos WHERE user_id = '" . $saldo->user_id . "'"
                    . " AND firm_id = '" . $saldo->firm_id . "')");
                $st->execute();
            } catch (PDOException $e) {
                exit('PDO error ' . $e->getMessage());
            }
            $tmo = $st->fetch();

            if ($tmo[0] == 0) {
                try {
                    $db = DB::getConnection();
                    $st = $db->prepare("INSERT INTO saldos (user_id, firm_id, total_amount) "
                        . "VALUES (" . $saldo->user_id . "," . $saldo->firm_id . "," . $saldo->total_amount . ")");
                    $st->execute();
                } catch (PDOException $e) {
                    exit('PDO error ' . $e->getMessage());
                }
            } else {
                try {
                    $db = DB::getConnection();
                    $st = $db->prepare("UPDATE saldos SET user_id='" . $saldo->user_id . "', firm_id='" . $saldo->firm_id . "', total_amount='" . $saldo->total_amount . "'
                            WHERE user_id = '" . $saldo->user_id . "' AND firm_id = '" . $saldo->firm_id . "'");
                    $st->execute();
                } catch (PDOException $e) {
                    exit('PDO1111 error ' . $e->getMessage());
                }
            }

        } else {
            exit('expected variable is not Saldo');
        }
    }
};

?>

