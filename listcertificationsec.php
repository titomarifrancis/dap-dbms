<?php
include 'templates/headerin.php';
include 'dbconn.php';

$agencycategoryId = $_REQUEST['catid'];
$getCategoryLabel = "select agencyclassdesc from govtagencyclass where id=$agencycategoryId";
$getCategoryStmt = $dbh->query($getCategoryLabel)->fetchAll();
$agencyCategoryLabel = $getCategoryStmt[0]['agencyclassdesc'];
?>
<h3><?php echo $agencyCategoryLabel;?> Certification</h3>
<?php
$tableHeaderOn = 0;

//national
$getAgenciesQueryNational = "select agencycertifications.id as agencycertificationid, govtagency.agencyname as agencyname, certifyingbody.providerorg as certifyingbody, certifications.certificationstandard as certificationdesc, agencycertifications.certvalidstartdate as certstartdate, agencycertifications.certvalidenddate as certenddate, agencycertifications.scope_ispartial as ispartial, agencycertifications.certificationsite as certsite, agencycertifications.certificationsite as certsite, governancelevel.govlevel as governancelevel from govtagencyclass, govtagency, certifyingbody, certifications, agencycertifications, governancelevel where agencycertifications.isapproved=true and agencycertifications.govtagencyid=govtagency.id and agencycertifications.certifyingbodyid=certifyingbody.id and agencycertifications.certificationid=certifications.id and govtagency.govtagencyclassid=govtagencyclass.id and agencycertifications.regionid is NULL and agencycertifications.provinceid is NULL and agencycertifications.citymunicipalityid is NULL and agencycertifications.isexpired=false and governancelevel.id=agencycertifications.governancelevel and govtagencyclass.id=$agencycategoryId order by agencyname";
$numrecordsNational = $dbh->query($getAgenciesQueryNational)->rowCount();
if($numrecordsNational > 0)
{
    if($tableHeaderOn == 0)
    {
        $tableHeaderOn = 1;
        include 'templates/tableheader.php';
    }
    
    $agencyStmt= $dbh->query($getAgenciesQueryNational);
    foreach($agencyStmt as $row)
    {
        
        $isPartial="Full Scope";
        if($row['ispartial'] == 1)
        {
            $isPartial="Not Full Scope";
        }
?>
                        <tr> 
                        <td><a href="agencycert_detailsec.php?id=<?php echo $row['agencycertificationid'];?>"><?php echo $row['agencyname'];?></a></td>
						<td><?php echo $row['certsite'];?></td>
						<td><?php echo $row['governancelevel'];?></td>						
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
$getAgenciesQueryRegional = "select agencycertifications.id as agencycertificationid, govtagency.agencyname as agencyname, certifyingbody.providerorg as certifyingbody, certifications.certificationstandard as certificationdesc, agencycertifications.certvalidstartdate as certstartdate, agencycertifications.certvalidenddate as certenddate, agencycertifications.scope_ispartial as ispartial, agencycertifications.certificationsite as certsite, governancelevel.govlevel as governancelevel, regions.regionname from govtagencyclass, govtagency, certifyingbody, certifications, agencycertifications, governancelevel, regions where agencycertifications.isapproved=true and agencycertifications.govtagencyid=govtagency.id and agencycertifications.certifyingbodyid=certifyingbody.id and agencycertifications.certificationid=certifications.id and govtagency.govtagencyclassid=govtagencyclass.id and agencycertifications.isexpired=false and agencycertifications.regionid=regions.id and agencycertifications.provinceid is NULL and citymunicipalityid is NULL  and governancelevel.id=agencycertifications.governancelevel and govtagencyclass.id=$agencycategoryId order by agencyname";
$numrecordsRegional = $dbh->query($getAgenciesQueryRegional)->rowCount();
if($numrecordsRegional > 0)
{
    if($tableHeaderOn == 0)
    {
        $tableHeaderOn = 1;
        include 'templates/tableheader.php';
    }
    
    $agencyStmt= $dbh->query($getAgenciesQueryRegional);
    foreach($agencyStmt as $row)
    {
        
        $isPartial="Full Scope";
        if($row['ispartial'] == 1)
        {
            $isPartial="Not Full Scope";
        }
?>
                        <tr> 
                        <td><a href="agencycert_detailsec.php?id=<?php echo $row['agencycertificationid'];?>"><?php echo $row['agencyname'];?></a></td>
						<td><?php echo $row['certsite'];?></td>
						<td><?php echo $row['governancelevel'];?></td>						
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
$getAgenciesQueryProvincial = "select agencycertifications.id as agencycertificationid, govtagency.agencyname as agencyname, certifyingbody.providerorg as certifyingbody, certifications.certificationstandard as certificationdesc, agencycertifications.certvalidstartdate as certstartdate, agencycertifications.certvalidenddate as certenddate, agencycertifications.scope_ispartial as ispartial, agencycertifications.certificationsite as certsite, governancelevel.govlevel as governancelevel, regions.regionname, provinces.provincename from govtagencyclass, govtagency, certifyingbody, certifications, agencycertifications, governancelevel, regions, provinces where agencycertifications.isapproved=true and agencycertifications.govtagencyid=govtagency.id and agencycertifications.certifyingbodyid=certifyingbody.id and agencycertifications.certificationid=certifications.id and govtagency.govtagencyclassid=govtagencyclass.id and agencycertifications.isexpired=false and agencycertifications.regionid=regions.id and agencycertifications.provinceid=provinces.id and governancelevel.id=agencycertifications.governancelevel and agencycertifications.citymunicipalityid is NULL and govtagencyclass.id=$agencycategoryId order by agencyname";
$numrecordsProvincial = $dbh->query($getAgenciesQueryProvincial)->rowCount();
if($numrecordsProvincial > 0)
{
    
    if($tableHeaderOn == 0)
    {
        $tableHeaderOn = 1;
        include 'templates/tableheader.php';
    }
    
    $agencyStmt= $dbh->query($getAgenciesQueryProvincial);
    foreach($agencyStmt as $row)
    {
        
        $isPartial="Full Scope";
        if($row['ispartial'] == 1)
        {
            $isPartial="Not Full Scope";
        }
?>
                        <tr> 
                        <td><a href="agencycert_detailsec.php?id=<?php echo $row['agencycertificationid'];?>"><?php echo $row['agencyname'];?></a></td>
						<td><?php echo $row['certsite'];?></td>
						<td><?php echo $row['governancelevel'];?></td>
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
$getAgenciesQueryCityMunicipal = "select agencycertifications.id as agencycertificationid, govtagency.agencyname as agencyname, certifyingbody.providerorg as certifyingbody, certifications.certificationstandard as certificationdesc, agencycertifications.certvalidstartdate as certstartdate, agencycertifications.certvalidenddate as certenddate, agencycertifications.scope_ispartial as ispartial, agencycertifications.certificationsite as certsite, governancelevel.govlevel as governancelevel, regions.regionname, provinces.provincename, citymunicipality.towncitymunicipalityname from govtagencyclass, govtagency, certifyingbody, certifications, agencycertifications, governancelevel, regions, provinces, citymunicipality where agencycertifications.isapproved=true and agencycertifications.govtagencyid=govtagency.id and agencycertifications.certifyingbodyid=certifyingbody.id and agencycertifications.certificationid=certifications.id and govtagency.govtagencyclassid=govtagencyclass.id and agencycertifications.isexpired=false and agencycertifications.regionid=regions.id and agencycertifications.provinceid=provinces.id and agencycertifications.citymunicipalityid=citymunicipality.id and governancelevel.id=agencycertifications.governancelevel and govtagencyclass.id=$agencycategoryId order by agencyname";
$numrecordsMunicipal = $dbh->query($getAgenciesQueryCityMunicipal)->rowCount();
if($numrecordsMunicipal > 0)
{
    
    if($tableHeaderOn == 0)
    {
        $tableHeaderOn = 1;
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
                        <td><a href="agencycert_detailsec.php?id=<?php echo $row['agencycertificationid'];?>"><?php echo $row['agencyname'];?></a></td>
						<td><?php echo $row['certsite'];?></td>
						<td><?php echo $row['governancelevel'];?></td>
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

else
{
    echo "<p>There are no certifications recorded for this section</p>";
}

include 'templates/footer.php';
