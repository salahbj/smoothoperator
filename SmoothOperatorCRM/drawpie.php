<?
require "header.php";
/*$result = mysqli_query($connection, "SELECT unix_timestamp(concat(report_date,' ',report_time)) as date, new, answered, busy, congested, amd, unknown, pressed1, hungup, timeout FROM campaign_stats WHERE campaign_id = 100002") or die(mysqli_error($connection));
$text = "";
while ($row = mysqli_fetch_assoc($result)) {
    $text .= "[".$row['date'].",  ".$row['new'].",".$row['answered'].",".$row['busy'].",".$row['congested'].",".$row['amd'].",".$row['unknown'].",".$row['pressed1'].",".$row['hungup'].",".$row['timeout']."],<br />";
}
echo substr($text,0,-1);
exit(0);*/
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawChart);
function drawChart() {
    var data = google.visualization.arrayToDataTable
    ([
     ['Date', 'Timeout', 'Answered', 'Busy', 'Congested', 'Answer Machine', 'Unknown', 'New'],
     <?
     $result = mysqli_query($connection, "SELECT (concat(report_date,' ',report_time)) as date, new, answered, busy, congested, amd, unknown, pressed1, hungup, timeout FROM campaign_stats WHERE campaign_id = 100003") or die(mysqli_error($connection));
     $text = "";
     while ($row = mysqli_fetch_assoc($result)) {
        $text .= "['".$row['date']."',  ".$row['timeout'].",".($row['answered']+$row['pressed1']+$row['hungup']).",".$row['busy'].",".$row['congested'].",".$row['amd'].",".$row['unknown'].",".$row['new']."],";
     }
     echo substr($text,0,-1);
     ?>
     ]);
    
    var options = {
    title: 'Number Status',
    areaOpacity: 1,
    colors: ['#444444','#88ff88','#0000ff','#ff0000','#ffff00','#888888','#eeffee'],
    isStacked: true,
    hAxis: {title: 'Year',  titleTextStyle: {color: 'red'}}
    };
    
    var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
    chart.draw(data, options);
}
</script>
<div id="chart_div" style="width: 900px; height: 500px;"></div>
<?
require "footer.php";
?>