<?php
include 'templates/magic.php';
include 'dbconn.php';

$regionid = $_REQUEST['region'];
$provinceid = $_REQUEST['province'];
$towncitymunicipalityname = $_REQUEST['towncitymunicipalityname'];
$iscity = 'FALSE';
if($_REQUEST['iscity'] == 'on')
{
    $iscity = 'TRUE';
}
$createdby = $loggedInUserId;

if(isset($provinceid) && (($provinceid > 0) || ($provinceid !== 'Select region first')) && (isset($towncitymunicipalityname)) && (strlen($towncitymunicipalityname) > 0))
{
    //insert to DB
    $sqlQuery = "INSERT INTO citymunicipality(towncitymunicipalityname, iscity, provinceid, creationdate, createdby) values('$towncitymunicipalityname', '$iscity', '$provinceid', 'NOW()', '$createdby')";
}

if(isset($provinceid) && (($provinceid > 0) || ($provinceid !== 'Select region first')) && (isset($towncitymunicipalityname)) && (strlen($towncitymunicipalityname) > 0))
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