<?php
include 'templates/headerin.php';
include 'dbconn.php';

//this is to manage the content of Govt Agency Class table
?>
<h3>Certification Manager</h3>
<form enctype="multipart/form-data">
  <div class="row">
    <div class="large-12 columns">
		<label>List of ISO Certification
        <table class="scroll hover" style="table-layout:fixed">
            <thead>
                <tr>
                    <th style="width: 100%">Agency Category</th>
                </tr>
            </thead>
            <tbody>
<?php
$getCertification=  'select id, certificationstandard from certifications order by certificationstandard';
$certificationStmt= $dbh->query($getCertification);

foreach($certificationStmt as $certificationRow)
{
?>
                <tr> 
                    <td><a href="<?php echo rtrim($certificationRow['id']);?>"><?php echo rtrim($certificationRow['certificationstandard']);?></a></td>
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