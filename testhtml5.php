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
<?php
$stringInput="Little";
$stringInitial= substr($stringInput, 1, 1);
echo "<h3>$stringInitial</h3>";

?>
<form id="companyForm"  method="post" action="testhtml5_processor.php" enctype="multipart/form-data" >
    
<div class="row">
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
		<label>Upload Certification File in PDF
		<input type="file" name="uploadedFile" id="uploadedFile" accept=".pdf">
		</label>
	  </div>
	  <div class="large-12 columns">
	  		<input type="submit" class="button expand" name="uploadBtn" value="Save"/>
	  </div>              
</form>
<?php



include 'templates/footer.php';