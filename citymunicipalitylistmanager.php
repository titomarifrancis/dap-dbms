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

    $getProvince=  'select id, provincename from provinces order by provincename';
//}
$getProvinceStmt= $dbh->query($getProvince);

foreach($getProvinceStmt as $getProvinceRow)
{
?>
    //
                <option value="<?php echo rtrim($getProvinceRow['id']);?>"><?php echo rtrim($getProvinceRow['provincename']);?></option>
<?php
}
?>            
            </select>
		</label>
	</div>
    <div class="large-12 columns">
		<label>District/Division
			<select>
<?php

    $getDistdiv=  'select id, distdivname from distdivs order by distdivname';
//}
$getDistdivStmt= $dbh->query($getDistdiv);

foreach($getDistdivStmt as $distdivRow)
{
?>
    //
                <option value="<?php echo rtrim($distdivRow['id']);?>"><?php echo rtrim($distdivRow['distdivname']);?></option>
<?php
}
?>            
            </select>
		</label>
	</div>    
    <div class="large-12 columns">
        <input type="text" name="govtagencydesc" placeholder="City or Municipality Name">
    </div>
    <div class="large-12 columns">
        <input type="submit" class="button expand" value="Save to Add"/>
    </div>          
</form>            
<?
include 'templates/footer.php';