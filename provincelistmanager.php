<?php
include 'templates/headerin.php';
include 'dbconn.php';

//this is to manage the content of Govt Agency Class table
?>
<h3>Province List Manager</h3>
<form enctype="multipart/form-data">
  <div class="row">
    <div class="large-12 columns">
		<label>Region
			<select>
<?php
/*
if(isset($govtAgencyId))
{
    //get the corresponding government agency class
    $getGovtAgencyClass= 'select id, agencyclassdesc from govtagencyclass, govtagency where govtagency.govtagencyclassid=govtagencyclass.id and govtagency.id=$govtAgencyId';
}
else
{
    */
    //get the list of government agency class/category
    $getRegion=  'select id, regionname from regions order by regionname';
//}
$getRegionStmt= $dbh->query($getRegion);

foreach($getRegionStmt as $regionRow)
{
?>
    //
                <option value="<?php echo rtrim($regionRow['id']);?>"><?php echo rtrim($regionRow['regionname']);?></option>
<?php
}
?>            
            </select>
		</label>
	</div>
    <div class="large-12 columns">
        <input type="text" name="govtagencydesc" placeholder="Province Name">
    </div>
    <div class="large-12 columns">
        <input type="submit" class="button expand" value="Save to Add"/>
    </div>          
</form>            
<?
include 'templates/footer.php';