<?php
    require_once '_header.php';?>

<h2> Povijest dionice: <?php echo $name;?></h2>
        
<?php
    echo '<script> var data = [';
    $lastKey = end(array_keys($data));
    foreach($data as $date=>$values){
        echo '{date:"'.$date.'", close:"'.$values[0].'",volume:"'.$values[1].'",dividend:"'.$values[2].'"}';
        if ($date != $lastKey) {
            echo ', ';
        }
    }
    echo ']</script>';

    require_once '_footer.php';
?>