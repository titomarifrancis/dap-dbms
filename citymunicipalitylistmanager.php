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
});
</script>
<h3>List of Cities/Municipalities</h3>
<form action="citymunicipality_processor.php" method="post">
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
            <input type="text" name="towncitymunicipalityname" placeholder="City or Municipality Name">
    </div>
    <div class="large-12 columns">
        <label>City?
            <input type="checkbox" name="iscity" placeholder="City or Municipality Name">
    </div>    
    <div class="large-12 columns">
        <input type="submit" class="button expand" value="Save"/>
    </div>          
</form>            
<?
include 'templates/footer.php';