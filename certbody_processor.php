<?php
include 'templates/magic.php';
include 'dbconn.php';

$providerorgid = $_REQUEST['providerorgid'];
$providerorg = $_REQUEST['providerorg'];
$ispabaccredited = $_REQUEST['ispabaccredited'];
$isapproved = $_REQUEST['isapproved'];

//echo "$providerorgid, $providerorg, $ispabaccredited, $isapproved<br/>";
//die();

if(isset($loggedInAccessLevel) && ($loggedInAccessLevel < 2))
{
    //just a client agency
    $ispabaccredited = '0';
    $isapproved = '0';
    $sqlQuery = "INSERT INTO certifyingbody(ispabaccredited, providerorg, isapproved, createdby, creationdate) values('FALSE', '$providerorg', 'FALSE', $loggedInUserId, 'NOW()')";
}
if(isset($loggedInAccessLevel) && ($loggedInAccessLevel > 1) && (isset($providerorgid)))
{
    //$sqlQuery = "UPDATE certifyingbody SET ispabaccredited='$ispabaccredited' AND providerorg='$providerorg' AND isapproved='$isapproved' WHERE id=$providerorgid";
    if($isapproved == 'true')
    {
        $sqlQuery = "UPDATE certifyingbody SET ispabaccredited='$ispabaccredited', providerorg='$providerorg', isapproved='1', approvedby='$loggedInUserId' WHERE id=$providerorgid";
    }
    else
    {
        $sqlQuery = "UPDATE certifyingbody SET ispabaccredited='$ispabaccredited', providerorg='$providerorg', isapproved='0' WHERE id=$providerorgid";
    }
    
}

//echo $sqlQuery;
//die();

if(strlen($providerorg) > 0)
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