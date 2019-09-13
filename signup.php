<?php
include 'templates/header.php';
include 'dbconn.php';
?>
<script>
$(function(){
    $.getJSON("lib/getRegions.php", function(json){
            console.log(json);
            $('select#region').empty();
            $('select#region').append($('<option>').text("Select"));
            $.each(json, function(i, obj){
                    $('select#region').append($('<option>').text(obj.regionname).attr('value', obj.id));
            });
    });
    $("#region").change(function() {
        $.getJSON("lib/getProvince.php?regionid=" + $(this).val() + "", function(data){
            console.log(data);
            $('select#province').empty();
            $('select#province').append($('<option>').text("Select"));
            $.each(data, function(j, myobj){
                    $('select#province').append($('<option>').text(myobj.provincename).attr('value', myobj.id));
            });            
        });
    });
    $("#province").change(function() {
        $.getJSON("lib/getCityMunicipality.php?provinceid=" + $(this).val() + "", function(provincedata){
            console.log(provincedata);
            $('select#citymunicipality').empty();
            $('select#citymunicipality').append($('<option>').text("Select"));
            $.each(provincedata, function(k, mycitymunobj){
                    $('select#citymunicipality').append($('<option>').text(mycitymunobj.towncitymunicipalityname).attr('value', mycitymunobj.id));
            });            
        });
    });
    $("#citymunicipality").change(function() {
        $.getJSON("lib/getBarangay.php?citymunid=" + $(this).val() + "", function(citymunicipalitydata){
            console.log(citymunicipalitydata);
            $('select#barangay').empty();
            $('select#barangay').append($('<option>').text("Select"));
            $.each(citymunicipalitydata, function(l, barangayobj){
                    $('select#barangay').append($('<option>').text(barangayobj.barangayname).attr('value', barangayobj.id));
            });            
        });
    });    
});
</script>
<h3>User Signup</h3>
<form action="user_processor.php" method="post">
  <div class="row">
    <div class="large-12 columns">
      <label>Lastname
        <input type="text" name="lastname" placeholder="Lastname" required/>
      </label>
    </div>
    <div class="large-12 columns">
      <label>Firstname
        <input type="text" name="firstname" placeholder="Firstname" required />
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
        <input type="text" name="contactmobile" placeholder="Mobile Contact Number"/>
      </label>
	</div>
    <div class="large-12 columns">
      <label>Landline Contact Number
        <input type="text" name="contactlandline" placeholder="Landline Contact Number" />
      </label>
	</div>
    <div class="large-12 columns">
      <label>Email Address
        <input type="email" name="contactemail" placeholder="Email Address" required/>
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
			<option value="0" selected>Please select one</option>
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
		<label>Region
            <select id="region" name="region">
            </select>
		</label>
	</div>
    <div class="large-12 columns">
		<label>Province
			<select id="province" name="province">
                <option>Select region first</option>
            </select>
	</div>    
    <div class="large-12 columns">
		<label>City/Municipality
			<select id="citymunicipality" name="citymunicipality">
                <option>Select province first</option>
            </select>
	</div>
    <div class="large-12 columns">
		<label>Barangay
			<select id="barangay" name="barangay">
                <option>Select city/municipality first</option>
            </select>
	</div>

	  <div class="large-12 columns">
		<label>Username
		  <input type="text" name="usrname" placeholder="Enter e-mail as username" required/>
		</label>
	  </div>
	  <div class="large-12 columns">
		<label>Password
		  <input type="password" name="usrpassword" placeholder="at least 8 alphanumeric characters" required/>
		</label>
	  </div>
      <div class="large-12 large-centered columns">
        <input type="submit" class="button expand" value="Signup"/>
      </div>
	</div>  	  	  	  	  	  	
</form>
<?php
include 'templates/footer.php';