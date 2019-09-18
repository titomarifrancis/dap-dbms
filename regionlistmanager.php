<?php
include 'templates/headerin.php';
include 'dbconn.php';

//this is to manage the content of Govt Agency Class table
?>
<h3>Region List Manager</h3>
<form enctype="multipart/form-data">
  <div class="row">
    <div class="large-12 columns">
		<!--<label>List of Regions-->
        <table class="scroll hover" style="table-layout:fixed">
            <thead>
                <tr>
                    <th style="width: 100%">List of Regions</th>
                </tr>
            </thead>
            <tbody>
<?php
$getRegion=  'select id, regionname from regions order by regionname';
$getRegionStmt= $dbh->query($getRegion);

foreach($getRegionStmt as $regionRow)
{
?>
                <tr> 
                    <td><a href="<?php echo rtrim($regionRow['id']);?>"><?php echo rtrim($regionRow['regionname']);?></a></td>
                </tr>
<?php
}
?>            
            </tbody>
        </table>
		</label>
	</div>
    <div class="large-12 columns">
        <input type="text" name="govtagencydesc" placeholder="Government Agency Name">
    </div>
    <div class="large-12 columns">
        <input type="submit" class="button expand" value="Save to Add"/>
    </div>          
</form>            
<?
include 'templates/footer.php';