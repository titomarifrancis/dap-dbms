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
$objSheet->setTitle('Active Certifications');


$objPHPExcel->getProperties()->setCreator("Tito Mari Francis H. Escano")
							 ->setLastModifiedBy("Tito Mari Francis H. Escano")
							 ->setTitle("EDGEKIT Computer Systems Report Document")
							 ->setSubject("Active Certification Report")
							 ->setDescription("EDGEKIT Computer Systems Report Document, generated using PHP classes.")
							 ->setKeywords("EDGEKIT active certification report document php")
                             ->setCategory("EDGEKIT Computer Systems Report Document");

$objSheet->getColumnDimension('A')->setAutoSize(true);
$objSheet->getColumnDimension('B')->setAutoSize(true);
$objSheet->getColumnDimension('C')->setAutoSize(true);
$objSheet->getColumnDimension('D')->setAutoSize(true);
$objSheet->getColumnDimension('E')->setAutoSize(true);
$objSheet->getColumnDimension('F')->setAutoSize(true);
$objSheet->getColumnDimension('G')->setAutoSize(true);
$objSheet->getColumnDimension('H')->setAutoSize(true);
$objSheet->getColumnDimension('I')->setAutoSize(true);
$objSheet->getColumnDimension('J')->setAutoSize(true);

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Name of Agency')
            ->setCellValue('B1', 'Certifying Body')        
            ->setCellValue('C1', 'Certification')
            ->setCellValue('D1', 'Valid From')
            ->setCellValue('E1', 'Valid Until')
            ->setCellValue('F1', 'Original Certification Date')
            ->setCellValue('G1', 'Scope of Certification')
            ->setCellValue('H1', 'Region')
            ->setCellValue('I1', 'Province')
            ->setCellValue('J1', 'City/Municipality');            

$cellCounter=2;

//national
$getAgenciesQueryNational = "select agencycertifications.id as agencycertificationid, govtagency.id as govtagencyid, govtagency.agencyname as agencyname, certifyingbody.providerorg as certifyingbody, certifications.certificationstandard as certificationdesc, agencycertifications.certvalidstartdate as certstartdate, agencycertifications.certvalidenddate as certenddate, agencycertifications.scope_ispartial as ispartial from govtagencyclass, govtagency, certifyingbody, certifications, agencycertifications where agencycertifications.isapproved=true and agencycertifications.govtagencyid=govtagency.id and agencycertifications.certifyingbodyid=certifyingbody.id and agencycertifications.certificationid=certifications.id and govtagency.govtagencyclassid=govtagencyclass.id and agencycertifications.regionid is NULL and agencycertifications.provinceid is NULL and agencycertifications.citymunicipalityid is NULL and agencycertifications.isexpired=false and govtagencyclass.id=$agencycategoryId order by agencyname";
//echo "$getAgenciesQueryNational<br/>";
$numrecordsNational = $dbh->query($getAgenciesQueryNational)->rowCount();
if($numrecordsNational > 0)
{
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

        $objSheet
        ->setCellValue('A' . $cellCounter, $row['agencyname'])
        ->setCellValue('B' . $cellCounter, $row['certifyingbody'])
        ->setCellValue('C' . $cellCounter, $row['certificationdesc'])
        ->setCellValue('D' . $cellCounter, $row['certstartdate'])
        ->setCellValue('E' . $cellCounter, $row['certenddate'])
        ->setCellValue('F' . $cellCounter, $origCertdate)
        ->setCellValue('G' . $cellCounter, $isPartial)
        ->setCellValue('H' . $cellCounter, '')
        ->setCellValue('I' . $cellCounter, '')
        ->setCellValue('J' . $cellCounter, ''); 

        $cellCounter++;
    }
}

//regional
$getAgenciesQueryRegional = "select agencycertifications.id as agencycertificationid, govtagency.id as govtagencyid, govtagency.agencyname as agencyname, certifyingbody.providerorg as certifyingbody, certifications.certificationstandard as certificationdesc, agencycertifications.certvalidstartdate as certstartdate, agencycertifications.certvalidenddate as certenddate, agencycertifications.scope_ispartial as ispartial, regions.regionname from govtagencyclass, govtagency, certifyingbody, certifications, agencycertifications, regions where agencycertifications.isapproved=true and agencycertifications.govtagencyid=govtagency.id and agencycertifications.certifyingbodyid=certifyingbody.id and agencycertifications.certificationid=certifications.id and govtagency.govtagencyclassid=govtagencyclass.id and agencycertifications.isexpired=false and agencycertifications.regionid=regions.id and agencycertifications.provinceid is NULL and citymunicipalityid is NULL and govtagencyclass.id=$agencycategoryId order by agencyname";
//echo "$getAgenciesQueryRegional<br/>";
$numrecordsRegional = $dbh->query($getAgenciesQueryRegional)->rowCount();
if($numrecordsRegional > 0)
{
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

        $objSheet
        ->setCellValue('A' . $cellCounter, $row['agencyname'])
        ->setCellValue('B' . $cellCounter, $row['certifyingbody'])
        ->setCellValue('C' . $cellCounter, $row['certificationdesc'])
        ->setCellValue('D' . $cellCounter, $row['certstartdate'])
        ->setCellValue('E' . $cellCounter, $row['certenddate'])
        ->setCellValue('F' . $cellCounter, $origCertdate)
        ->setCellValue('G' . $cellCounter, $isPartial)
        ->setCellValue('H' . $cellCounter, $row['regionname'])
        ->setCellValue('I' . $cellCounter, '')
        ->setCellValue('J' . $cellCounter, ''); 

        $cellCounter++;
    }
}

//provincial
$getAgenciesQueryProvincial = "select agencycertifications.id as agencycertificationid, govtagency.id as govtagencyid, govtagency.agencyname as agencyname, certifyingbody.providerorg as certifyingbody, certifications.certificationstandard as certificationdesc, agencycertifications.certvalidstartdate as certstartdate, agencycertifications.certvalidenddate as certenddate, agencycertifications.scope_ispartial as ispartial, regions.regionname, provinces.provincename from govtagencyclass, govtagency, certifyingbody, certifications, agencycertifications, regions, provinces where agencycertifications.isapproved=true and agencycertifications.govtagencyid=govtagency.id and agencycertifications.certifyingbodyid=certifyingbody.id and agencycertifications.certificationid=certifications.id and govtagency.govtagencyclassid=govtagencyclass.id and agencycertifications.isexpired=false and agencycertifications.regionid=regions.id and agencycertifications.provinceid=provinces.id and agencycertifications.citymunicipalityid is NULL and govtagencyclass.id=$agencycategoryId order by agencyname";
//echo "$getAgenciesQueryProvincial<br/>";
$numrecordsProvincial = $dbh->query($getAgenciesQueryProvincial)->rowCount();
if($numrecordsProvincial > 0)
{
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

        $objSheet
        ->setCellValue('A' . $cellCounter, $row['agencyname'])
        ->setCellValue('B' . $cellCounter, $row['certifyingbody'])
        ->setCellValue('C' . $cellCounter, $row['certificationdesc'])
        ->setCellValue('D' . $cellCounter, $row['certstartdate'])
        ->setCellValue('E' . $cellCounter, $row['certenddate'])
        ->setCellValue('F' . $cellCounter, $origCertdate)
        ->setCellValue('G' . $cellCounter, $isPartial)
        ->setCellValue('H' . $cellCounter, $row['regionname'])
        ->setCellValue('I' . $cellCounter, $row['provincename'])
        ->setCellValue('J' . $cellCounter, ''); 

        $cellCounter++;
    }
}

//city/municipal
$getAgenciesQueryCityMunicipal = "select agencycertifications.id as agencycertificationid, govtagency.id as govtagencyid, govtagency.agencyname as agencyname, certifyingbody.providerorg as certifyingbody, certifications.certificationstandard as certificationdesc, agencycertifications.certvalidstartdate as certstartdate, agencycertifications.certvalidenddate as certenddate, agencycertifications.scope_ispartial as ispartial, regions.regionname, provinces.provincename, citymunicipality.towncitymunicipalityname from govtagencyclass, govtagency, certifyingbody, certifications, agencycertifications, regions, provinces, citymunicipality where agencycertifications.isapproved=true and agencycertifications.govtagencyid=govtagency.id and agencycertifications.certifyingbodyid=certifyingbody.id and agencycertifications.certificationid=certifications.id and govtagency.govtagencyclassid=govtagencyclass.id and agencycertifications.isexpired=false and agencycertifications.regionid=regions.id and agencycertifications.provinceid=provinces.id and agencycertifications.citymunicipalityid=citymunicipality.id and govtagencyclass.id=$agencycategoryId order by agencyname";
//echo "$getAgenciesQueryCityMunicipal<br/>";
$numrecordsMunicipal = $dbh->query($getAgenciesQueryCityMunicipal)->rowCount();
if($numrecordsMunicipal > 0)
{
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

        $objSheet
        ->setCellValue('A' . $cellCounter, $row['agencyname'])
        ->setCellValue('B' . $cellCounter, $row['certifyingbody'])
        ->setCellValue('C' . $cellCounter, $row['certificationdesc'])
        ->setCellValue('D' . $cellCounter, $row['certstartdate'])
        ->setCellValue('E' . $cellCounter, $row['certenddate'])
        ->setCellValue('F' . $cellCounter, $origCertdate)
        ->setCellValue('G' . $cellCounter, $isPartial)
        ->setCellValue('H' . $cellCounter, $row['regionname'])
        ->setCellValue('I' . $cellCounter, $row['provincename'])
        ->setCellValue('J' . $cellCounter, $row['towncitymunicipalityname']); 

        $cellCounter++;
    }
}

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="ActiveCertificationReport - '.$agencyCategoryLabel.'.xlsx"');
header('Cache-Control: max-age=1');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//$objWriter->save('output/AgencyCertificationSummaryReport.xlsx');
$objWriter->save('php://output');
exit;