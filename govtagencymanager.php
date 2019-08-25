<?php
include 'templates/headerin.php';
include 'dbconn.php';

//this is to manage the content of Govt Agency Class table
?>
<h3>Government Agency Manager</h3>
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
	<?php
	$getRegionsQuery = 'select id, regionname from regions order by regionname asc';
	$regionStmt= $dbh->query($getRegionsQuery);
	?>
		<label>Region
		  <select name="regionid">
		  	<option value="" selected>N/A</option>		  
	<?php
	foreach($regionStmt as $regionRow)
	{
	?>
			<option value="<?php echo $regionRow['id'];?>"><?php echo rtrim($regionRow['regionname']);?></option>
	<?php
	}
	?>
		  </select>
		</label>
	  </div>
	  <div class="large-12 columns">
		<label>Province
		  <select name="provinceid">
		  	<option value="" selected>N/A</option>		  
			<option value="husker">Ilocos Norte</option>
			<option value="starbuck">Ilocos Sur</option>
			<option value="hotdog">La Union</option>
			<option value="apollo">Pangasinan</option>
		  </select>
		</label>
	  </div>
	  <div class="large-12 columns">
		<label>District/Division
		  <select name="distdivid">
		  	<option value="" selected>N/A</option>
			<option value="husker">District 1</option>
			<option value="starbuck">District 1</option>
		  </select>
		</label>
	  </div>
	  <div class="large-12 columns">
		<label>City/Municiplaity
		  <select name="citymunicipalityid">
		  	<option value="" selected>N/A</option>
			<option value="husker">Laoag</option>
			<option value="starbuck">Adams</option>
			<option value="hotdog">Bacarra</option>
			<option value="apollo">Bangui</option>
			<option value="starbuck">Carasi</option>
			<option value="hotdog">Dumalneg</option>
			<option value="apollo">Pasuquin</option>
			<option value="starbuck">Piddig</option>
			<option value="hotdog">Sarrat (San Miguel)</option>
			<option value="apollo">Vintar</option>
			<option value="starbuck">Burgos (Nagparitan)</option>
			<option value="hotdog">Pagudpud</option>
		
		  </select>
		</label>
	  </div>
	  <div class="large-12 columns">
		<label>Barangay
		  <select name="barangayid">
		  	<option value="" selected>N/A</option>
			<option value="husker">Barangay No. 1, San Lorenzo</option>
			<option value="starbuck">Barangay No. 2, Santa Joaquina</option>
			<option value="hotdog">Barangay No. 3, Nuestra Señora del Rosario</option>
			<option value="apollo">Barangay No. 4, San Guillermo</option>
		  </select>
		</label>
	  </div>

    <div class="large-12 columns">
        <label>Government Agency
        <input type="text" name="govtagencydesc" placeholder="Government Agency Name">
    </div>
    <div class="large-12 columns">
        <input type="submit" class="button expand" value="Save to Add"/>
    </div>          
</form>            
<?
include 'templates/footer.php';