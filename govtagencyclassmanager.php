<?php
include 'templates/headerin.php';
include 'dbconn.php';

//this is to manage the content of Govt Agency Class table
?>
<h3>Government Agency Category Manager</h3>
<form enctype="multipart/form-data">
  <div class="row">
    <div class="large-12 columns">
		<label>Government Agency Category
        <table class="scroll hover" style="table-layout:fixed">
            <thead>
                <tr>
                    <th style="width: 100%">Agency Category</th>
                </tr>
            </thead>
            <tbody>
<?php
$getGovtAgencyClass=  'select id, agencyclassdesc from govtagencyclass order by agencyclassdesc';
$govtAgencyClassStmt= $dbh->query($getGovtAgencyClass);

foreach($govtAgencyClassStmt as $govtAgencyClassRow)
{
?>
                <tr> 
                    <td><a href="<?php echo rtrim($govtAgencyClassRow['id']);?>"><?php echo rtrim($govtAgencyClassRow['agencyclassdesc']);?></a></td>
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