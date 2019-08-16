<?php
include 'templates/headerin.php';
include 'dbconn.php';
?>
<form method="post" action="agencycert_processor.php">
  <div class="row">
    <div class="large-12 columns">
		<label>Government Agency
			<select name="govtagencyid">
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
/*
	if(isset($regionId))
	{
		$getRegionsQuery = 'select id, regionname from regions where id='.$regionId.'order by regionname asc';
	}
	else
	{*/
		$getRegionsQuery = 'select id, regionname from regions order by regionname asc';
	//}	
	$regionStmt= $dbh->query($getRegionsQuery);
	?>
		<label>Region
		  <select name="regionid">
	<?php
	if(!isset($regionId))
	{
	?>
		  	<option value="0" selected>N/A</option>
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
		  <select name="provinceid">
			<option value="0"></option>
			<option value="1">Ilocos Norte</option>
			<option value="2">Ilocos Sur</option>
			<option value="3">La Union</option>
			<option value="4">Pangasinan</option>
		  </select>
		</label>
	  </div>
	  <div class="large-12 columns">
		<label>City/Municiplaity
		  <select name="citymunicipalityid">
			<option value="0"></option>
			<option value="1">Laoag</option>
			<option value="2">Adams</option>
			<option value="3">Bacarra</option>
			<option value="4">Bangui</option>
			<option value="5">Carasi</option>
			<option value="6">Dumalneg</option>
			<option value="7">Pasuquin</option>
			<option value="8">Piddig</option>
			<option value="9">Sarrat (San Miguel)</option>
		  </select>
		</label>
	  </div>
	  <div class="large-12 columns">
		<label>Barangay
		  <select name="barangayid">
			<option value="0"></option>
			<option value="1">Barangay No. 1, San Lorenzo</option>
			<option value="2">Barangay No. 2, Santa Joaquina</option>
			<option value="3">Barangay No. 3, Nuestra Señora del Rosario</option>
			<option value="4">Barangay No. 4, San Guillermo</option>
		  </select>
		</label>
	  </div>
	  <div class="large-12 columns">
	<?php
	$getCertificationsQuery = 'select id, certificationstandard from certifications order by certificationstandard asc';
	$certificationStmt= $dbh->query($getCertificationsQuery);
	?>	  
			<label>Certification
			  <select name="certificationid">
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
	<?php
	$getCertifyingBodyQuery = 'select id, providerorg from certifyingbody order by providerorg asc';
	$certifyingBodyStmt= $dbh->query($getCertifyingBodyQuery);
	?>	  
			<label>Certifying Body
			  <select name="certifyingbodyid">
	<?php
	foreach($certifyingBodyStmt as $certifyingBodyRow)
	{
	?>
				<option value="<?php echo rtrim($certifyingBodyRow['id']);?>"><?php echo rtrim($certifyingBodyRow['providerorg']);?></option>
	<?php
	}

	?>
			  </select>
			</label>
		  </div>

	<div class="large-12 columns">
		<label>Certification Registration Number
			<input type="text" name="certificationregnumber" id="certificationregnumber" placeholder="Certification Registration Number Here">
		</label>
	</div>

	<div class="large-12 columns">
		<label>Certification Scope
			<input type="text" name="certificationscope" id="certificationscope" placeholder="Certification Scope">
		</label>
	</div>

	<div class="large-12 columns">
		<label>Head of Agency During Certification
			<input type="text" name="headofagency" id="headofagency" placeholder="Head of Agency During Certification">
		</label>
	</div>

	<div class="large-12 columns">
		<label>Certification Scope Is Partial?
			<input type="checkbox" name="scope_ispartial" id="scope_ispartial" placeholder="Certification Scope Is Partial?">
		</label>
	</div>	
	<div class="large-6 columns">
		<label>Validity From Date
		  <input type="date" name="certvalidstartdate" placeholder="Start Date" />
		</label>
	  </div>	  
	  <div class="large-6 columns">
		<label>Validity Until Date
		  <input type="date" name="certvalidenddate" placeholder="End date" />
		</label>
	  </div>
	  <div class="large-12 columns">
		<label>Upload Certification File in PDF
		<input type="file" name="fileToUpload" id="fileToUpload" placeholder="Certification File to be Uploaded Here">
		</label>
	  </div>

	  <div class="large-12 columns">
	  		<input type="submit" class="button expand" value="Save"/>
	  </div>	  	  	  	  	  	
</form>
<?php
include 'templates/footer.php';
