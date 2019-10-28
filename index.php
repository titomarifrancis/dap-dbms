<?php
include 'templates/header.php';
?>
<p>
Through the EO No. 605, the Development Academy of the Philippines has been promoting and enhancing capabilities of the government in establishing, implementing and sustaining a Quality Management System certified to ISO 9001.
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
		yValueFormatString: "##0.00'%'",
		indexLabel: "{label} {y}",
		dataPoints: [
			{y: <?php echo $uncertPercentage;?>, label: "Uncertified"},
<?php
for($a=0; $a < $chartDataSize; $a++)
{
    $categoryName = $chartDataArray[$a]->categoryName;
    $categoryCertCount = $chartDataArray[$a]->agencyCertifiedCount;
    $categoryCertPercentage = number_format(($categoryCertCount/$totalAgencyCount)*100, 2);
?>
			{y: <?php echo $categoryCertPercentage;?>, label: "<?php echo $categoryName;?>"},
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