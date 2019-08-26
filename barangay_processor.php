<?php
include 'templates/magic.php';
include 'dbconn.php';

$citymunicipalityid = $_REQUEST['citymunicipality'];
$barangayname = $_REQUEST['barangayname'];
$createdby = $loggedInUserId;

if(isset($citymunicipalityid) && ($citymunicipalityid > 0) && (strlen($barangayname) > 0))
{
    //insert date
    $sqlQuery = "INSERT INTO barangays(barangayname, citymunicipalityid, creationdate, createdby) VALUES('$barangayname', '$citymunicipalityid', 'NOW()', '$createdby')";
}

if(isset($citymunicipalityid) && ($citymunicipalityid > 0) && (strlen($barangayname) > 0))
{
    try
    {
        $dbh->beginTransaction();
        $dbh->query($sqlQuery);
        $dbh->commit();
    }
    catch(PDOException $e)
    {
        $dbh->rollback();
        echo "Failed to complete transaction: " . $e->getMessage() . "\n";
        exit;
    }
}

header("Location:$_SERVER[HTTP_REFERER]");