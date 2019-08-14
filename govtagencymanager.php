<?php
include 'templates/headerin.php';
include 'dbconn.php';

//this is to manage the content of Govt Agency Class table
?>
<form enctype="multipart/form-data">
  <div class="row">
    <div class="large-12 columns">
		<label>Government Agency Category
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
    $getGovtAgencyClass=  'select id, agencyclassdesc from govtagencyclass order by agencyclassdesc';
//}
$govtAgencyClassStmt= $dbh->query($getGovtAgencyClass);

foreach($govtAgencyClassStmt as $govtAgencyClassRow)
{
?>
    //
                <option value="<?php echo rtrim($govtAgencyClassRow['id']);?>"><?php echo rtrim($govtAgencyClassRow['agencyclassdesc']);?></option>
<?php
}
?>            
            </select>
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