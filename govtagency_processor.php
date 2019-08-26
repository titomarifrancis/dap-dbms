<?php
include 'templates/magic.php';
include 'dbconn.php';

$agencyname = $_REQUEST['agencyname'];
$govtagencyclassid = $_REQUEST['govtagencyclassid'];
$createdby = $loggedInUserId;
//$temp_parentgovtagencyid = $_REQUEST['parentgovtagencyid'];

//echo $temp_parentgovtagencyid;
//die();

$paramList = "agencyname, govtagencyclassid, createdby, creationdate";
$sqlQuery = "INSERT INTO govtagency($paramList) VALUES('$agencyname', $govtagencyclassid, $createdby, 'NOW()')";

$parentgovtagencyid = '';
if(isset($_REQUEST['parentgovtagencyid']) and ($_REQUEST['parentgovtagencyid'] > 0))
{
    $parentgovtagencyid = $_REQUEST['parentgovtagencyid'];
    $paramList = "agencyname, govtagencyclassid, parentgovtagencyid, createdby, creationdate";
    $sqlQuery = "INSERT INTO govtagency($paramList) VALUES('$agencyname', $govtagencyclassid, $parentgovtagencyid, $createdby, 'NOW()')";
}

if(isset($agencyname) and (strlen($agencyname) > 0))
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