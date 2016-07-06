<!DOCTYPE html>
<html>
<head>
<meta charset="utf8">
<title>updateDatabase</title>
</head>
<body>
<?php
    //spoji se na bazu
    require_once '../../model/db.class.php';

    $db = DB::getConnection();
    
    //dohvaca popis firma, promjeni per page na max do 100 da dohvatis max 100 firmi
    $json_string=file_get_contents('https://www.quandl.com/api/v3/datasets.json?database_code=WIKI&per_page=2&sort_by=id&page=1&api_key=eXH7ZKvysR6xus4NxGSi');
    $arr = json_decode($json_string, TRUE);

    //za svaku firmu upisujem u bazu
    foreach($arr['datasets'] as $dataset) {
        $code = $dataset['dataset_code'];
        echo $code . ' - dataset_code<br>';
        
        //upisi u bazu
        try{
            $st = $db->prepare("INSERT INTO firms (symbol, name)
              SELECT * FROM (SELECT '".$code."', '".$dataset['name']."') AS tmp
              WHERE NOT EXISTS (
              SELECT symbol FROM firms WHERE symbol = '".$code."'
              ) LIMIT 1");
            $st->execute();
        }catch( PDOException $e ) { echo 'Greška:' . $e->getMessage(); return; }
        
        //dohvati iz baze id firme
        try{
            $st= $db->prepare("SELECT id FROM firms WHERE symbol='".$code."'"); 
            $st->execute();
        } catch( PDOException $e ) { echo 'Greška:' . $e->getMessage(); return; }
        $firm_id=$st->fetch();
        echo $firm_id[0] . ' firm_id<br>';
        
        //dohvaca sve informacije o svakoj firmi tj povijest
        $json_string=file_get_contents('https://www.quandl.com/api/v3/datasets/WIKI/'.$code.'.json?api_key=eXH7ZKvysR6xus4NxGSi');
        $tmp = json_decode($json_string, TRUE);
        
        echo '<br>name: '.$tmp['dataset']['name'].'<br>';
        foreach($tmp['dataset']['data'] as $data){
            //$data[0] je datum
            //$data[4] je cijena
            //$data[5] je količina
            //$data[6] je dividenda
            
            //ako nije prazan jer api može imat greške
            if($data[4] != NULL) {
                echo $data[0].': '.$data[4].'<br>';
                
                //unesi u bazu, ali i provjerava da li postoji taj unos
                /*
                try{
                    $st = $db->prepare( "INSERT INTO stocks (firm_id, date, price, volume, dividend)
                    SELECT * FROM (SELECT '".$firm_id[0]."', '".$data[0]."', '".$data[4]."', '".$data[5]."', '".$data[6]."') AS tmp
                    WHERE NOT EXISTS (
                    SELECT firm_id, date FROM stocks WHERE firm_id = '".$firm_id[0]."' AND date='".$data[0]."'
                    ) LIMIT 1" );
                    $st->execute();
                }catch( PDOException $e ) { echo 'Greška:' . $e->getMessage(); return; }*/
                try{
                    $db = DB::getConnection();
                    $st = $db->prepare("SELECT EXISTS (SELECT * FROM stocks WHERE firm_id = '".$firm_id[0]."' AND date='".$data[0]."')");
                    $st->execute();
                } catch( PDOException $e ) { exit( 'PDO error select' . $e->getMessage() ); }

                
                $tmo = $st->fetch();
                if($tmo[0] == 0){
                    try{
                        $db = DB::getConnection();
                        $st = $db->prepare("INSERT INTO stocks (firm_id, date, price, volume, dividend) "
                                . "VALUES ('".$firm_id[0]."', '".$data[0]."', '".$data[4]."', '".$data[5]."', '".$data[6]."')");
                        $st->execute();
                    }catch( PDOException $e ) { exit( 'PDO error insert ' . $e->getMessage() ); }
                }
            }
        }
    }
?>
</body>
</html>
