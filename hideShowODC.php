<?php
include 'templates/headerin.php';
include 'dbconn.php';

//get agency name and ODC status
$agencyId = $_REQUEST['agencyid'];
$agencyCertId = $_REQUEST['certid'];

$getAgencyODC = "select id, agencyname, hideorigcertdate from govtagency where id=$agencyId";
$agencyOdcArray = $dbh->query($getAgencyODC)->fetchAll();
//print_r($agencyOdcArray);
//echo "<br/>";
//echo $agencyOdcArray[0]['hideorigcertdate'];
?>
<h3>Hide/Show Original Date of Certification</h3>
<div>
<form method="post" action="hideShowOdc_processor.php">
    <div class="row">
        <div class="large-12 columns">
            <label>Government Agency<br/>
                <input type="hidden" name="certId" value="<?php echo $agencyCertId;?>">
                <select name="govtagencyid" id="govtagencyField" required>
				    <option value="<?php echo $agencyOdcArray[0]['id'];?>"><?php echo $agencyOdcArray[0]['agencyname'];?></option>
                </select>
            </label>
        </div>
        <div class="large-12 columns">
            <label>Hide Original Certification Date
                <p>
<?php
if($agencyOdcArray[0]['hideorigcertdate'] != 1)
{
?>
					<input type="radio" name="hideorigcertdate" value="true"> True<br>
					<input type="radio" name="hideorigcertdate" value="false" checked> False<br>

<?php
}
else
{
?>
					<input type="radio" name="hideorigcertdate" value="true" checked> True<br>
					<input type="radio" name="hideorigcertdate" value="false"> False<br>

<?php
}
?>

				</p>
        </div>
        <div class="large-12 columns">
	  		<input type="submit" class="button expand" name="submit" value="Save">
	  </div>        
    </div>
</form>
</div>
<?php
include 'templates/footer.php';