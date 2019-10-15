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
$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('EDGEKIT Computer Systems for DAP');
$pdf->SetTitle('Uncertified Agency List Report');
$pdf->SetSubject('Uncertified Agency List Report');
$pdf->SetKeywords('EDGEKIT, DAP, government, agency, uncertified');

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
$pdf->SetLineWidth(0.1);
$pdf->SetFont('', 'B');
// column titles
$header = array('Agencies Without ISO-Certified QMS - '.$agencyCategoryLabel.'');
$w = array(180);
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

//$getAgenciesQuery = "select distinct govtagency.id as agencyid, govtagency.agencyname from govtagencyclass, govtagency, agencycertifications where agencycertifications.isapproved=true and agencycertifications.govtagencyid!=govtagency.id and govtagency.govtagencyclassid=govtagencyclass.id and govtagencyclass.id=$agencycategoryId order by govtagency.agencyname";
$getAgenciesQuery = "select govtagency.id as agencyid, govtagency.agencyname from govtagencyclass, govtagency where govtagency.govtagencyclassid=govtagencyclass.id and govtagencyclass.id=$agencycategoryId except select govtagency.id as agencyid, govtagency.agencyname from govtagency, agencycertifications where agencycertifications.govtagencyid = govtagency.id order by agencyname";
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
        $data = array($agencyName);
        $y = array(180);
        $num_data = count($data);
        $lineX1= $pdf->getX();
        $lineY1= $pdf->getY();
        for($j = 0; $j < $num_data; ++$j) {
    
            $pdf->MultiCell($y[$j], 7, $data[$j], 1, 1, 'J', 0, $lineX1);
            $lineX1 = $lineX1 + $y[$j];
        }
        $pdf->Ln();
        if($lineY1 >= 263)
        {
            $pdf->AddPage();
        }
    }
}

// reset pointer to the last page
$pdf->lastPage();

//Close and output PDF document
$pdf->Output('UncertifiedAgencyReport-'.$agencyCategoryLabel.'.pdf', 'I');