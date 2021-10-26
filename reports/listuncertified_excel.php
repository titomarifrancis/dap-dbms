<?php
/** Error reporting */

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Asia/Manila');

if (PHP_SAPI == 'cli')
    die('This example should only be run from a Web Browser');

include '../dbconn.php';

require_once '../lib/Spout/Autoloader/autoload.php';
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;

$agencycategoryId = $_REQUEST['catid'];
$getCategoryLabel = "select agencyclassdesc from govtagencyclass where id=$agencycategoryId";
$getCategoryStmt = $dbh->query($getCategoryLabel)->fetchAll();
$agencyCategoryLabel = $getCategoryStmt[0]['agencyclassdesc'];



$writer = WriterEntityFactory::createCSVWriter();
$filename = "UncertifiedAgencyReport $agencyCategoryLabel'.csv";
$writer->openToBrowser($filename);

$headerRow = ['Agencies Without ISO-Certified QMS - '.$agencyCategoryLabel.''];

//$getAgenciesQuery = "select distinct govtagency.id as agencyid, govtagency.agencyname from govtagencyclass, govtagency, agencycertifications where agencycertifications.isapproved=true and agencycertifications.govtagencyid!=govtagency.id and govtagency.govtagencyclassid=govtagencyclass.id and govtagencyclass.id=$agencycategoryId order by govtagency.agencyname";
$getAgenciesQuery = "select govtagency.id as agencyid, govtagency.agencyname from govtagencyclass, govtagency where govtagency.govtagencyclassid=govtagencyclass.id and govtagencyclass.id=$agencycategoryId except select govtagency.id as agencyid, govtagency.agencyname from govtagency, agencycertifications where agencycertifications.govtagencyid = govtagency.id order by agencyname";
$agencyStmt= $dbh->query($getAgenciesQuery);

foreach($agencyStmt as $row)
{
    //
    $govtAgencyId = $row['agencyid'];
    $checkIfUncertified = "select govtagency.id, govtagency.agencyname as numActiveCertified from govtagency, agencycertifications where agencycertifications.govtagencyid=govtagency.id  and agencycertifications.isexpired=false and agencycertifications.isapproved=true and govtagency.id=$govtAgencyId";
    $checkUncertifiedCount = $dbh->query($checkIfUncertified)->rowCount();
    
    if($checkUncertifiedCount <= 0)
    {
        $agencyName = $row['agencyname'];
		
		$dataRowEntry = [$row['agencyname']];

		$rowFromValues = WriterEntityFactory::createRowFromArray($dataRowEntry);
		$writer->addRow($rowFromValues);
    }
}
$writer->openToFile('php://output');
$writer->close();

exit;
