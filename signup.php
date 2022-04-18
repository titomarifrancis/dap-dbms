<?php
include 'templates/header.php';
include 'dbconn.php';
?>
<h3>Signup</h3>
<?php
if(isset($_REQUEST['msg']) && $_REQUEST['msg']==1)
{
?>
<div data-alert class="alert-box" tabindex="0" aria-live="assertive" role="alertdialog">
Congratulations for your successful registration.<br/>
    Please wait for the GQMPO Administrator to validate your account.<br/>
    An email will be sent to you upon the validation of your account<br/>
</div>
<?php
}
?>
<form id="signUpForm" action="signup_processor.php" method="post">
<div class="row">
    <div class="large-12 columns">
        <label>Last Name (required)
            <input type="text" name="lastname" id="lastnameField" placeholder="Lastname" required/>
        </label>
    </div>
    <div class="large-12 columns">
        <label>First Name (required)
            <input type="text" name="firstname" id="firstnameField" placeholder="Firstname" required/>
        </label>
    </div>
    <div class="large-12 columns">
        <label>Middle Initial (required)
            <input type="text" name="midname" id="midnameField" placeholder="Middle Initial" required/>
        </label>
    </div>
    <div class="large-12 columns">
        <label>Name Extension
            <input type="text" name="extname" placeholder="Ext" />
        </label>
	</div>
    <div class="large-12 columns">
        <label>Mobile Contact Number (required)
            <input type="text" name="contactmobile" placeholder="Mobile Contact Number" required/>
        </label>
	</div>
    <div class="large-12 columns">
        <label>Landline Contact Number (required)
            <input type="text" name="contactlandline" placeholder="Landline Contact Number" required/>
        </label>
	</div>
    <div class="large-12 columns">
        <label>Email Address (required)
            <input type="email" name="contactemail" id="emailField" placeholder="Email Address" required/>
        </label>
	</div>
    <div class="large-12 columns">
        <label>Position (required)
            <input type="text" name="position" placeholder="Role in Organization" required/>
        </label>
	</div>
	<div class="large-12 columns">
	<?php
	$getAgenciesQuery = 'select id, agencyname from govtagency order by agencyname asc';
	$agencyStmt= $dbh->query($getAgenciesQuery);
	?>
        <label>Name of Agency (required)
            <select name="govtagencyid" id="govtagencyField" required>
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
        </label>            
	</div>    
    <div class="large-12 columns">
        <label>City/Municipality
            <select id="citymunicipality" name="citymunicipality">
                <option>Select province first</option>
            </select>
        </label>
	</div>
    <div class="large-12 columns">
        <label>Barangay
            <select id="barangay" name="barangay">
                <option>Select city/municipality first</option>
            </select>
        </label>      
	</div>

    <div class="large-12 columns">
        <label>Username (required)
            <input type="text" name="usrname" id="usernameField" placeholder="username@domain" required/>
        </label>
    </div>
    <div class="large-12 columns">
        <label>Password (required)
            <input type="password" name="usrpassword" id="passwordField" placeholder="Password" required/>
        </label>
    </div>
    <div class="large-12 columns">
        <label>Data Privacy Agreement and Consent (required)<br/>
            <input type="checkbox" name="dp_agree_consent" value="agree" required/>I agree and consent to the <a href="#">Data Privacy Agreement</a><br> 
        </label>
    </div>        
    <div class="large-12 large-centered columns">
        <input type="button" class="button expand" id="okButton" value="Sign Up" disabled>
    </div>
</form>
<script>
$(function()
{
    $.getJSON("lib/getRegions.php", function(json)
    {
            console.log(json);
            $('select#region').empty();
            $('select#region').append($('<option>').text("Select"));
            $.each(json, function(i, obj){
                    $('select#region').append($('<option>').text(obj.regionname).attr('value', obj.id));
            });
    });
    $("#region").change(function()
    {
        $.getJSON("lib/getProvince.php?regionid=" + $(this).val() + "", function(data){
            console.log(data);
            $('select#province').empty();
            $('select#province').append($('<option>').text("Select"));
            $.each(data, function(j, myobj){
                    $('select#province').append($('<option>').text(myobj.provincename).attr('value', myobj.id));
            });            
        });
    });
    $("#province").change(function()
    {
        $.getJSON("lib/getCityMunicipality.php?provinceid=" + $(this).val() + "", function(provincedata){
            console.log(provincedata);
            $('select#citymunicipality').empty();
            $('select#citymunicipality').append($('<option>').text("Select"));
            $.each(provincedata, function(k, mycitymunobj){
                    $('select#citymunicipality').append($('<option>').text(mycitymunobj.towncitymunicipalityname).attr('value', mycitymunobj.id));
            });            
        });
    });
    $("#citymunicipality").change(function()
    {
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

const signUpForm = document.getElementById('signUpForm');
const lastnameField = document.getElementById('lastnameField');
const firstnameField = document.getElementById('firstnameField');
const emailField = document.getElementById('emailField');
const govtagencyField = document.getElementById('govtagencyField');
const usernameField = document.getElementById('usernameField');
const passwordField = document.getElementById('passwordField');
const okButton = document.getElementById('okButton');
  
signUpForm.addEventListener('keyup', function (event)
{
    isValidLastname = lastnameField.checkValidity();
    isValidFirstname = firstnameField.checkValidity();
    isValidEmail = emailField.checkValidity();
    isValidGovtagency = govtagencyField.checkValidity();
    isValidUsername = usernameField.checkValidity();
    isValidPassword = passwordField.checkValidity();

    if(isValidLastname && isValidFirstname && isValidEmail && isValidGovtagency && isValidUsername && isValidPassword)
    {
        okButton.disabled = false;
    }
    else
    {
        okButton.disabled = true;
    }
});

okButton.addEventListener('click', function (event)
{
  signUpForm.submit();
});
</script>
<?php
include 'templates/footer.php';