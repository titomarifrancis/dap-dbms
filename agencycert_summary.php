<?php
include 'templates/headerin.php';
include 'dbconn.php';
?>
<h3>Agency Certification Summary</h3>
<?php
include 'templates/summarytableheader.php';

//get agency category
$getAgencyCategory = "select id, agencyclassdesc from govtagencyclass";
$getAgencyCategoryStmt = $dbh->query($getAgencyCategory);
$agencyCategoryArray = $getAgencyCategoryStmt->fetchAll();

foreach($agencyCategoryArray as $categoryRow)
{
    $categoryId = $categoryRow['id'];
    $agencycategoryName = $categoryRow['agencyclassdesc'];

    $getTotalAgencyCount = "select agencyname as totalAgencyCount from govtagency, govtagencyclass where govtagency.govtagencyclassid=govtagencyclass.id and govtagency.govtagencyclassid=$categoryId";
    $numberTotalAgencyCount = $dbh->query($getTotalAgencyCount)->rowCount();
    
    $getActiveCertified = "select agencyname as numActiveCertified from govtagency, agencycertifications where agencycertifications.govtagencyid=govtagency.id and govtagency.govtagencyclassid=$categoryId and agencycertifications.isexpired=false and agencycertifications.isapproved=true";
    $numberActiveCertified = $dbh->query($getActiveCertified)->rowCount();
    if($numberTotalAgencyCount == 0)
    {
        $percentageActivecertified = "N/A";
    }
    else
    {
        $percentActivecertified = ($numberActiveCertified/$numberTotalAgencyCount) * 100;
        $percentageActivecertified = number_format($percentActivecertified, 2);

    }

    $getUncertified = "select distinct govtagency.id from govtagency, govtagencyclass, agencycertifications where govtagencyclass.id=govtagency.govtagencyclassid and agencycertifications.govtagencyid<>govtagency.id and govtagencyclass.id=$categoryId";
    $numberUncertifiedAgency = $dbh->query($getUncertified)->rowCount();
    if($numberTotalAgencyCount == 0)
    {
        $percentageUncertified = "N/A";
    }
    else
    {
        $percentUncertified = ($numberUncertifiedAgency/$numberTotalAgencyCount) * 100;
        $percentageUncertified = number_format($percentUncertified, 2);

    }
    
    $numExpired = 0;
    $getAgencyPerCategory = "select id from govtagency where govtagencyclassid=$categoryId";
    $getAgencyPerCategoryStmt = $dbh->query($getAgencyPerCategory);
    $agencyPerCategoryArray = $getAgencyPerCategoryStmt->fetchAll();

    foreach($agencyPerCategoryArray as $agencyPerCategoryArray)
    {
        //check if it has expired certification as latest certification
        $agencyId = $agencyPerCategoryArray['id'];
        $getLastCertificationStatus = "select agencycertifications.isexpired from govtagencyclass, govtagency, certifyingbody, certifications, agencycertifications where agencycertifications.isapproved=true and agencycertifications.govtagencyid=govtagency.id and agencycertifications.certifyingbodyid=certifyingbody.id and agencycertifications.certificationid=certifications.id and govtagency.govtagencyclassid=govtagencyclass.id and govtagency.id=$agencyId order by agencycertifications.certvalidenddate desc limit 1";
        $getLastCertificationStatusStmt = $dbh->query($getLastCertificationStatus);
        $getLastCertificationStatusArray = $getLastCertificationStatusStmt->fetchAll();
        $lastCertificationStatus = $getLastCertificationStatusArray[0]['isexpired'];
        if($lastCertificationStatus == 't')
        {
            $numExpired++;
        }
    }
    $totalNumberExpiredCertification = $numExpired;
    if($numberTotalAgencyCount == 0)
    {
        $percentageExpired = "N/A";
    }
    else
    {
        $percentExpired = ($totalNumberExpiredCertification/$numberTotalAgencyCount) * 100;
        $percentageExpired = number_format($percentExpired, 2);

    }


?>
                            <tr>
                                <td><?php echo $agencycategoryName;?></td>
                                <td><?php echo $numberTotalAgencyCount;?></td>
                                <td><?php echo $numberActiveCertified;?></td>
                                <td><?php echo $percentageActivecertified;?></td>
                                <td><?php echo $totalNumberExpiredCertification;?></td>
                                <td><?php echo $percentageExpired;?></td>
                                <td><?php echo $numberUncertifiedAgency;?></td>
                                <td><?php echo $percentageUncertified;?></td>
                            </tr>
<?php
}

include 'templates/tablefooter.php';
include 'templates/footer.php';