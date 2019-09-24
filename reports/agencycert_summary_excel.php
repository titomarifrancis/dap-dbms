<?php
/** Error reporting */

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Asia/Manila');

if (PHP_SAPI == 'cli')
    die('This example should only be run from a Web Browser');

include '../dbconn.php';

$getAgencyCategory = "select id, agencyclassdesc from govtagencyclass";
$getAgencyCategoryStmt = $dbh->query($getAgencyCategory);
$agencyCategoryArray = $getAgencyCategoryStmt->fetchAll();

include '../lib/PHPExcel2014/PHPExcel.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(12);



$objSheet = $objPHPExcel->getActiveSheet();
$objSheet->setTitle('Agency Certification Report');


$objPHPExcel->getProperties()->setCreator("Tito Mari Francis H. Escano")
							 ->setLastModifiedBy("Tito Mari Francis H. Escano")
							 ->setTitle("EDGEKIT Computer Systems Report Document")
							 ->setSubject("Agency Certification Report")
							 ->setDescription("EDGEKIT Computer Systems Report Document, generated using PHP classes.")
							 ->setKeywords("EDGEKIT agency certification report document php")
                             ->setCategory("EDGEKIT Computer Systems Report Document");

$objSheet->getColumnDimension('A')->setAutoSize(true);
$objSheet->getColumnDimension('B')->setAutoSize(true);
$objSheet->getColumnDimension('C')->setAutoSize(true);
$objSheet->getColumnDimension('D')->setAutoSize(true);
$objSheet->getColumnDimension('E')->setAutoSize(true);
$objSheet->getColumnDimension('F')->setAutoSize(true);
$objSheet->getColumnDimension('G')->setAutoSize(true);
$objSheet->getColumnDimension('H')->setAutoSize(true);

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Agency Category')
            ->setCellValue('B1', 'Total Number of Agencies')        
            ->setCellValue('C1', 'Active Certifications')
            ->setCellValue('D1', 'Active Certifications (%)')
            ->setCellValue('E1', 'Expired Certifications')
            ->setCellValue('F1', 'Expired Certifications (%)')
            ->setCellValue('G1', 'Uncertified Agencies')
            ->setCellValue('H1', 'Uncertified Agencies (%)');

$cellCounter=2;

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
        $lastCertificationStatus = $getLastCertificationStatusArray;
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

    $objSheet
            ->setCellValue('A' . $cellCounter, $agencycategoryName)
            ->setCellValue('B' . $cellCounter, $numberTotalAgencyCount)
            ->setCellValue('C' . $cellCounter, $numberActiveCertified)
            ->setCellValue('D' . $cellCounter, $percentageActivecertified)
            ->setCellValue('E' . $cellCounter, $totalNumberExpiredCertification)
            ->setCellValue('F' . $cellCounter, $percentageExpired)
            ->setCellValue('G' . $cellCounter, $numberUncertifiedAgency)
            ->setCellValue('H' . $cellCounter, $percentageUncertified);
    $cellCounter++;
}

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="AgencyCertificationSummaryReport.xlsx"');
header('Cache-Control: max-age=1');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//$objWriter->save('output/AgencyCertificationSummaryReport.xlsx');
$objWriter->save('php://output');
exit;