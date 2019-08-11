<?php
include 'templates/header.php';
?>
<form>
  <div class="row">
    <div class="large-4 columns">
      <label>Lastname
        <input type="text" placeholder="Lastname" />
      </label>
    </div>
    <div class="large-4 columns">
      <label>Firstname
        <input type="text" placeholder="Firstname" />
      </label>
    </div>
    <div class="large-2 columns">
      <label>Middle Initial
        <input type="text" placeholder="Middle Initial" />
      </label>
    </div>
    <div class="large-2 columns">
      <label>Name Extension
        <input type="text" placeholder="Ext" />
      </label>
    </div>
    <div class="large-6 columns">
      <label>Organization Affiliation
        <input type="text" placeholder="Private or Public Organization" />
      </label>
    </div>
    <div class="large-6 columns">
      <label>Position
        <input type="text" placeholder="Role in Organization" />
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
			<option value="husker">District 1</option>
			<option value="starbuck">District 1</option>
		  </select>
		</label>
	  </div>
	  <div class="large-12 columns">
		<label>City/Municiplaity
		  <select>
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
			<option value="husker">Barangay No. 1, San Lorenzo</option>
			<option value="starbuck">Barangay No. 2, Santa Joaquina</option>
			<option value="hotdog">Barangay No. 3, Nuestra Señora del Rosario</option>
			<option value="apollo">Barangay No. 4, San Guillermo</option>
		  </select>
		</label>
	  </div>
	  <div class="large-6 columns">
		<label>Username
		  <input type="text" placeholder="Enter e-mail as username" />
		</label>
	  </div>
	  <div class="large-6 columns">
		<label>Password
		  <input type="text" placeholder="at least 8 alphanumeric characters" />
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
  -->
    <div class="large-12 columns">
      <label>Supplemental Contact Information
        <textarea placeholder="Landline, Cellphone, Facebook, LinkedIn"></textarea>
      </label>
	</div>
	<!--
  </div>
  -->
</form>
<?php
include 'templates/footer.php';