<?php
include 'dbconn.php';

//get data for display
$getAgencyCategory = "select id, agencyclassdesc from govtagencyclass";
$getAgencyCategoryStmt = $dbh->query($getAgencyCategory);
$agencyCategoryArray = $getAgencyCategoryStmt->fetchAll();

$agencyTotalCount = 0;
$uncertifiedAgencyCount = 0;
foreach($agencyCategoryArray as $categoryRow)
{
    $categoryId = $categoryRow['id'];
    $agencycategoryName = $categoryRow['agencyclassdesc'];

    $getTotalAgencyCount = "select govtagency.id, govtagency.agencyname as totalAgencyCount from govtagency, govtagencyclass where govtagency.govtagencyclassid=govtagencyclass.id and govtagency.govtagencyclassid=$categoryId";
    $numberTotalAgencyCount = $dbh->query($getTotalAgencyCount)->rowCount();

    $getUncertifiedAgencyCount = "select govtagency.id as agencyid, govtagency.agencyname from govtagencyclass, govtagency where govtagency.govtagencyclassid=govtagencyclass.id and govtagencyclass.id=$categoryId except select govtagency.id as agencyid, govtagency.agencyname from govtagency, agencycertifications where agencycertifications.govtagencyid = govtagency.id and agencycertifications.isexpired=false and agencycertifications.isapproved=true order by agencyname";
    $numberUncertifiedAgencyCount = $dbh->query($getUncertifiedAgencyCount)->rowCount();


    $categoryName = $agencycategoryName;
    $categoryAgencyTotal = $numberTotalAgencyCount;
    $categoryUncertifiedAgencyCount = $numberUncertifiedAgencyCount;
    $categoryCertifiedAgencyCount = $numberTotalAgencyCount - $numberUncertifiedAgencyCount;
    $categoryCertPercentage = ($categoryCertifiedAgencyCount/$categoryAgencyTotal)*100;

    if($categoryCertifiedAgencyCount > 0)
    {
        //
        $categoryCertPercentage = number_format((($categoryCertifiedAgencyCount/$categoryAgencyTotal)*100), 2);

        $categoryCertStats[] = ['categoryName'=>$categoryName, 'agencyTotalCount'=>$categoryAgencyTotal, 'agencyCertifiedCount'=>$categoryCertifiedAgencyCount, 'agencyUncertifiedCount'=>$categoryUncertifiedAgencyCount, 'agencyCertPercentage'=>$categoryCertPercentage];
        //$arraySize = sizeof($categoryCertStats);
    }
    $agencyTotalCount = $agencyTotalCount + $categoryAgencyTotal;
    $uncertifiedAgencyCount = $uncertifiedAgencyCount + $categoryUncertifiedAgencyCount;
}
$chartData[] = ['agencyTotalCount'=>$agencyTotalCount, 'uncertTotalCount'=>$uncertifiedAgencyCount, 'categoryCertStats'=>$categoryCertStats];
$chartJson = json_encode($chartData);