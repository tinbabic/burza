
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Povijest dionice</title>
</head>

<body>
<h2>Dionica:<?php echo $name; ?></h2>
<p>
<?php
    $lastKey = end(array_keys($data));
    foreach($data as $date=>$values){
        echo '{date:"'.$date.'", close:"'.$values[0].'",volume:"'.$values[1].'",dividend:"'.$values[2].'"}';
        if ($date != $lastKey) {
            echo ', ';
        }
    }

?>
</p>
</body>
</html>