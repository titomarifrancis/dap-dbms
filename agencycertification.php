<?php
include 'templates/headerin.php';
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
<h3>Agency Certification Manager</h3>
<form method="post" action="agencycert_processor.php" enctype="multipart/form-data">
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
		<input type="file" name="uploadedFile" id="uploadedFile" placeholder="Certification File to be Uploaded Here">
		</label>
	  </div>

	  <div class="large-12 columns">
            <label>Enable/Approve Agency Certification Entry
                <p>
<?php
//this only appears to DAP user
if(isset($loggedInAccessLevel) && $loggedInAccessLevel > 1)
{
	if($isapproved == 1)
	{
	?>
						<input type="radio" name="isapproved" value="true" checked> True<br>
						<input type="radio" name="isapproved" value="false"> False<br>
	<?php
	}
	else
	{
	?>
						<input type="radio" name="isapproved" value="true"> True<br>
						<input type="radio" name="isapproved" value="false" checked> False<br>
	<?php
	}

}
?>                

                </p>
        </div>

	  <div class="large-12 columns">
	  		<input type="submit" class="button expand" name="uploadBtn" value="Save"/>
	  </div>	  	  	  	  	  	
</form>
<br/>
<?php
//a table listing agency certifications will be shown here
?>
<?php
include 'templates/footer.php';
