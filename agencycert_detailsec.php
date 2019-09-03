<?php
include 'templates/headerin.php';
include 'dbconn.php';
?>
<h3>Agency Certification Detail</h3>
<div>
<form>
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
certifyingbody.providerorg,
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
agencycertifications.barangayid
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
        <div class="large-12 columns">
            <label>Certifying Body<br/>
                <input type="text" value="<?php echo $agencyCertApprovalArray[0]['providerorg'];?>"/>
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
            <label>Certification Scope Is Partial? &nbsp;
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
            <label>Uploaded Certification File in PDF<br/>
<?php
    $origFileUrl = $agencyCertApprovalArray[0]['certpdfurl'];
    $origFileUrlArray = explode("/", $origFileUrl);
    $viewerRootUrl = $origFileUrlArray[0];
    $origFileArraySize = sizeof($origFileUrlArray);
    unset($origFileUrlArray[0]);
    $fileUrl = implode("/", $origFileUrlArray);
    $newFileUrl = "http://" . $viewerRootUrl . "/ViewerJS/#/./" . $fileUrl;
?>            
                <a href="<?php echo $newFileUrl;?>" target="_blank">Click here to view the certification</a>
            </label>
        </div>
</form>
</div>
<br/>
<br/>
<div>
<h3>Agency Certification History</h3>
<?php
//echo $agencyCertApprovalArray[0]['id'];
//die();
$agencyId = $agencyCertApprovalArray[0]['id'];
$getAgenciesQuery = 'select agencycertifications.id as agencycertificationid, agencycertifications.isexpired, govtagency.agencyname as agencyname, certifyingbody.providerorg as certifyingbody, certifications.certificationstandard as certificationdesc, agencycertifications.certvalidstartdate as certstartdate, agencycertifications.certvalidenddate as certenddate, agencycertifications.scope_ispartial as ispartial from govtagencyclass, govtagency, certifyingbody, certifications, agencycertifications where agencycertifications.isapproved=true and agencycertifications.govtagencyid=govtagency.id and agencycertifications.certifyingbodyid=certifyingbody.id and agencycertifications.certificationid=certifications.id and govtagency.govtagencyclassid=govtagencyclass.id and govtagency.id='.$agencyId.' order by agencyname';
//echo $getAgenciesQuery;
//die();
$numrecords = $dbh->query($getAgenciesQuery)->rowCount();
if($numrecords > 0)
{
    //
    include 'templates/tableheader.php';

    $agencyStmt= $dbh->query($getAgenciesQuery);
    foreach($agencyStmt as $row)
    {
        $isPartial="No";
        if($row['ispartial'] == 1)
        {
            $isPartial="Yes";
        }
?>
                        <tr> 
                        <td><a href="agencycert_detailsec.php?id=<?php echo $row['agencycertificationid'];?>"><?php echo $row['agencyname'];?></a></td>
                        <td><?php echo $row['certifyingbody'];?></td>
                        <td><?php echo $row['certificationdesc'];?></td>
                        <td><?php echo $row['certstartdate'];?></td>
                        <td><?php echo $row['certenddate'];?></td>
                        <td><?php echo $isPartial;?></td>
                        </tr>          
<?php
    }
    include 'templates/tablefooter.php';    
}
?>
</div>

<?php

include 'templates/footer.php';