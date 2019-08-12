<?php
require_once('template/magic.php');
require_once('lib/secProc.php');
require_once('dbconn.php');

if(isset($_REQUEST['userId']))
{
	$userId = $_REQUEST['userId'];
}
else
{
    //
    $createdby = $loggedInUserId;
}

$lastname = $_REQUEST['lastname'];
$firstname = $_REQUEST['firstname'];
$midname = $_REQUEST['midname'];
$extname = $_REQUEST['extname'];
$contactmobile = $_REQUEST['contactmobile'];
$contactlandline = $_REQUEST['contactlandline'];
$contactemail = $_REQUEST['contactemail'];
$position = $_REQUEST['position'];
$govtagencyid = $_REQUEST['govtagencyid'];
$regionid = $_REQUEST['regionid'];
$provinceid = $_REQUEST['provinceid'];
$distdivid = $_REQUEST['distdivid'];
$citymunicipalityid = $_REQUEST['citymunicipalityid'];
$barangayid = $_REQUEST['barangayid'];
$usrname = $_REQUEST['usrname'];
$usrpassword = $_REQUEST['usrpassword'];

//for troubleshooting purposes only
echo "
$lastname,
$firstname,
$midname,
$extname,
$contactmobile,
$contactlandline,
$contactemail,
$position,
$govtagencyid,
$regionid,
$provinceid,
$distdivid,
$citymunicipalityid,
$barangayid,
$usrname,
$usrpassword,
$spices,
$userlevelid,
$isapproved,
$approvedby,
$approveddate,
$loggedInUserId
";
die();

$userlevelid= 'NULL';
if(isset($_REQUEST['userlevelid']))
{
    //
    $userlevelid = $_REQUEST['userlevelid'];
}

$isapproved = 'NULL';
$approvedby = 'NULL';
$approveddate = 'NULL';
if(isset($_REQUEST['isapproved']))
{
    //
    $isapproved = $_REQUEST['isapproved'];
    $approvedby = $loggedInUserId;
    $approveddate = 'NOW()';
}

$spices = create_salt();
$magicWord = create_hash($passWd, $spices);

if(isset($userId))
{
    $sqlQuery = "UPDATE systemusers set
        lastname = '$lastname',
        firstname = '$firstname',
        midname = '$midname',
        extname = '$extname',
        position = '$position',
        contactlandline = '$contactlandline',
        contactmobile = '$contactmobile',
        contactemail = '$contactemail',
        govtagencyid = '$govtagencyid',
        regionid = '$regionid',
        provinceid = '$provinceid',
        distdivid = '$distdivid',
        citymunicipalityid = '$citymunicipalityid',
        barangayid = '$barangayid',
        usrname = '$usrname',
        usrpassword = '$usrpassword',
        userlevelid = '$userlevelid'
        where id = '$userId'";  
}
else
{
    $sqlQuery = "INSERT INTO systemusers 
                    (
                        lastname,
                        firstname,
                        midname,
                        extname,
                        position,
                        contactlandline,
                        contactmobile,
                        contactemail,
                        govtagencyid,
                        regionid,
                        provinceid,
                        distdivid,
                        citymunicipalityid,
                        barangayid,
                        usrname,
                        usrpassword,
                        usrpasswdsalt,
                        userlevelid,
                        isapproved,
                        approvedby,
                        approveddate,
                        createdby,
                        creationdate
                    ) 
                VALUES
                    (
                        '$lastname',
                        '$firstname',
                        '$midname',
                        '$extname',
                        '$contactmobile',
                        '$contactlandline',
                        '$contactemail',
                        '$position',
                        '$govtagencyid',
                        '$regionid',
                        '$provinceid',
                        '$distdivid',
                        '$citymunicipalityid',
                        '$barangayid',
                        '$usrname',
                        '$usrpassword',
                        '$spices',
                        '$userlevelid',
                        '$isapproved',
                        '$approvedby',
                        '$approveddate',
                        '$loggedInUserId',
                        NOW()
                    )";
}

//for troubleshooting purposes only
echo $sqlQuery;
die();

if((strlen($lastname) > 0) && (strlen($firstname) > 0) && ($govtagencyid > 0) && (strlen($usrname) > 0) && (strlen($usrpassword) > 0))
{
    try
    {
        $dbh->beginTransaction();
        $sql= $sqlQuery;
        $dbh->query($sql);
        
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