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
$filename = "ActiveCertificationReport $agencyCategoryLabel'.csv";
$writer->openToBrowser($filename);

$headerRow = ['Name of Agency', 'Certifying Body','Certification', 'Valid From', 'Valid Until', 'Original Certification Date', 'Scope of Certification', 'Region', 'Province', 'City/Municipality'];

$rowFromValues = WriterEntityFactory::createRowFromArray($headerRow);
$writer->addRow($rowFromValues);

//national
$getAgenciesQueryNational = "select agencycertifications.id as agencycertificationid, govtagency.id as govtagencyid, govtagency.agencyname as agencyname, certifyingbody.providerorg as certifyingbody, certifications.certificationstandard as certificationdesc, agencycertifications.certvalidstartdate as certstartdate, agencycertifications.certvalidenddate as certenddate, agencycertifications.scope_ispartial as ispartial, govtagency.hideorigcertdate as hideodc from govtagencyclass, govtagency, certifyingbody, certifications, agencycertifications where agencycertifications.isapproved=true and agencycertifications.govtagencyid=govtagency.id and agencycertifications.certifyingbodyid=certifyingbody.id and agencycertifications.certificationid=certifications.id and govtagency.govtagencyclassid=govtagencyclass.id and agencycertifications.regionid is NULL and agencycertifications.provinceid is NULL and agencycertifications.citymunicipalityid is NULL and agencycertifications.isexpired=false and govtagencyclass.id=$agencycategoryId order by agencyname";
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
        $ishideodc = $row['hideodc'];
        $myODC = $origCertdate;
        if($ishideodc == 1)
        {
            //
            $myODC = "N/A";
        }
		
		$dataRowEntry = [$row['agencyname'],$row['certifyingbody'],$row['certificationdesc'],$row['certstartdate'],$row['certenddate'],$myODC,$isPartial,'', '', ''];

		$rowFromValues = WriterEntityFactory::createRowFromArray($dataRowEntry);
		$writer->addRow($rowFromValues);
    }
}

//regional
$getAgenciesQueryRegional = "select agencycertifications.id as agencycertificationid, govtagency.id as govtagencyid, govtagency.agencyname as agencyname, certifyingbody.providerorg as certifyingbody, certifications.certificationstandard as certificationdesc, agencycertifications.certvalidstartdate as certstartdate, agencycertifications.certvalidenddate as certenddate, agencycertifications.scope_ispartial as ispartial, govtagency.hideorigcertdate as hideodc, regions.regionname from govtagencyclass, govtagency, certifyingbody, certifications, agencycertifications, regions where agencycertifications.isapproved=true and agencycertifications.govtagencyid=govtagency.id and agencycertifications.certifyingbodyid=certifyingbody.id and agencycertifications.certificationid=certifications.id and govtagency.govtagencyclassid=govtagencyclass.id and agencycertifications.isexpired=false and agencycertifications.regionid=regions.id and agencycertifications.provinceid is NULL and citymunicipalityid is NULL and govtagencyclass.id=$agencycategoryId order by agencyname";
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
        $ishideodc = $row['hideodc'];
        $myODC = $origCertdate;
        if($ishideodc == 1)
        {
            //
            $myODC = "N/A";
        } 
		$dataRowEntry = [$row['agencyname'],$row['certifyingbody'],$row['certificationdesc'],$row['certstartdate'],$row['certenddate'],$myODC,$isPartial,$row['regionname'], '', ''];

		$rowFromValues = WriterEntityFactory::createRowFromArray($dataRowEntry);
		$writer->addRow($rowFromValues);
    }
}

//provincial
$getAgenciesQueryProvincial = "select agencycertifications.id as agencycertificationid, govtagency.id as govtagencyid, govtagency.agencyname as agencyname, certifyingbody.providerorg as certifyingbody, certifications.certificationstandard as certificationdesc, agencycertifications.certvalidstartdate as certstartdate, agencycertifications.certvalidenddate as certenddate, agencycertifications.scope_ispartial as ispartial, govtagency.hideorigcertdate as hideodc, regions.regionname, provinces.provincename from govtagencyclass, govtagency, certifyingbody, certifications, agencycertifications, regions, provinces where agencycertifications.isapproved=true and agencycertifications.govtagencyid=govtagency.id and agencycertifications.certifyingbodyid=certifyingbody.id and agencycertifications.certificationid=certifications.id and govtagency.govtagencyclassid=govtagencyclass.id and agencycertifications.isexpired=false and agencycertifications.regionid=regions.id and agencycertifications.provinceid=provinces.id and agencycertifications.citymunicipalityid is NULL and govtagencyclass.id=$agencycategoryId order by agencyname";
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
        $ishideodc = $row['hideodc'];
        $myODC = $origCertdate;
        if($ishideodc == 1)
        {
            //
            $myODC = "N/A";
        }
		$dataRowEntry = [$row['agencyname'],$row['certifyingbody'],$row['certificationdesc'],$row['certstartdate'],$row['certenddate'],$myODC,$isPartial,$row['regionname'], $row['provincename'], ''];

		$rowFromValues = WriterEntityFactory::createRowFromArray($dataRowEntry);
		$writer->addRow($rowFromValues);
    }
}

//city/municipal
$getAgenciesQueryCityMunicipal = "select agencycertifications.id as agencycertificationid, govtagency.id as govtagencyid, govtagency.agencyname as agencyname, certifyingbody.providerorg as certifyingbody, certifications.certificationstandard as certificationdesc, agencycertifications.certvalidstartdate as certstartdate, agencycertifications.certvalidenddate as certenddate, agencycertifications.scope_ispartial as ispartial, govtagency.hideorigcertdate as hideodc, regions.regionname, provinces.provincename, citymunicipality.towncitymunicipalityname from govtagencyclass, govtagency, certifyingbody, certifications, agencycertifications, regions, provinces, citymunicipality where agencycertifications.isapproved=true and agencycertifications.govtagencyid=govtagency.id and agencycertifications.certifyingbodyid=certifyingbody.id and agencycertifications.certificationid=certifications.id and govtagency.govtagencyclassid=govtagencyclass.id and agencycertifications.isexpired=false and agencycertifications.regionid=regions.id and agencycertifications.provinceid=provinces.id and agencycertifications.citymunicipalityid=citymunicipality.id and govtagencyclass.id=$agencycategoryId order by agencyname";
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
        $ishideodc = $row['hideodc'];
        $myODC = $origCertdate;
        if($ishideodc == 1)
        {
            //
            $myODC = "N/A";
        }
		
		$dataRowEntry = [$row['agencyname'],$row['certifyingbody'],$row['certificationdesc'],$row['certstartdate'],$row['certenddate'],$myODC,$isPartial,$row['regionname'], $row['provincename'], $row['towncitymunicipalityname']];

		$rowFromValues = WriterEntityFactory::createRowFromArray($dataRowEntry);
		$writer->addRow($rowFromValues);
    }
}
$writer->openToFile('php://output');
$writer->close();

exit;
