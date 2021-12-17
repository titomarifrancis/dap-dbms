<?php
/** Error reporting */

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Asia/Manila');

if (PHP_SAPI == 'cli')
    die('This example should only be run from a Web Browser');

include '../dbconn.php';

$dateStamp = date('Ymd');

require_once '../lib/Spout/Autoloader/autoload.php';
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;
$writer = WriterEntityFactory::createCSVWriter();
$filename = "AgencyCertificationSummaryReport $dateStamp'.csv";
$writer->openToBrowser($filename);

$getAgencyCategory = "select id, agencyclassdesc from govtagencyclass";
$getAgencyCategoryStmt = $dbh->query($getAgencyCategory);
$agencyCategoryArray = $getAgencyCategoryStmt->fetchAll();

$headerRow = ['Agency Category','Total Number of Agencies','Active Certifications','Active Certifications (%)','Agencies Without ISO Certification', 'Agencies Without ISO Certification (%)', 'Expired Certifications'];

$rowFromValues = WriterEntityFactory::createRowFromArray($headerRow);
$writer->addRow($rowFromValues);

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
	
	$dataRowEntry = [$agencycategoryName,$numberTotalAgencyCount,$numberActiveCertified,$percentageActivecertified,$numberUncertifiedAgency,$percentageUncertified,$totalNumberExpiredCertification];

	$rowFromValues = WriterEntityFactory::createRowFromArray($dataRowEntry);
	$writer->addRow($rowFromValues);

}

$writer->openToFile('php://output');
$writer->close();

exit;