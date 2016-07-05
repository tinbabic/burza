<?php
    require_once '_header.php';?>

<script type="text/javascript" src="https://d3js.org/d3.v4.min.js"></script>
<script type="text/javascript" src="<?php echo __SITE_URL;?>/js/chart.js"></script>
<style>
    .line {
      fill: none;
      stroke: steelblue;
      stroke-width: 2px;
      clip-path: url(#clip);
    }
    .brush .extent {
      stroke: #fff;
      fill-opacity: .125;
      shape-rendering: crispEdges;
    }
</style>

<div class="title">
    <h1>Stock history of <?php echo $name;?></h1>
</div>
<div class="content">
    <p>
    <table>
        <tr><th>Price</th> <th>Previous price</th> <th>Change</th> <th>7 days low</th> <th>7 days high</th> <th>Ex dividend date</th> <th>Dividend</th></tr>
        <tr><td><?php echo $newPrice;?></td> <td><?php echo $lastPrice;?></td> <td><?php echo $changePrevious;;?></td> <td><?php echo $low;?></td> <td><?php echo $high;?></td> <td><?php echo $exDivDate;?></td> <td><?php echo $dividend;?></td></tr>
    </table> <br>

<?php
    echo '<script> var dataset = [';
    $lastKey = end(array_keys($dataset));
    foreach($dataset as $date=>$values){
        echo '{date:"'.$date.'", close:"'.$values[0].'",volume:"'.$values[1].'",dividend:"'.$values[2].'"}';
        if ($date != $lastKey) {
            echo ', ';
        }
    }
    echo ']</script>';
?>
    


<script>drawChart();</script>

</p>
</div>

<?php require_once '_footer.php';?>