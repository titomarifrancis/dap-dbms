<?php
include 'templates/headerin.php';
include 'dbconn.php';

?>
<form enctype="multipart/form-data">
  <div class="row">
    <div class="large-12 columns">
		<label>Region
			<select>
<?php
$getRegion=  'select id, regionname from regions order by regionname';
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
		<label>Province
			<select>
<?php
$getRegion=  'select id, provincename from provinces order by provincename';
$getRegionStmt= $dbh->query($getRegion);

foreach($getRegionStmt as $regionRow)
{
?>
    //
                <option value="<?php echo rtrim($regionRow['id']);?>"><?php echo rtrim($regionRow['provincename']);?></option>
<?php
}
?>            
            </select>
		</label>
	</div>
    <div class="large-12 columns">
        <input type="text" name="govtagencydesc" placeholder="District or Division Name">
    </div>
    <div class="large-12 columns">
        <input type="submit" class="button expand" value="Save to Add"/>
    </div>          
</form>            
<?
include 'templates/footer.php';