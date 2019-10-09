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

    $getTotalAgencyCount = "select govtagency.id, govtagency.agencyname as totalAgencyCount from govtagency, govtagencyclass where govtagency.govtagencyclassid=govtagencyclass.id and govtagency.govtagencyclassid=$categoryId";
    $numberTotalAgencyCount = $dbh->query($getTotalAgencyCount)->rowCount();
    
    $getActiveCertified = "select govtagency.id, govtagency.agencyname as numActiveCertified from govtagency, agencycertifications where agencycertifications.govtagencyid=govtagency.id and govtagency.govtagencyclassid=$categoryId and agencycertifications.isexpired=false and agencycertifications.isapproved=true";
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

    $getExpiredCertification = "select govtagency.id, govtagency.agencyname from govtagencyclass, govtagency, agencycertifications where agencycertifications.isapproved=true and agencycertifications.govtagencyid=govtagency.id and govtagency.govtagencyclassid=govtagencyclass.id and agencycertifications.isexpired=true and govtagencyclass.id=$categoryId order by govtagency.agencyname";
    $totalNumberExpiredCertification = $dbh->query($getExpiredCertification)->rowCount();

    $numberUncertifiedAgency = $numberTotalAgencyCount - $numberActiveCertified;

    if($numberTotalAgencyCount == 0)
    {
        $percentageUncertified = "N/A";
    }
    else
    {
        $percentUncertified = ($numberUncertifiedAgency/$numberTotalAgencyCount) * 100;
        $percentageUncertified = number_format($percentUncertified, 2);

    }
?>
                            <tr>
                                <td><?php echo $agencycategoryName;?></td>
                                <td><?php echo $numberTotalAgencyCount;?></td>
                                <td><?php if($numberActiveCertified > 0){ echo "<a href='listactivecertification.php?catid=$categoryId'>$numberActiveCertified</a>";}else{echo $numberActiveCertified;}?></td>
                                <td><?php echo $percentageActivecertified;?></td>
                                <td><?php if($numberUncertifiedAgency > 0){ echo "<a href='listuncertifiedsec.php?catid=$categoryId'>$numberUncertifiedAgency</a>";}else{echo $numberUncertifiedAgency;}?></td>
                                <td><?php echo $percentageUncertified;?></td>
                                <td><?php if($totalNumberExpiredCertification > 0){ echo "<a href='listexpiredcertificationsec.php?catid=$categoryId'>$totalNumberExpiredCertification</a>";}else{echo $totalNumberExpiredCertification;}?></td>
                            </tr>
<?php
}

include 'templates/tablefooter.php';
?>
<br/>
<a href="reports/agencycert_summary_excel.php" target="_tab"><input type="button" class="button expand" id="okButton" name="uploadBtn" value="Export as Excel"></a>&nbsp;&nbsp;<a href="reports/agencycert_summary_pdf.php" target="_tab"><input type="button" class="button expand" id="okButton" name="uploadBtn" value="Export as PDF"></a>
<?php
include 'templates/footer.php';