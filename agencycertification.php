<?php
include 'templates/header.php';
include 'dbconn.php';
?>
<form>
  <div class="row">
    <div class="large-12 columns">
			<label>Government Agency Category
			  <select>
				<option value="husker">Constitutional Offices</option>
				<option value="starbuck">National Government Agencies</option>
				<option value="hotdog">NGA-Attached Offices and Bureaus</option>
				<option value="apollo">Other Executive Offices</option>
				<option value="husker">Government Owned or Controlled Corporations</option>
				<option value="starbuck">State Universities and Colleges</option>
				<option value="hotdog">Local Government Units</option>
				<option value="apollo">Local Water Districts</option>				
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
		<label>Region
		  <select>
			<option value="husker">Central</option>
			<option value="husker">I - Ilocos Region</option>
			<option value="starbuck">II - Cagayan Valley</option>
			<option value="hotdog">III - Central Luzon</option>
			<option value="apollo">IV A - Calabarzon</option>
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
			<label>Certification
			  <select>
				<option value="husker">ISO 9001:2015</option>
				<option value="starbuck">ISO 9001:2008</option>
			  </select>
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