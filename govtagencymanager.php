<?php
include 'templates/headerin.php';
include 'dbconn.php';
//this is to manage the content of Govt Agency table
?>
<h3>Government Agency Manager</h3>
<form action="govtagency_processor.php" method="post">
  <div class="row">
    <div class="large-12 columns">
		<label>Government Agency Category
			<select id="govtagencyclassid" name="govtagencyclassid">
<?php
$getGovtAgencyClass=  'select id, agencyclassdesc from govtagencyclass order by agencyclassdesc';
$govtAgencyClassStmt= $dbh->query($getGovtAgencyClass);

foreach($govtAgencyClassStmt as $govtAgencyClassRow)
{
?>
                <option value="<?php echo rtrim($govtAgencyClassRow['id']);?>"><?php echo rtrim($govtAgencyClassRow['agencyclassdesc']);?></option>
<?php
}
?>            
            </select>
		</label>
	</div>
  <div class="large-12 columns">
    <label>Parent Government Agency
      <select id="parentgovtagencyid" name="parentgovtagencyid">
        <option value="0">N/A</option>
<?php
$getGovtAgency=  'select id, agencyname from govtagency order by agencyname';
$govtAgencyStmt= $dbh->query($getGovtAgency);

foreach($govtAgencyStmt as $govtAgencyRow)
{
?>
        <option value="<?php echo rtrim($govtAgencyRow['id']);?>"><?php echo rtrim($govtAgencyRow['agencyname']);?></option>
<?php
}
?>            
      </select>
		</label>
	</div>  
    <div class="large-12 columns">
        <label>Government Agency
        <input type="text" name="agencyname" placeholder="Government Agency Name">
    </div>
    <div class="large-12 columns">
        <input type="submit" class="button expand" value="Save"/>
    </div>
	</div>          
</form>
<br/>
<div>

</div>            
<?
include 'templates/footer.php';