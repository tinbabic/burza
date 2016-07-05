<?php
    require_once '_header.php';?>

<h2> Stock history of <?php echo $name;?></h2>

<div id="stockDiv">
    <p id="bigPrice"><?php echo $newPrice;?></p>
    <div><p>Previous price</p><p><?php echo $lastPrice;?></p></div>
    <div><p>Change</p><p><?php echo $changePrevious;?></p></div>
    <div><p>7 days low</p><p><?php echo $low;?></p></div>
    <div><p>7 days high</p><p><?php echo $high;?></p></div>
    <div><p>Ex dividend date</p><p><?php echo $exDivDate;?></p></div>
    <div><p>Dividend</p><p><?php echo $dividend;?></p></div>
</div>
        
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