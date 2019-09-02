<?php
include 'templates/magic.php';
include 'dbconn.php';

$agencyCertId = $_REQUEST['agencycertid'];
$isapproved = $_REQUEST['isapproved'];
if($isapproved == 'true')
{
    //
    $approvedby = $loggedInUserId;
    $sqlQuery = "UPDATE agencycertifications SET isapproved='$isapproved', approvedby='$approvedby', approveddate='NOW()' WHERE id=$agencyCertId";

}

//for troubleshooting purposes only
//echo $sqlQuery;
//die();

if($agencyCertId > 0 && $isapproved <> false)
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

//jump to agencycertification.php
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'agencycertification.php';
header("Location: http://$host$uri/$extra");
exit;