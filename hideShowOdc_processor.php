<?php
include 'dbconn.php';

$certId = $_REQUEST['certId'];
$agencyId = $_REQUEST['govtagencyid'];
$hideODC = $_REQUEST['hideorigcertdate'];
//echo "CertID: $certId, AgencyID: $agencyId, HideODC: $hideODC<br/>";

$updateHideODC = "update govtagency set hideorigcertdate=$hideODC where id=$agencyId";
//echo "$updateHideODC<br/>";

if(($certId > 0) && ($agencyId > 0) && (strlen($updateHideODC) > 0))
{
    try
    {
        $dbh->beginTransaction();
        $dbh->query($updateHideODC);
        $dbh->commit();
    }
    catch(PDOException $e)
    {
        $dbh->rollback();
        echo "Failed to complete transaction: " . $e->getMessage() . "\n";
        exit;
    }
}

//jump back to agencycert_detailsec.php
header("Location:agencycert_detailsec.php?id=$certId");