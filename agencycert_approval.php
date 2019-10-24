<?php
include 'templates/headerin.php';
include 'dbconn.php';
?>
<h3>Agency Certification Approval</h3>
<div>
<form method="post" action="agencycertapproval_processor.php">
<?php
if(isset($_REQUEST['id']))
{
    $id = $_REQUEST['id'];
}
//echo "Agency Certification ID $id";
$getAgencyCertforApproval = "select
govtagency.id,
govtagency.agencyname,
certifications.certificationstandard,
certifyingbody.id as providerorgid,
certifyingbody.providerorg,
certifyingbody.isapproved,
agencycertifications.certificationregnumber,
agencycertifications.certificationscope,
agencycertifications.scope_ispartial,
agencycertifications.certpdfurl,
agencycertifications.headofagency,
agencycertifications.certvalidstartdate,
agencycertifications.certvalidenddate,
agencycertifications.approvedby,
agencycertifications.approveddate,
agencycertifications.createdby,
agencycertifications.creationdate,
agencycertifications.regionid,
agencycertifications.provinceid,
agencycertifications.citymunicipalityid,
agencycertifications.barangayid,
agencycertifications.createdby
from agencycertifications, govtagency, certifications, certifyingbody
where
agencycertifications.govtagencyid=govtagency.id 
and agencycertifications.certificationid=certifications.id 
and agencycertifications.certifyingbodyid=certifyingbody.id 
and agencycertifications.id=$id";
//echo "$getAgencyCertforApproval<br/>";
$agencyCertStmt = $dbh->query($getAgencyCertforApproval);
$agencyCertApprovalArray = $agencyCertStmt->fetchAll();
?>
    <div class="row">
        <div class="large-12 columns">
            <label>Government Agency<br/>
                <input type="hidden" name="agencycertid" value="<?php echo $id; ?>">
                <input type="text" value="<?php echo $agencyCertApprovalArray[0]['agencyname'];?>"/>
            </label>
        </div>
        <div class="large-12 columns">
            <label>Region<br/>
<?php
    $regionName = '';
    if(isset($agencyCertApprovalArray[0]['regionid']) && ($agencyCertApprovalArray[0]['regionid'] !== ''))
    {
        $regionId = $agencyCertApprovalArray[0]['regionid'];
        $getRegionName = "select regionname from regions where id=$regionId";
        $getRegionStmt = $dbh->query($getRegionName);
        $getRegionArray = $getRegionStmt->fetchAll();
        $regionName = $getRegionArray[0]['regionname'];
    }
?>            
                <input type="text" value="<?php echo $regionName;?>"/>
            </label>
        </div>
        <div class="large-12 columns">
            <label>Province<br/>
<?php
    $provinceName = '';
    if(isset($agencyCertApprovalArray[0]['provinceid']) && ($agencyCertApprovalArray[0]['provinceid'] !== ''))
    {
        $provinceId = $agencyCertApprovalArray[0]['provinceid'];
        $getProvinceName = "select provincename from provinces where id=$provinceId";
        $getProvinceStmt = $dbh->query($getProvinceName);
        $getprovinceArray = $getProvinceStmt->fetchAll();
        $provinceName = $getprovinceArray[0]['provincename'];
    }
?>
                <input type="text" value="<?php echo $provinceName;?>"/>
            </label>
        </div>
        <div class="large-12 columns">
            <label>City/Municipality<br/>
<?php
    $citymunicipalityName = '';
    if(isset($agencyCertApprovalArray[0]['citymunicipalityid']) && ($agencyCertApprovalArray[0]['citymunicipalityid'] !== ''))
    {
        $citymunicipalityId = $agencyCertApprovalArray[0]['citymunicipalityid'];
        $getcitymunicipalityName = "select towncitymunicipalityname from citymunicipality where id=$citymunicipalityId";
        $getcitymunicipalityStmt = $dbh->query($getcitymunicipalityName);
        $citymunicipalityArray = $getcitymunicipalityStmt->fetchAll();
        $citymunicipalityName = $citymunicipalityArray[0]['towncitymunicipalityname'];
    }
?>
                <input type="text" value="<?php echo $citymunicipalityName;?>"/>
            </label>
        </div>
        <div class="large-12 columns">
            <label>Barangay<br/>
<?php
    $barangayName = '';
    if(isset($agencyCertApprovalArray[0]['barangayid']) && ($agencyCertApprovalArray[0]['barangayid'] !== ''))
    {
        $barangayId = $agencyCertApprovalArray[0]['citymunicipalityid'];
        $getBarangayName = "select barangayname from barangays where id=$barangayId";
        $getBarangayStmt = $dbh->query($getBarangayName);
        $getBarangayArray = $getBarangayStmt->fetchAll();
        $barangayName = $getBarangayArray[0]['barangayname'];
    }
?>
                <input type="text" value="<?php echo $barangayName;?>"/>
            </label>
        </div>
        <div class="large-12 columns">
            <label>Certification<br/>
                <input type="text" value="<?php echo $agencyCertApprovalArray[0]['certificationstandard'];?>"/>
            </label>
        </div>
        <div class="large-8 columns">
            <label>Certifying Body<br/>
                <input type="text" value="<?php echo $agencyCertApprovalArray[0]['providerorg'];?>"/>
            </label>
        </div>
        <div class="large-4 columns">
            <label><br/>
            <?php
            if($agencyCertApprovalArray[0]['isapproved'] != 1)
            {
            ?>
                <!--<a href="certifyingbodymanager.php?providerorgid=<?php echo $agencyCertApprovalArray[0]['providerorgid'];?>"><input type="button"  class="button alert-button expand" name="uploadBtn" value="Review this Unapporved Certifying Body"></a>-->
                <a href="certifyingbodymanager.php?providerorgid=<?php echo $agencyCertApprovalArray[0]['providerorgid'];?>"><input type="button"  class="button alert-button expand" name="uploadBtn" value="Review certifying body to be validated"></a>
            <?php
            }
            ?>

            </label>
        </div>        
        <div class="large-12 columns">
            <label>Certification Registration Number<br/>
                <input type="text" value="<?php echo $agencyCertApprovalArray[0]['certificationregnumber'];?>"/>
            </label>
        </div> 
        <div class="large-12 columns">
            <label>Certification Scope<br/>
                <input type="text" value="<?php echo $agencyCertApprovalArray[0]['certificationscope'];?>"/>
            </label>
        </div>
        <div class="large-12 columns">
            <label>Head of Agency During Certification<br/>
                <input type="text" value="<?php echo $agencyCertApprovalArray[0]['headofagency'];?>"/>
            </label>
        </div>
        <div class="large-12 columns">
            <label>Certification Scope Is Full? &nbsp;
                <?php if($agencyCertApprovalArray[0]['scope_ispartial'] == 1) echo "Yes"; else echo "No";?><br/>&nbsp;
            </label>
        </div>
        
        <div class="large-6 columns">
            <label>Validity From Date<br/>
                <input type="text" value="<?php echo $agencyCertApprovalArray[0]['certvalidstartdate'];?>"/>
            </label>
        </div>
        <div class="large-6 columns">
            <label>Validity Until Date<br/>
                <input type="text" value="<?php echo $agencyCertApprovalArray[0]['certvalidenddate'];?>"/>
            </label>
        </div>
        <div class="large-12 columns">
            <label>Uploaded Certification File in PDF (Please copy and open in separate browser tab or window to preview)<br/>
                <input type="text" value="<?php echo $agencyCertApprovalArray[0]['certpdfurl'];?>"/>
            </label>
        </div>
        <hr/>
        <div class="large-12 columns">
            <h3>Certification Recorder Contact Info</h3>
        </div>
<?php
    $userId= $agencyCertApprovalArray[0]['createdby'];
    $getUsrDetails = "select lastname, firstname, midname, extname, position, contactlandline, contactmobile, contactemail, govtagencyid, regionid, provinceid, citymunicipalityid, barangayid, userlevelid from systemusers where id=$userId";
    //echo "$getUsrDetails<br/>";
    //die();

    $userDetailStmt = $dbh->query($getUsrDetails);
    $usrDetail = $userDetailStmt->fetchAll();

    $lastname = $usrDetail[0]['lastname'];
    $firstname = $usrDetail[0]['firstname'];
    $midname = $usrDetail[0]['midname'];
    $extname = $usrDetail[0]['extname'];
    $position = $usrDetail[0]['position'];
    $contactlandline = $usrDetail[0]['contactlandline'];
    $contactmobile = $usrDetail[0]['contactmobile'];
    $contactemail = $usrDetail[0]['contactemail'];
    $govtagencyid = $usrDetail[0]['govtagencyid'];
    $regionid = $usrDetail[0]['regionid'];
    $provinceid = $usrDetail[0]['provinceid'];
    $citymunicipalityid = $usrDetail[0]['citymunicipalityid'];
    $barangayid = $usrDetail[0]['barangayid'];
    $usrname = $usrDetail[0]['usrname'];
    $userlevelid = $usrDetail[0]['userlevelid'];
    $isapproved =  $usrDetail[0]['isapproved'];
?>

        <div class="large-12 columns">
            <label>Last Name
                <input type="text" name="lastname" value="<?php echo $lastname;?>"/>
        </div>
        <div class="large-12 columns">
        <label>First Name
                <input type="text" name="lastname" value="<?php echo $firstname;?>"/>
        </div>        
        <div class="large-12 columns">
        <label>Middle Initial
                <input type="text" name="lastname" value="<?php echo $midname;?>"/>
        </div>
        <div class="large-12 columns">
        <label>Name Extension
                <input type="text" name="lastname" value="<?php echo $extname;?>"/>
        </div>
        <div class="large-12 columns">
        <label>Mobile Contact Number
                <input type="text" name="lastname" value="<?php echo $contactmobile;?>"/>
        </div>
        <div class="large-12 columns">
        <label>Landline Contact Number
                <input type="text" name="lastname" value="<?php echo $contactlandline;?>"/>
        </div>
        <div class="large-12 columns">
        <label>Email Address
                <input type="text" name="lastname" value="<?php echo $contactemail;?>"/>
        </div>
        <div class="large-12 columns">
        <label>Position
                <input type="text" name="lastname" value="<?php echo $position;?>"/>
        </div>                                
        <hr/>
        <div class="large-12 columns">
            <label>Validate Agency Certification Entry
            <p>
                    <input type="radio" name="isapproved" value="true"> Yes<br>
                    <input type="radio" name="isapproved" value="false" checked> Pending<br>
            </p>
    </div>
    <div class="large-12 columns">
	  		<input type="submit" class="button expand" name="uploadBtn" value="Save"/>
	</div>    
</form>
</div>
<?php

include 'templates/footer.php';