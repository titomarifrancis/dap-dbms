<?php
include 'templates/headerin.php';
include 'dbconn.php';

$agencycategoryId = $_REQUEST['catid'];
$getCategoryLabel = "select agencyclassdesc from govtagencyclass where id=$agencycategoryId";
$getCategoryStmt = $dbh->query($getCategoryLabel)->fetchAll();
$agencyCategoryLabel = $getCategoryStmt[0]['agencyclassdesc'];
?>
<h3><?php echo $agencyCategoryLabel;?> Active Certification</h3>
<?php
$tableHeaderOn = 0;

//national
$getAgenciesQueryNational = "select agencycertifications.id as agencycertificationid, govtagency.id as govtagencyid, govtagency.agencyname as agencyname, agencycertifications.certificationsite as certificationsite, certifyingbody.providerorg as certifyingbody, certifications.certificationstandard as certificationdesc, agencycertifications.certvalidstartdate as certstartdate, agencycertifications.certvalidenddate as certenddate, agencycertifications.scope_ispartial as ispartial, govtagency.hideorigcertdate as hideodc from govtagencyclass, govtagency, certifyingbody, certifications, agencycertifications where agencycertifications.isapproved=true and agencycertifications.govtagencyid=govtagency.id and agencycertifications.certifyingbodyid=certifyingbody.id and agencycertifications.certificationid=certifications.id and govtagency.govtagencyclassid=govtagencyclass.id and agencycertifications.regionid is NULL and agencycertifications.provinceid is NULL and agencycertifications.citymunicipalityid is NULL and agencycertifications.isexpired=false and govtagencyclass.id=$agencycategoryId order by agencyname";
//echo "$getAgenciesQueryNational<br/>";
$numrecordsNational = $dbh->query($getAgenciesQueryNational)->rowCount();
if($numrecordsNational > 0)
{
    if($tableHeaderOn == 0)
    {
        $tableHeaderOn = 1;
        include 'templates/tableheadersec.php';
    }
    //
    $agencyStmt= $dbh->query($getAgenciesQueryNational);
    foreach($agencyStmt as $row)
    {
        //
        $isPartial="Not Full Scope";
        if($row['ispartial'] == 1)
        {
            $isPartial="Full Scope";
        }

        $govtAgencyId = $row['govtagencyid'];
        $getODC = "select distinct agencycertifications.certvalidstartdate from agencycertifications, govtagency where agencycertifications.govtagencyid=govtagency.id and agencycertifications.isapproved=true and govtagency.id=$govtAgencyId order by agencycertifications.certvalidstartdate asc limit 1";
        $govtAgencyArray = $dbh->query($getODC)->fetchAll();
        $origCertdate = $govtAgencyArray[0]['certvalidstartdate'];
        $ishideodc = $row['hideodc'];
        $myODC = $origCertdate;
        if($ishideodc == 1)
        {
            //
            $myODC = "N/A";
        }
?>
                        <tr> 
                        <td><a href="agencycert_detailsec.php?id=<?php echo $row['agencycertificationid'];?>"><?php echo $row['agencyname'];?></a></td>
						<td><?php echo $row['certificationsite'];?></td>
                        <td><?php echo $row['certifyingbody'];?></td>
                        <td><?php echo $row['certificationdesc'];?></td>
                        <td><?php echo $row['certstartdate'];?></td>
                        <td><?php echo $row['certenddate'];?></td>
                        <td><?php echo $myODC;?></td>
                        <td><?php echo $isPartial;?></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        </tr>          
<?php
    }
}

//regional
$getAgenciesQueryRegional = "select agencycertifications.id as agencycertificationid, govtagency.id as govtagencyid, govtagency.agencyname as agencyname,  agencycertifications.certificationsite as certificationsite, certifyingbody.providerorg as certifyingbody, certifications.certificationstandard as certificationdesc, agencycertifications.certvalidstartdate as certstartdate, agencycertifications.certvalidenddate as certenddate, agencycertifications.scope_ispartial as ispartial, govtagency.hideorigcertdate as hideodc, regions.regionname from govtagencyclass, govtagency, certifyingbody, certifications, agencycertifications, regions where agencycertifications.isapproved=true and agencycertifications.govtagencyid=govtagency.id and agencycertifications.certifyingbodyid=certifyingbody.id and agencycertifications.certificationid=certifications.id and govtagency.govtagencyclassid=govtagencyclass.id and agencycertifications.isexpired=false and agencycertifications.regionid=regions.id and agencycertifications.provinceid is NULL and citymunicipalityid is NULL and govtagencyclass.id=$agencycategoryId order by agencyname";
//echo "$getAgenciesQueryRegional<br/>";
$numrecordsRegional = $dbh->query($getAgenciesQueryRegional)->rowCount();
if($numrecordsRegional > 0)
{
    if($tableHeaderOn == 0)
    {
        $tableHeaderOn = 1;
        include 'templates/tableheadersec.php';
    }
    //
    $agencyStmt= $dbh->query($getAgenciesQueryRegional);
    foreach($agencyStmt as $row)
    {
        //
        $isPartial="Not Full Scope";
        if($row['ispartial'] == 1)
        {
            $isPartial="Full Scope";
        }

        $govtAgencyId = $row['govtagencyid'];
        $getODC = "select distinct agencycertifications.certvalidstartdate from agencycertifications, govtagency where agencycertifications.govtagencyid=govtagency.id and agencycertifications.isapproved=true and govtagency.id=$govtAgencyId order by agencycertifications.certvalidstartdate asc limit 1";
        $govtAgencyArray = $dbh->query($getODC)->fetchAll();
        $origCertdate = $govtAgencyArray[0]['certvalidstartdate'];
        $ishideodc = $row['hideodc'];
        $myODC = $origCertdate;
        if($ishideodc == 1)
        {
            //
            $myODC = "N/A";
        }       
?>
                        <tr> 
                        <td><a href="agencycert_detailsec.php?id=<?php echo $row['agencycertificationid'];?>"><?php echo $row['agencyname'];?></a></td>
						<td><?php echo $row['certificationsite'];?></td>
                        <td><?php echo $row['certifyingbody'];?></td>
                        <td><?php echo $row['certificationdesc'];?></td>
                        <td><?php echo $row['certstartdate'];?></td>
                        <td><?php echo $row['certenddate'];?></td>
                        <td><?php echo $myODC;?></td>
                        <td><?php echo $isPartial;?></td>
                        <td><?php echo $row['regionname'];?></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        </tr>          
<?php
    }
}

//provincial
$getAgenciesQueryProvincial = "select agencycertifications.id as agencycertificationid, govtagency.id as govtagencyid, govtagency.agencyname as agencyname, agencycertifications.certificationsite as certificationsite, certifyingbody.providerorg as certifyingbody, certifications.certificationstandard as certificationdesc, agencycertifications.certvalidstartdate as certstartdate, agencycertifications.certvalidenddate as certenddate, agencycertifications.scope_ispartial as ispartial, govtagency.hideorigcertdate as hideodc, regions.regionname, provinces.provincename from govtagencyclass, govtagency, certifyingbody, certifications, agencycertifications, regions, provinces where agencycertifications.isapproved=true and agencycertifications.govtagencyid=govtagency.id and agencycertifications.certifyingbodyid=certifyingbody.id and agencycertifications.certificationid=certifications.id and govtagency.govtagencyclassid=govtagencyclass.id and agencycertifications.isexpired=false and agencycertifications.regionid=regions.id and agencycertifications.provinceid=provinces.id and agencycertifications.citymunicipalityid is NULL and govtagencyclass.id=$agencycategoryId order by agencyname";
//echo "$getAgenciesQueryProvincial<br/>";
$numrecordsProvincial = $dbh->query($getAgenciesQueryProvincial)->rowCount();
if($numrecordsProvincial > 0)
{
    //
    if($tableHeaderOn == 0)
    {
        $tableHeaderOn = 1;
        include 'templates/tableheadersec.php';
    }
    //
    $agencyStmt= $dbh->query($getAgenciesQueryProvincial);
    foreach($agencyStmt as $row)
    {
        //
        $isPartial="Not Full Scope";
        if($row['ispartial'] == 1)
        {
            $isPartial="Full Scope";
        }

        $govtAgencyId = $row['govtagencyid'];
        $getODC = "select distinct agencycertifications.certvalidstartdate from agencycertifications, govtagency where agencycertifications.govtagencyid=govtagency.id and agencycertifications.isapproved=true and govtagency.id=$govtAgencyId order by agencycertifications.certvalidstartdate asc limit 1";
        $govtAgencyArray = $dbh->query($getODC)->fetchAll();
        $origCertdate = $govtAgencyArray[0]['certvalidstartdate'];
        $ishideodc = $row['hideodc'];
        $myODC = $origCertdate;
        if($ishideodc == 1)
        {
            //
            $myODC = "N/A";
        }
?>
                        <tr> 
                        <td><a href="agencycert_detailsec.php?id=<?php echo $row['agencycertificationid'];?>"><?php echo $row['agencyname'];?></a></td>
						<td><?php echo $row['certificationsite'];?></td>
                        <td><?php echo $row['certifyingbody'];?></td>
                        <td><?php echo $row['certificationdesc'];?></td>
                        <td><?php echo $row['certstartdate'];?></td>
                        <td><?php echo $row['certenddate'];?></td>
                        <td><?php echo $myODC;?></td>
                        <td><?php echo $isPartial;?></td>
                        <td><?php echo $row['regionname'];?></td>
                        <td><?php echo $row['provincename'];?></td>
                        <td>&nbsp;</td>
                        </tr>          
<?php
    }    
}

//city/municipal
$getAgenciesQueryCityMunicipal = "select agencycertifications.id as agencycertificationid, govtagency.id as govtagencyid, govtagency.agencyname as agencyname, agencycertifications.certificationsite as certificationsite, certifyingbody.providerorg as certifyingbody, certifications.certificationstandard as certificationdesc, agencycertifications.certvalidstartdate as certstartdate, agencycertifications.certvalidenddate as certenddate, agencycertifications.scope_ispartial as ispartial, govtagency.hideorigcertdate as hideodc, regions.regionname, provinces.provincename, citymunicipality.towncitymunicipalityname from govtagencyclass, govtagency, certifyingbody, certifications, agencycertifications, regions, provinces, citymunicipality where agencycertifications.isapproved=true and agencycertifications.govtagencyid=govtagency.id and agencycertifications.certifyingbodyid=certifyingbody.id and agencycertifications.certificationid=certifications.id and govtagency.govtagencyclassid=govtagencyclass.id and agencycertifications.isexpired=false and agencycertifications.regionid=regions.id and agencycertifications.provinceid=provinces.id and agencycertifications.citymunicipalityid=citymunicipality.id and govtagencyclass.id=$agencycategoryId order by agencyname";
//echo "$getAgenciesQueryCityMunicipal<br/>";
$numrecordsMunicipal = $dbh->query($getAgenciesQueryCityMunicipal)->rowCount();
if($numrecordsMunicipal > 0)
{
    //
    if($tableHeaderOn == 0)
    {
        $tableHeaderOn = 1;
        include 'templates/tableheadersec.php';
    }

    $agencyStmt= $dbh->query($getAgenciesQueryCityMunicipal);
    foreach($agencyStmt as $row)
    {
        $isPartial="Not Full Scope";
        if($row['ispartial'] == 1)
        {
            $isPartial="Full Scope";
        }

        $govtAgencyId = $row['govtagencyid'];
        $getODC = "select distinct agencycertifications.certvalidstartdate from agencycertifications, govtagency where agencycertifications.govtagencyid=govtagency.id and agencycertifications.isapproved=true and govtagency.id=$govtAgencyId order by agencycertifications.certvalidstartdate asc limit 1";
        $govtAgencyArray = $dbh->query($getODC)->fetchAll();
        $origCertdate = $govtAgencyArray[0]['certvalidstartdate'];
        $ishideodc = $row['hideodc'];
        $myODC = $origCertdate;
        if($ishideodc == 1)
        {
            //
            $myODC = "N/A";
        }         
?>
                        <tr> 
                        <td><a href="agencycert_detailsec.php?id=<?php echo $row['agencycertificationid'];?>"><?php echo $row['agencyname'];?></a></td>
						<td><?php echo $row['certificationsite'];?></td>
                        <td><?php echo $row['certifyingbody'];?></td>
                        <td><?php echo $row['certificationdesc'];?></td>
                        <td><?php echo $row['certstartdate'];?></td>
                        <td><?php echo $row['certenddate'];?></td>
                        <td><?php echo $origCertdate;?></td>
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
?>
<br/>
<a href="reports/listcertification_excel.php?catid=<?php echo $agencycategoryId;?>" target="_tab"><input type="button" class="button expand" id="okButton" name="uploadBtn" value="Export as Excel"></a>&nbsp;&nbsp;<a href="reports/listcertification_pdf.php?catid=<?php echo $agencycategoryId;?>" target="_tab"><input type="button" class="button expand" id="okButton" name="uploadBtn" value="Export as PDF"></a>
<?php    
}

else
{
    echo "<p>There are no certifications recorded for this section</p>";
}

include 'templates/footer.php';