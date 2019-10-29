<?php
include 'templates/header.php';
include 'dbconn.php';

$getLastActiveCertDate = "select distinct approveddate from agencycertifications where isexpired=false and isapproved=true order by approveddate desc limit 1";
$lastActiveCertdateArray = $dbh->query($getLastActiveCertDate)->fetchAll();
//print_r($lastActiveCertdateArray);
$rawDateStamp = $lastActiveCertdateArray[0]['approveddate'];
//echo "$rawDateStamp<br/>";
$dateStamp = date("j M Y", strtotime($rawDateStamp));
//echo "$dateStamp<br/>";
?>
<p>
Through the EO No. 605, the Development Academy of the Philippines has been promoting and enhancing capabilities of the government in establishing, implementing and sustaining a Quality Management System certified to ISO 9001.
</p>
<br/>
<h3>ISO 9001 Certification in the Government</h3>
<p>
The following pie chart shows the ISO 9001 certification in the government as of <?php echo $dateStamp;?>
</p>
<?php
include 'lib/getChartData.php';
$chartData = json_decode($chartJson);

$totalAgencyCount = $chartData[0]->agencyTotalCount;
$totalUncertified = $chartData[0]->uncertTotalCount;
$uncertPercentage = number_format(($totalUncertified/$totalAgencyCount)*100, 2);
$chartDataArray = $chartData[0]->categoryCertStats;
$chartDataSize = sizeof($chartDataArray);
?>
<br/>
<div id="chartContainer" style="height: 400px; max-width: 800px; margin: 0px auto;">
</div>
<script>

window.onload = function() {

var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	title: {
		text: ""
	},
	data: [{
		type: "pie",
		startAngle: 240,
		yValueFormatString: "(##0.00'%')",
		indexLabel: "{label} {y}",
		dataPoints: [
			{y: <?php echo $uncertPercentage;?>, label: "Uncertified = <?php echo $totalUncertified;?>"},
<?php
for($a=0; $a < $chartDataSize; $a++)
{
    $categoryName = $chartDataArray[$a]->categoryName;
    $categoryCertCount = $chartDataArray[$a]->agencyCertifiedCount;
	$categoryCertPercentage = number_format(($categoryCertCount/$totalAgencyCount)*100, 2);
	$label = "".$categoryName." = ".$categoryCertCount."";
?>
			{y: <?php echo $categoryCertPercentage;?>, label: "<?php echo $label;?>"},
<?php
}
?>
		]
	}]
});
chart.render();

}
</script>
<?php
include 'templates/footer.php';