<?php

//spoji se na bazu
require_once '../../model/db.class.php';

require_once '../../model/service.class.php';

$db = DB::getConnection();
    
//po svim symbol iz tablice firme
try{
    $st= $db->prepare("SELECT symbol, id FROM firms"); 
    $st->execute();
} catch( PDOException $e ) { echo 'Greška:' . $e->getMessage(); return; }
$symbolArr=$st->fetchAll();

$dividendArr = array();

//zapis u stocks
foreach($symbolArr as $symbol){
    //echo "<br>simbol ".$symbol[0];
    $json_string=file_get_contents('https://www.quandl.com/api/v3/datasets/WIKI/'.$symbol[0].'.json?api_key=eXH7ZKvysR6xus4NxGSi');
    $tmp = json_decode($json_string, TRUE);
    //echo '<br>name: '.$tmp['dataset']['name'].'<br>';
    //echo 'datum: '.$tmp['dataset']['data'][0][0].'<br>';
    
    $se = new Service();
    $lastest = $se->getStocksByFirmIdLastest($symbol[1]);
    
    if($tmp['dataset']['data'][0][6]>0 && $tmp['dataset']['data'][0][0] != $lastest['date']){
        $dividendArr[$symbol[1]] = $tmp['dataset']['data'][0][6];
    }
    try{
        $st = $db->prepare( "INSERT INTO stocks (firm_id, date, price, volume, dividend)
        SELECT * FROM (SELECT '".$symbol[1]."', '".$tmp['dataset']['data'][0][0]."', '".$tmp['dataset']['data'][0][4]."', '".$tmp['dataset']['data'][0][5]."', '".$tmp['dataset']['data'][0][6]."') AS tmp
        WHERE NOT EXISTS (
        SELECT firm_id, date FROM stocks WHERE firm_id = '".$symbol[1]."' AND date='".$tmp['dataset']['data'][0][0]."'
        ) LIMIT 1" );
        $st->execute();
    }catch( PDOException $e ) { echo 'Greška:' . $e->getMessage(); return; }
}


//isplata dividenda
foreach($dividendArr as $firm => $dividend){
    //po svim saldos
    $se = new Service();
    $saldoArr = $se->getAllSaldos();
    foreach($saldoArr as $saldo){
        //iz saldos firm id
        $firmId = $saldo['firm_id'];
        //provjeri firm_id==firm
        if($firmId == $firm){
            //u users(user_id) money+=dividend*amount i zapis u users
            $user = $se->getUsersById($saldo['user_id']);
            $user['money'] += $dividend * $saldo['total_amount'];
            $se->insertUser($user);
        }
        
    }
} 
    
?>
