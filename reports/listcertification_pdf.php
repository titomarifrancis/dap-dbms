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

include '../lib/TCPDF/tcpdf.php';

// create new PDF document
$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('EDGEKIT Computer Systems for DAP');
$pdf->SetTitle('Active Certification Report');
$pdf->SetSubject('Active Certification Report');
$pdf->SetKeywords('EDGEKIT, DAP, government, aactive, certification');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_TITLE);
$pdf->SetHeaderData($ht='Active Certification Report');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(15, 10, 15);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set font
$pdf->SetFont('helvetica', '', 9);

// add a page
$pdf->AddPage();

$pdf->SetFillColor(46, 49, 146);
$pdf->SetTextColor(0);
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.2);
$pdf->SetFont('', 'B');

$pdf->Cell(150, 20, 'Active Certification Report - '.$agencyCategoryLabel.'', 0, 1, '', 0, '', 0);
//$pdf->Ln();
$pdf->SetTextColor(255);
// column titles
$header = array('Name of Agency', 'Certifying Body', 'Certification', 'Valid From', 'Valid Until', 'Original Certification Date', 'Scope of Certification', 'Region', 'Province', 'City/Municipality');
$w = array(45, 32, 25, 20, 20, 25, 25, 25, 25, 25);
$num_headers = count($header);
$lineX= $pdf->getX();
for($i = 0; $i < $num_headers; ++$i) {

    $pdf->MultiCell($w[$i], 20, $header[$i], 1, 1, 'J', 0, $lineX);
    $lineX = $lineX + $w[$i];
}
$pdf->Ln();

// Color and font restoration
$pdf->SetFillColor(224, 235, 255);
$pdf->SetTextColor(0);
$pdf->SetFont('');

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

        $data = array($row['agencyname'], $row['certifyingbody'], $row['certificationdesc'], $row['certstartdate'], $row['certenddate'], $origCertdate, $isPartial, '', '', '');
        $y = array(45, 32, 25, 20, 20, 25, 25, 25, 25, 25);
        $num_data = count($data);
        $lineX1= $pdf->getX();
        $lineY1= $pdf->getY();
        for($j = 0; $j < $num_data; ++$j) {
    
            $pdf->MultiCell($y[$j], 20, $data[$j], 1, 1, 'J', 0, $lineX1);
            $lineX1 = $lineX1 + $y[$j];
        }
        $pdf->Ln();
        if($lineY1 >= 150)
        {
            $pdf->AddPage();
        }
    }
}

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

        $data = array($row['agencyname'], $row['certifyingbody'], $row['certificationdesc'], $row['certstartdate'], $row['certenddate'], $origCertdate, $isPartial, $row['regionname'], '', '');
        $y = array(45, 32, 25, 20, 20, 25, 25, 25, 25, 25);
        $num_data = count($data);
        $lineX1= $pdf->getX();
        $lineY1= $pdf->getY();
        for($j = 0; $j < $num_data; ++$j) {
    
            $pdf->MultiCell($y[$j], 20, $data[$j], 1, 1, 'J', 0, $lineX1);
            $lineX1 = $lineX1 + $y[$j];
        }
        $pdf->Ln();
        if($lineY1 >= 150)
        {
            $pdf->AddPage();
        }
    }
}

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

        $data = array($row['agencyname'], $row['certifyingbody'], $row['certificationdesc'], $row['certstartdate'], $row['certenddate'], $origCertdate, $isPartial, $row['regionname'], $row['provincename'], '');
        $y = array(45, 32, 25, 20, 20, 25, 25, 25, 25, 25);
        $num_data = count($data);
        $lineX1= $pdf->getX();
        $lineY1= $pdf->getY();
        for($j = 0; $j < $num_data; ++$j) {
    
            $pdf->MultiCell($y[$j], 20, $data[$j], 1, 1, 'J', 0, $lineX1);
            $lineX1 = $lineX1 + $y[$j];
        }
        $pdf->Ln();
        if($lineY1 >= 150)
        {
            $pdf->AddPage();
        }
    }
}

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

        $data = array($row['agencyname'], $row['certifyingbody'], $row['certificationdesc'], $row['certstartdate'], $row['certenddate'], $origCertdate, $isPartial, $row['regionname'], $row['provincename'], $row['towncitymunicipalityname']);
        $y = array(45, 32, 25, 20, 20, 25, 25, 25, 25, 25);
        $num_data = count($data);
        $lineX1= $pdf->getX();
        $lineY1= $pdf->getY();
        for($j = 0; $j < $num_data; ++$j) {
    
            $pdf->MultiCell($y[$j], 20, $data[$j], 1, 1, 'J', 0, $lineX1);
            $lineX1 = $lineX1 + $y[$j];
        }
        $pdf->Ln();
        if($lineY1 >= 150)
        {
            $pdf->AddPage();
        }
    }
}

// reset pointer to the last page
$pdf->lastPage();

//Close and output PDF document
$pdf->Output('ActiveCertificationReport - '.$agencyCategoryLabel.'.pdf', 'I');