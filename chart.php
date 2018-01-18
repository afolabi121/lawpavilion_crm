<?php

include_once ("config.php");

$query = "SELECT DISTINCT state FROM `tbl_contact` where state !='' ORDER BY state";
$results = mysqli_query($connect,$query) or die(mysqli_error($connect));

$final = array();
$state = array();

while($row = mysqli_fetch_assoc($results)){
    $state['state']= $row['state'];
    $sql = mysqli_query($connect, "SELECT COUNT(id) as users FROM `tbl_contact` where state='{$row['state']}'");
    while($newRow = mysqli_fetch_assoc($sql)){
        $state['num'] = $newRow['users'];
    }
    $final[] = $state;
}
$ChartData= json_encode($final);

?>

<html>
<head>
    <link rel="stylesheet" href="morris.js-0.5.1/morris.css">
    <script src="js/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="morris.js-0.5.1/morris.min.js"></script>
</head>
<body>
<div id="chart" ></div>

</body>
</html>

<script>
    Morris.Bar({
        element : 'chart',
        data:<?php echo $ChartData ?>,
        xkey:'state',
        ykeys:['num'],
        labels:['Number of Customers'],
        barColors: ["#000000"],
        hideHover:'auto',
        stacked:true,
        gridTextSize: 9
    });
</script>