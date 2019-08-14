<?php
include 'templates/headerin.php';
include 'dbconn.php';
?>
<form enctype="multipart/form-data">
  <div class="row">
    <div class="large-12 columns">
		<label>Government Agency
			<select>
	<?php
	if(isset($govtAgencyId))
	{
		$getAgenciesQuery = 'select id, agencyname from govtagency where id='.$govtAgencyId.' order by agencyname';
	}
	else
	{
		$getAgenciesQuery = 'select id, agencyname from govtagency order by agencyname';
	}
	$agencyStmt= $dbh->query($getAgenciesQuery);

	foreach($agencyStmt as $agencyRow)
	{
	?>
		<option value="<?php echo rtrim($agencyRow['id']);?>"><?php echo rtrim($agencyRow['agencyname']);?></option>
	<?php
	}
	?>
        </select>
      </label>
	</div>
    <div class="large-12 columns">
	<?php
	if(isset($regionId))
	{
		$getRegionsQuery = 'select id, regionname from regions where id='.$regionId.'order by regionname asc';
	}
	else
	{
		$getRegionsQuery = 'select id, regionname from regions order by regionname asc';
	}	
	$regionStmt= $dbh->query($getRegionsQuery);
	?>
		<label>Region
		  <select name="regionid">
	<?php
	if(!isset($regionId))
	{
	?>
		  	<option value="" selected>N/A</option>
	<?php
	}

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
		  <select>
			<option value="husker"></option>
			<option value="husker">Ilocos Norte</option>
			<option value="starbuck">Ilocos Sur</option>
			<option value="hotdog">La Union</option>
			<option value="apollo">Pangasinan</option>
		  </select>
		</label>
	  </div>
	  <div class="large-12 columns">
		<label>District/Division
		  <select>
			<option value="husker"></option>
			<option value="husker">District 1</option>
			<option value="starbuck">District 2</option>
		  </select>
		</label>
	  </div>
	  <div class="large-12 columns">
		<label>City/Municiplaity
		  <select>
			<option value="husker"></option>
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
		  <select>
			<option value="husker"></option>
			<option value="husker">Barangay No. 1, San Lorenzo</option>
			<option value="starbuck">Barangay No. 2, Santa Joaquina</option>
			<option value="hotdog">Barangay No. 3, Nuestra Señora del Rosario</option>
			<option value="apollo">Barangay No. 4, San Guillermo</option>
		  </select>
		</label>
	  </div>
	  <div class="large-12 columns">
	<?php
	$getCertificationsQuery = 'select id, certificationstandard from certifications order by certificationstandard asc';
	$certificationStmt= $dbh->query($getCertificationsQuery);
	?>	  
			<label>Certification
			  <select>
	<?php
	foreach($certificationStmt as $certificationRow)
	{
	?>
				<option value="<?php echo rtrim($certificationRow['id']);?>"><?php echo rtrim($certificationRow['certificationstandard']);?></option>
	<?php
	}

	?>
			  </select>
			</label>
		  </div>	  
	  <div class="large-12 columns">
		<label>Upload Certification File
		<input type="file" name="fileToUpload" id="fileToUpload" placeholder="Certification File to be Uploaded Here">
		</label>
	  </div>
	  <div class="large-6 columns">
		<label>Validity From Date
		  <input type="date" placeholder="Start Date" />
		</label>
	  </div>	  
	  <div class="large-6 columns">
		<label>Validity Until Date
		  <input type="date" placeholder="End date" />
		</label>
	  </div>
	  <div class="large-12 columns">
	  		<input type="submit" class="button expand" value="Save"/>
	  </div>	  	  	  	  	  	
</form>
<?php
include 'templates/footer.php';