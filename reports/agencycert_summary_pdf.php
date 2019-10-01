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

include '../lib/TCPDF/tcpdf.php';

// create new PDF document
$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('EDGEKIT Computer Systems for DAP');
$pdf->SetTitle('Agency Certification Summary');
$pdf->SetSubject('Agency Certification Summary');
$pdf->SetKeywords('EDGEKIT, DAP, government, agency, certification');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_TITLE);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(15, PDF_MARGIN_TOP, 15);
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
$pdf->SetTextColor(255);
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.2);
$pdf->SetFont('', 'B');
// column titles
$header = array('Agency Category', 'Total Number of Agencies', 'Active Certifications', 'Active Certifications (%)', 'Uncertified Agencies', 'Uncertified Agencies (%)', 'Expired Certifications',);
$w = array(93, 25, 25, 25, 25, 25, 25, 25);
$num_headers = count($header);
$lineX= $pdf->getX();
for($i = 0; $i < $num_headers; ++$i) {

    $pdf->MultiCell($w[$i], 13, $header[$i], 0, 1, 'J', 0, $lineX);
    $lineX = $lineX + $w[$i];
}
$pdf->Ln();

// Color and font restoration
$pdf->SetFillColor(224, 235, 255);
$pdf->SetTextColor(0);
$pdf->SetFont('');

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


    $data = array($agencycategoryName, $numberTotalAgencyCount, $numberActiveCertified, $percentageActivecertified, $numberUncertifiedAgency, $percentageUncertified, $totalNumberExpiredCertification );
    $y = array(93, 25, 25, 25, 25, 25, 25, 25);
    $num_data = count($data);
    $lineX1= $pdf->getX();
    for($j = 0; $j < $num_data; ++$j) {

        $pdf->MultiCell($y[$j], 7, $data[$j], 0, 1, 'J', 0, $lineX1);
        $lineX1 = $lineX1 + $y[$j];
    }
    $pdf->Ln();
}

// reset pointer to the last page
$pdf->lastPage();

//Close and output PDF document
$pdf->Output('AgencyCertificationSummary.pdf', 'I');