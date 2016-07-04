<?php
    $lastKey = end(array_keys($data));
    foreach($data as $date=>$values){
        echo '{date:"'.$date.'", close:"'.$values[0].'",volume:"'.$values[1].'",dividend:"'.$values[2].'"}';
        if ($date != $lastKey) {
            echo ', ';
        }
    }

?>