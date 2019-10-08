<?php
/** Error reporting */

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Asia/Manila');

if (PHP_SAPI == 'cli')
    die('This example should only be run from a Web Browser');

include '../dbconn.php';

$agencycategoryId = $_REQUEST['catid'];
$getCategoryLabel = "select agencyclassdesc from govtagencyclass where id=$agencycategoryId";
$getCategoryStmt = $dbh->query($getCategoryLabel)->fetchAll();
$agencyCategoryLabel = $getCategoryStmt[0]['agencyclassdesc'];

include '../lib/PHPExcel2014/PHPExcel.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(12);



$objSheet = $objPHPExcel->getActiveSheet();
$title = substr($agencyCategoryLabel, 0, 24);
$objSheet->setTitle($title);


$objPHPExcel->getProperties()->setCreator("Tito Mari Francis H. Escano")
							 ->setLastModifiedBy("Tito Mari Francis H. Escano")
							 ->setTitle("EDGEKIT Computer Systems Report Document")
							 ->setSubject("Uncertified Agency List Report")
							 ->setDescription("EDGEKIT Computer Systems Report Document, generated using PHP classes.")
							 ->setKeywords("EDGEKIT agency uncertified report document php")
                             ->setCategory("EDGEKIT Computer Systems Report Document");

$objSheet->getColumnDimension('A')->setAutoSize(true);

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Agencies Without ISO-Certified QMS - '.$agencyCategoryLabel.'');

$getAgenciesQuery = "select distinct govtagency.id as agencyid, govtagency.agencyname from govtagencyclass, govtagency, agencycertifications where agencycertifications.isapproved=true and agencycertifications.govtagencyid!=govtagency.id and govtagency.govtagencyclassid=govtagencyclass.id and govtagencyclass.id=$agencycategoryId order by govtagency.agencyname";
$agencyStmt= $dbh->query($getAgenciesQuery);

$cellCounter=2;
foreach($agencyStmt as $row)
{
    //
    $govtAgencyId = $row['agencyid'];
    $checkIfUncertified = "select govtagency.id, govtagency.agencyname as numActiveCertified from govtagency, agencycertifications where agencycertifications.govtagencyid=govtagency.id  and agencycertifications.isexpired=false and agencycertifications.isapproved=true and govtagency.id=$govtAgencyId";
    $checkUncertifiedCount = $dbh->query($checkIfUncertified)->rowCount();
    
    if($checkUncertifiedCount <= 0)
    {
        $agencyName = $row['agencyname'];
        $objSheet
            ->setCellValue('A' . $cellCounter, $agencyName);
        $cellCounter++;
    }
    //$cellCounter++;
}


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
/*
$objPHPExcel->getActiveSheet()->getProtection()->setSelectLockedCells(true);
$objPHPExcel->getActiveSheet()->getProtection()->setSelectUnlockedCells(true);
$objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);
$objPHPExcel->getActiveSheet()->getProtection()->setFormatRows(true);
$objPHPExcel->getActiveSheet()->getProtection()->setInsertColumns(true);
$objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
$objPHPExcel->getActiveSheet()->getProtection()->setInsertHyperlinks(true);
$objPHPExcel->getActiveSheet()->getProtection()->setDeleteColumns(true);
$objPHPExcel->getActiveSheet()->getProtection()->setDeleteRows(true);
$objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
$objPHPExcel->getActiveSheet()->getProtection()->setAutofilter(true);
$objPHPExcel->getActiveSheet()->getProtection()->setObjects(true);
$objPHPExcel->getActiveSheet()->getProtection()->setScenarios(true);
$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
$objPHPExcel->getActiveSheet()->getProtection()->setPassword('password');
*/

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="UncertifiedAgencyReport-'.$agencyCategoryLabel.'.xlsx"');
header('Cache-Control: max-age=1');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//$objWriter->save('output/AgencyCertificationSummaryReport.xlsx');
$objWriter->save('php://output');
exit;