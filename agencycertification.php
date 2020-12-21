<?php
include 'templates/headerin.php';
include 'dbconn.php';
?>
<h3>Certification Details</h3>
<?php
if(isset($_REQUEST['msg']))
{
	$msg_data = $_REQUEST['msg'];
	unset($_REQUEST['msg']);
	if($msg_data == 1)
	{
		//
		?>
		<div data-alert class="alert-box" tabindex="0" aria-live="assertive" role="alertdialog">
		Congratulations for successfully recording the certification of your agency.<br/>
		Please wait for the GQMPO Administrator to validate your agency certification.<br/>
		</div>
		<?php
			
	}
	elseif($msg_data == 2)
	{
		//
		?>
		<div data-alert class="alert-box" tabindex="0" aria-live="assertive" role="alertdialog">
		Please properly fill-in all the required form fields<br/>
		</div>
		<?php
		//unset($_REQUEST['msg']);	
	}

}
?>
<div>
<form id="certForm" method="post" action="agencycert_processor.php" enctype="multipart/form-data">
  <div class="row">
    <div class="large-12 columns">
		<label>Name of Agency (required)
			<select name="govtagencyid" id="govtagencyField" required>
				<option value=""></option>
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
		<label>Site of Certification
			<input type="text" name="certificationsite" id="certificationsite" placeholder="Type the Site of Certification Here">
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
	$getGovLevelQuery = 'select id, govlevel from governancelevel order by govlevel asc';
	$govlevelStmt= $dbh->query($getGovLevelQuery);	
	?>
		<label>Level of Governance (required)
			<select id="governancelevel" name="governancelevel">
                <option value=""></option>
	<?php
	foreach($govlevelStmt as $govlevelRow)
	{
	?>
					<option value="<?php echo rtrim($govlevelRow['id']);?>"><?php echo rtrim($govlevelRow['govlevel']);?></option>
	<?php
	}

	?>
			  </select>
			</label>
		  </div>


	  <div class="large-12 columns">
	<?php
	$getCertificationsQuery = 'select id, certificationstandard from certifications order by certificationstandard asc';
	$certificationStmt= $dbh->query($getCertificationsQuery);
	?>	  
			<label>Certification (required)
				<select name="certificationid" id="certificationField" required>
					<option value=""></option>
					
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

		  <div class="large-6 columns">
	<?php
	$getCertifyingBodyQuery = 'select id, providerorg from certifyingbody order by providerorg asc';
	$certifyingBodyStmt= $dbh->query($getCertifyingBodyQuery);
	?>	  
			<label>Certifying Body (required)
				<select name="certifyingbodyid" id="certifyingbodyField">
					<option value=""></option>
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
		  <div class="large-6 columns">
			<label>Can't find your Certifying Body on the list? Add it here
				<input type="text" name="newcertifyingbody" id="newcertifyingbody" placeholder="Type the Name of Your Unlisted Certifying Body Here">
			</label>
		  </div>		  

	<div class="large-12 columns">
		<label>Certification Registration Number (required)
			<input type="text" name="certificationregnumber" id="certificationregnumber" placeholder="Certification Registration Number Here" required>
		</label>
	</div>

	<div class="large-12 columns">
		<label>Certification Scope (required)
			<input type="text" name="certificationscope" id="certificationscope" placeholder="Certification Scope" required>
		</label>
	</div>

	<div class="large-12 columns">
		<label>Head of Agency During Certification (required)
			<input type="text" name="headofagency" id="headofagency" placeholder="Head of Agency During Certification" required>
		</label>
	</div>

	<div class="large-12 columns">
		<label>Scope of Certification  &nbsp;
			<!--<input type="checkbox" name="scope_ispartial" id="scope_ispartial" placeholder="Certification Scope Is Partial?">-->
			<input type="radio" name="scope_ispartial" value="true">Partial &nbsp;&nbsp;<input type="radio" name="scope_ispartial" value="false">Full<br>
		</label>
	</div>	
	<div class="large-6 columns">
		<label>Validity From Date (required)
		  <input type="date" name="certvalidstartdate" id="certvalidstartdate" placeholder="Start Date" required/>
		</label>
	  </div>	  
	  <div class="large-6 columns">
		<label>Validity Until Date (required)
		  <input type="date" name="certvalidenddate" id="certvalidenddate" placeholder="End date" required/>
		</label>
	  </div>
	  <div class="large-12 columns">
		<label>Upload Certification File in PDF (required)
		<input type="file" name="uploadedFile" id="uploadedFile" accept=".pdf" placeholder="Certification File to be Uploaded Here" required>
		</label>
	  </div>
<?php
//this only appears to DAP user
if(isset($loggedInAccessLevel) && $loggedInAccessLevel > 1)
{
?>
	  <div class="large-12 columns">
            <label>Validate Agency Certification Entry
                <p>
					<input type="radio" name="isapproved" value="true"> Yes<br>
					<input type="radio" name="isapproved" value="false" checked> Pending<br>
				</p>
        </div>
<?php						
}
?>                



	  <div class="large-12 columns">
	  		<input type="button" class="button expand" id="okButton" name="uploadBtn" value="Save">
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
	$tableHeaderOn = 0;

	//national
	$getAgenciesQueryNational = "select agencycertifications.id as agencycertid, govtagency.agencyname as agencyname, certifyingbody.providerorg as certifyingbody, certifications.certificationstandard as certificationdesc, agencycertifications.certvalidstartdate as certstartdate, agencycertifications.certvalidenddate as certenddate, agencycertifications.scope_ispartial as ispartial from govtagencyclass, govtagency, certifyingbody, certifications, agencycertifications where agencycertifications.isapproved=false and agencycertifications.govtagencyid=govtagency.id and agencycertifications.certifyingbodyid=certifyingbody.id and agencycertifications.certificationid=certifications.id and govtagency.govtagencyclassid=govtagencyclass.id and agencycertifications.regionid is NULL and agencycertifications.provinceid is NULL and agencycertifications.citymunicipalityid is NULL order by agencyname";
	//echo "$getAgenciesQueryNational<br/>";
	$numrecordsNational = $dbh->query($getAgenciesQueryNational)->rowCount();
	if($numrecordsNational > 0)
	{
		if($tableHeaderOn == 0)
		{
			$tableHeaderOn = 1;
			echo "<h3>Agency Certification Requiring Approval</h3>";
			include 'templates/tableheader.php';
		}
		//
		$agencyStmt= $dbh->query($getAgenciesQueryNational);
		foreach($agencyStmt as $row)
		{
			//
			$isPartial="Full Scope";
			if($row['ispartial'] == 1)
			{
				$isPartial="Not Full Scope";
			}
	?>
							<tr> 
							<td><a href="agencycert_approval.php?id=<?php echo $row['agencycertid'];?>"><?php echo $row['agencyname'];?></a></td>
							<td><?php echo $row['certifyingbody'];?></td>
							<td><?php echo $row['certificationdesc'];?></td>
							<td><?php echo $row['certstartdate'];?></td>
							<td><?php echo $row['certenddate'];?></td>
							<td><?php echo $isPartial;?></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							</tr>          
	<?php
		}
	}

	//regional
	$getAgenciesQueryRegional = "select agencycertifications.id as agencycertid, govtagency.agencyname as agencyname, certifyingbody.providerorg as certifyingbody, certifications.certificationstandard as certificationdesc, agencycertifications.certvalidstartdate as certstartdate, agencycertifications.certvalidenddate as certenddate, agencycertifications.scope_ispartial as ispartial, regions.regionname from govtagencyclass, govtagency, certifyingbody, certifications, agencycertifications, regions where agencycertifications.isapproved=false and agencycertifications.govtagencyid=govtagency.id and agencycertifications.certifyingbodyid=certifyingbody.id and agencycertifications.certificationid=certifications.id and govtagency.govtagencyclassid=govtagencyclass.id and agencycertifications.regionid=regions.id and agencycertifications.provinceid is NULL and agencycertifications.citymunicipalityid is NULL order by agencyname";
	//echo "$getAgenciesQueryRegional<br/>";
	$numrecordsRegional = $dbh->query($getAgenciesQueryRegional)->rowCount();
	if($numrecordsRegional > 0)
	{
		if($tableHeaderOn == 0)
		{
			$tableHeaderOn = 1;
			echo "<h3>Agency Certification Requiring Approval</h3>";
			include 'templates/tableheader.php';
		}
		//
		$agencyStmt= $dbh->query($getAgenciesQueryRegional);
		foreach($agencyStmt as $row)
		{
			//
			$isPartial="Full Scope";
			if($row['ispartial'] == 1)
			{
				$isPartial="Not Full Scope";
			}
	?>
							<tr> 
							<td><a href="agencycert_approval.php?id=<?php echo $row['agencycertid'];?>"><?php echo $row['agencyname'];?></a></td>
							<td><?php echo $row['certifyingbody'];?></td>
							<td><?php echo $row['certificationdesc'];?></td>
							<td><?php echo $row['certstartdate'];?></td>
							<td><?php echo $row['certenddate'];?></td>
							<td><?php echo $isPartial;?></td>
							<td><?php echo $row['regionname'];?></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							</tr>          
	<?php
		}
	}

	//provincial
	$getAgenciesQueryProvincial = "select agencycertifications.id as agencycertid, govtagency.agencyname as agencyname, certifyingbody.providerorg as certifyingbody, certifications.certificationstandard as certificationdesc, agencycertifications.certvalidstartdate as certstartdate, agencycertifications.certvalidenddate as certenddate, agencycertifications.scope_ispartial as ispartial, regions.regionname, provinces.provincename from govtagencyclass, govtagency, certifyingbody, certifications, agencycertifications, regions, provinces where agencycertifications.isapproved=false and agencycertifications.govtagencyid=govtagency.id and agencycertifications.certifyingbodyid=certifyingbody.id and agencycertifications.certificationid=certifications.id and govtagency.govtagencyclassid=govtagencyclass.id and agencycertifications.regionid=regions.id and agencycertifications.provinceid=provinces.id and agencycertifications.citymunicipalityid is NULL order by agencyname";
	//echo "$getAgenciesQueryProvincial<br/>";
	$numrecordsProvincial = $dbh->query($getAgenciesQueryProvincial)->rowCount();
	if($numrecordsProvincial > 0)
	{
		//
		if($tableHeaderOn == 0)
		{
			$tableHeaderOn = 1;
			echo "<h3>Agency Certification Requiring Approval</h3>";
			include 'templates/tableheader.php';
		}
		//
		$agencyStmt= $dbh->query($getAgenciesQueryProvincial);
		foreach($agencyStmt as $row)
		{
			//
			$isPartial="Full Scope";
			if($row['ispartial'] == 1)
			{
				$isPartial="Not Full Scope";
			}
	?>
							<tr> 
							<td><a href="agencycert_approval.php?id=<?php echo $row['agencycertid'];?>"><?php echo $row['agencyname'];?></a></td>
							<td><?php echo $row['certifyingbody'];?></td>
							<td><?php echo $row['certificationdesc'];?></td>
							<td><?php echo $row['certstartdate'];?></td>
							<td><?php echo $row['certenddate'];?></td>
							<td><?php echo $isPartial;?></td>
							<td><?php echo $row['regionname'];?></td>
							<td><?php echo $row['provincename'];?></td>
							<td>&nbsp;</td>
							</tr>          
	<?php
		}    
	}

	//city/municipal
	//$getAgenciesQueryCityMunicipal = "select agencycertifications.id as agencycertificationid, govtagency.agencyname as agencyname, certifyingbody.providerorg as certifyingbody, certifications.certificationstandard as certificationdesc, agencycertifications.certvalidstartdate as certstartdate, agencycertifications.certvalidenddate as certenddate, agencycertifications.scope_ispartial as ispartial, regions.regionname, provinces.provincename, citymunicipality.towncitymunicipalityname from govtagencyclass, govtagency, certifyingbody, certifications, agencycertifications, regions, provinces, citymunicipality where agencycertifications.isapproved=false and agencycertifications.govtagencyid=govtagency.id and agencycertifications.certifyingbodyid=certifyingbody.id and agencycertifications.certificationid=certifications.id and govtagency.govtagencyclassid=govtagencyclass.id and agencycertifications.isexpired=false and agencycertifications.regionid=regions.id and agencycertifications.provinceid=provinces.id and agencycertifications.citymunicipalityid=citymunicipality.id and govtagencyclass.id=$agencycategoryId order by agencyname";
	$getAgenciesQueryCityMunicipal = "select agencycertifications.id as agencycertid, govtagency.agencyname as agencyname, certifyingbody.providerorg as certifyingbody, certifications.certificationstandard as certificationdesc, agencycertifications.certvalidstartdate as certstartdate, agencycertifications.certvalidenddate as certenddate, agencycertifications.scope_ispartial as ispartial, regions.regionname, provinces.provincename, citymunicipality.towncitymunicipalityname from govtagencyclass, govtagency, certifyingbody, certifications, agencycertifications, regions, provinces, citymunicipality where agencycertifications.isapproved=false and agencycertifications.govtagencyid=govtagency.id and agencycertifications.certifyingbodyid=certifyingbody.id and agencycertifications.certificationid=certifications.id and govtagency.govtagencyclassid=govtagencyclass.id and agencycertifications.regionid=regions.id and agencycertifications.provinceid=provinces.id and agencycertifications.citymunicipalityid=citymunicipality.id order by agencyname";
	//echo "$getAgenciesQueryCityMunicipal<br/>";
	$numrecordsMunicipal = $dbh->query($getAgenciesQueryCityMunicipal)->rowCount();
	if($numrecordsMunicipal > 0)
	{
		//
		if($tableHeaderOn == 0)
		{
			$tableHeaderOn = 1;
			echo "<h3>Agency Certification Requiring Approval</h3>";
			include 'templates/tableheader.php';
		}
	
		$agencyStmt= $dbh->query($getAgenciesQueryCityMunicipal);
		foreach($agencyStmt as $row)
		{
			$isPartial="Full Scope";
			if($row['ispartial'] == 1)
			{
				$isPartial="Not Full Scope";
			}
	?>
							<tr> 
							<td><a href="agencycert_approval.php?id=<?php echo $row['agencycertid'];?>"><?php echo $row['agencyname'];?></a></td>
							<td><?php echo $row['certifyingbody'];?></td>
							<td><?php echo $row['certificationdesc'];?></td>
							<td><?php echo $row['certstartdate'];?></td>
							<td><?php echo $row['certenddate'];?></td>
							<td><?php echo $isPartial;?></td>
							<td><?php echo $row['regionname'];?></td>
							<td><?php echo $row['provincename'];?></td>
							<td><?php echo $row['towncitymunicipalityname'];?></td>
							</tr>          
	<?php
		}
	}
	if($tableHeaderOn == 1)
	{
		include 'templates/tablefooter.php';
	}
	
	/*
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
	*/
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
/*
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
*/
okButton.addEventListener('click', function (event)
{
	certForm.submit();
});

</script>
<?php
include 'templates/footer.php';