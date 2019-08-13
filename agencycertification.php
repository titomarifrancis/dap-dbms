<?php
include 'templates/headerin.php';
include 'dbconn.php';
?>
<form enctype="multipart/form-data">
  <div class="row">
    <div class="large-12 columns">
	<?php
	$getGovtAgencyClassQuery = 'select id, agencyclassdesc from govtagencyclass order by agencyclassdesc asc';
	$agencyclassStmt= $dbh->query($getGovtAgencyClassQuery);	
	?>
		<label>Government Agency Category
			<select>
	<?php
	foreach($agencyclassStmt as $agencyclassRow)
	{
	?>
		<option value="<?php echo rtrim($agencyclassRow['id']);?>"><?php echo rtrim($agencyclassRow['agencyclassdesc']);?></option>
	<?php
	}
	?>			
			</select>
		</label>
	</div>
    <div class="large-12 columns">
      <label>Government Agency
        <select>
          <option value="husker">Development Academy of the Philippines</option>
          <option value="starbuck">Department of Science and Technology</option>
          <option value="hotdog">Department of Justice</option>
          <option value="apollo">Department of Education</option>
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
  <!--
  <div class="row">
    <div class="large-6 columns">
      <label>Choose Your Favorite</label>
      <input type="radio" name="pokemon" value="Red" id="pokemonRed"><label for="pokemonRed">Red</label>
      <input type="radio" name="pokemon" value="Blue" id="pokemonBlue"><label for="pokemonBlue">Blue</label>
    </div>
    <div class="large-6 columns">
      <label>Check these out</label>
      <input id="checkbox1" type="checkbox"><label for="checkbox1">Checkbox 1</label>
      <input id="checkbox2" type="checkbox"><label for="checkbox2">Checkbox 2</label>
    </div>
  </div>
  <div class="row">
  
    <div class="large-12 columns">
      <label>Supplemental Contact Information
        <textarea placeholder="Landline, Cellphone, Facebook, LinkedIn"></textarea>
      </label>
	</div>
  </div>
  -->
</form>
<?php
include 'templates/footer.php';