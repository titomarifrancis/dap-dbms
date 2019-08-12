<?php
include 'templates/headerin.php';
include 'dbconn.php';
?>
<form>
  <div class="row">
    <div class="large-12 columns">
      <label>Lastname
        <input type="text" name="lastname" placeholder="Lastname" />
      </label>
    </div>
    <div class="large-12 columns">
      <label>Firstname
        <input type="text" name="firstname" placeholder="Firstname" />
      </label>
    </div>
    <div class="large-12 columns">
      <label>Middle Initial
        <input type="text" name="midname" placeholder="Middle Initial" />
      </label>
    </div>
    <div class="large-12 columns">
      <label>Name Extension
        <input type="text" name="extname" placeholder="Ext" />
      </label>
	</div>
    <div class="large-12 columns">
      <label>Mobile Contact Number
        <input type="text" name="extname" placeholder="Mobile Contact Number" />
      </label>
	</div>
    <div class="large-12 columns">
      <label>Landline Contact Number
        <input type="text" name="extname" placeholder="Landline Contact Number" />
      </label>
	</div>
    <div class="large-12 columns">
      <label>Email Address
        <input type="email" name="extname" placeholder="Email Address" />
      </label>
	</div>			
    <div class="large-12 columns">
      <label>Position
        <input type="text" name="position" placeholder="Role in Organization" />
      </label>
	</div>
	<div class="large-12 columns">
	<?php
	$getAgenciesQuery = 'select id, agencyname from govtagency order by agencyname asc';
	$agencyStmt= $dbh->query($getAgenciesQuery);
	?>
      <label>Government Agency
        <select name="govtagencyid">
			<option value="" selected>Please select one</option>
	<?php
	foreach($agencyStmt as $row)
	{
	?>
	      <option value="<?php echo $row['id'];?>"><?php echo rtrim($row['agencyname']);?></option>
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
		  <select>
		  	<option value="" selected>N/A</option>
			<option value="husker">District 1</option>
			<option value="starbuck">District 1</option>
		  </select>
		</label>
	  </div>
	  <div class="large-12 columns">
		<label>City/Municiplaity
		  <select>
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
		  <select>
		  	<option value="" selected>N/A</option>
			<option value="husker">Barangay No. 1, San Lorenzo</option>
			<option value="starbuck">Barangay No. 2, Santa Joaquina</option>
			<option value="hotdog">Barangay No. 3, Nuestra Señora del Rosario</option>
			<option value="apollo">Barangay No. 4, San Guillermo</option>
		  </select>
		</label>
	  </div>
	  <div class="large-12 columns">
		<label>Username
		  <input type="text" placeholder="Enter e-mail as username" />
		</label>
	  </div>
	  <div class="large-12 columns">
		<label>Password
		  <input type="password" placeholder="at least 8 alphanumeric characters" />
		</label>
	  </div>	  	  	  	  	  	
</form>
<?php
include 'templates/footer.php';