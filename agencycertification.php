<?php
include 'templates/headerin.php';
include 'dbconn.php';
?>
<h3>Agency Certification Manager</h3>
<div>
<form id="certForm" method="post" action="agencycert_processor.php" enctype="multipart/form-data">
  <div class="row">
    <div class="large-12 columns">
		<label>Name of Agency
			<select name="govtagencyid" id="govtagencyField" required>
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
			  <select name="certificationid" id="certificationField" required>
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
			<label>Certifying Body (if the selection you need to choose is not one of the options below, please add it through the Certifying Body Manager, subject for approval) <a href="certifyingbodymanager.php">Add Certifying Body</a>
			  <select name="certifyingbodyid" id="certifyingbodyField" required>
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
			<input type="text" name="certificationregnumber" id="certificationregnumber" placeholder="Certification Registration Number Here" required>
		</label>
	</div>

	<div class="large-12 columns">
		<label>Certification Scope
			<input type="text" name="certificationscope" id="certificationscope" placeholder="Certification Scope" required>
		</label>
	</div>

	<div class="large-12 columns">
		<label>Head of Agency During Certification
			<input type="text" name="headofagency" id="headofagency" placeholder="Head of Agency During Certification" required>
		</label>
	</div>

	<div class="large-12 columns">
		<label>Certification Scope Is Partial? &nbsp;
			<input type="checkbox" name="scope_ispartial" id="scope_ispartial" placeholder="Certification Scope Is Partial?">
		</label>
	</div>	
	<div class="large-6 columns">
		<label>Validity From Date
		  <input type="date" name="certvalidstartdate" id="certvalidstartdate" placeholder="Start Date" required/>
		</label>
	  </div>	  
	  <div class="large-6 columns">
		<label>Validity Until Date
		  <input type="date" name="certvalidenddate" id="certvalidenddate" placeholder="End date" required/>
		</label>
	  </div>
	  <div class="large-12 columns">
		<label>Upload Certification File in PDF
		<input type="file" name="uploadedFile" id="uploadedFile" accept=".pdf" placeholder="Certification File to be Uploaded Here" required>
		</label>
	  </div>
<?php
//this only appears to DAP user
if(isset($loggedInAccessLevel) && $loggedInAccessLevel > 1)
{
?>
	  <div class="large-12 columns">
            <label>Enable/Approve Agency Certification Entry
                <p>
					<input type="radio" name="isapproved" value="true"> True<br>
					<input type="radio" name="isapproved" value="false" checked> False<br>
				</p>
        </div>
<?php						
}
?>                



	  <div class="large-12 columns">
	  		<input type="button" class="button expand" id="okButton" name="uploadBtn" value="Save"/>
	  </div>	  	  	  	  	  	
</form>
</div>
<br/>
<div>
<?php
//a table listing unapproved agency certifications will be shown here
//viewable only by DAP admin
if(isset($loggedInAccessLevel) && ($loggedInAccessLevel > 1))
{
	$getUnapprovedAgencyCert = "select agencycertifications.id as agencycertid, govtagency.agencyname as agencyname, certifyingbody.providerorg as certifyingbody, certifications.certificationstandard as certificationdesc, agencycertifications.certvalidstartdate as certstartdate, agencycertifications.certvalidenddate as certenddate, agencycertifications.scope_ispartial as ispartial from govtagencyclass, govtagency, certifyingbody, certifications, agencycertifications where agencycertifications.isapproved=false and agencycertifications.govtagencyid=govtagency.id and agencycertifications.certifyingbodyid=certifyingbody.id and agencycertifications.certificationid=certifications.id and govtagency.govtagencyclassid=govtagencyclass.id order by agencyname";
	//echo $getUnapprovedAgencyCert;
	//die();
	$unapprovedAgencyStmt = $dbh->query($getUnapprovedAgencyCert);
	$numrecords = $unapprovedAgencyStmt->rowcount();
	//if($numrecords > 0)
	//{
		echo "<h3>Agency Certification Requiring Approval</h3>";
		include 'templates/tableheader.php';
		foreach($unapprovedAgencyStmt as $unapprovedAgencyRow)
		{
			$isPartial="No";
			if($unapprovedAgencyRow['ispartial'] == 1)
			{
				$isPartial="Yes";
			}
		?>
							<tr> 
							<td><a href="agencycert_approval.php?id=<?php echo $unapprovedAgencyRow['agencycertid'];?>"><?php echo $unapprovedAgencyRow['agencyname'];?></a></td>
							<td><?php echo $unapprovedAgencyRow['certifyingbody'];?></td>
							<td><?php echo $unapprovedAgencyRow['certificationdesc'];?></td>
							<td><?php echo $unapprovedAgencyRow['certstartdate'];?></td>
							<td><?php echo $unapprovedAgencyRow['certenddate'];?></td>
							<td><?php echo $isPartial;?></td>
							</tr>          
		<?php
		}
		include 'templates/tablefooter.php';
	//}
}
?>
</div>
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

const certForm = document.getElementById('certForm');
const govtagencyField = document.getElementById('govtagencyField');
const certificationField = document.getElementById('certificationField');
const certifyingbodyField = document.getElementById('certifyingbodyField');
const certificationregnumber = document.getElementById('certificationregnumber');
const certificationscope = document.getElementById('certificationscope');
const headofagency = document.getElementById('headofagency');
const certvalidstartdate = document.getElementById('certvalidstartdate');
const certvalidenddate = document.getElementById('certvalidenddate');
const uploadedFile = document.getElementById('uploadedFile');

certForm.addEventListener('keyup', function (event)
{
    isValidGovtAgency = govtagencyField.checkValidity();
    isValidCertification = certificationField.checkValidity();
    isValidCertifyingBody = certifyingbodyField.checkValidity();
    isValidCertificationRegnumber = certificationregnumber.checkValidity();
	isvalidCertificationScope = certificationscope.checkValidity();
	isvalidHeadofAgency = headofagency.checkValidity();
	isvalidCertStartDate = certvalidstartdate.checkValidity();
	isValidCertEndDate = certvalidenddate.checkValidity();
    isValidUploadedFile = uploadedFile.checkValidity();

    
    if ( isValidGovtAgency && isValidCertification && isValidCertifyingBody && isValidCertificationRegnumber && isvalidCertificationScope && isvalidHeadofAgency && isvalidCertStartDate && isValidCertEndDate && isValidUploadedFile )
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
