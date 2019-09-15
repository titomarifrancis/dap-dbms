<?php
include 'lib/secProc.php';
include 'dbconn.php';

// Sanitize incoming username and password
$username= $_POST['usernameField'];
$password= $_POST['passwordField'];

//verify from DB that username provided exists
$loginUsernameQuery= "select id, concat(firstname, ' ',lastname) as fullname, govtagencyid, regionid, provinceid, citymunicipalityid, barangayid, usrname, usrpassword, usrpasswdsalt, userlevelid from systemusers where usrname='$username' and isapproved='TRUE'";

//for troubleshooting purposes only
//echo "$loginUsernameQuery<br/>";
//die();

$loginStmt= $dbh->query($loginUsernameQuery) or die(print_r($dbh->errorInfo(), true));

foreach($loginStmt as $loginRow)
{
    $userIdent= $loginRow['id'];
    $userRealName= $loginRow['fullname'];
    $dbProvPasswd= $loginRow['usrpassword'];
    $dbProvPasswdSalt= $loginRow['usrpasswdsalt'];
    $accessLevelId= $loginRow['userlevelid'];
    $govtAgencyId= $loginRow['govtagencyid'];
    $regionId= $loginRow['regionid'];
    $provinceId= $loginRow['provinceid'];
    $cityMunicipalityId= $loginRow['citymunicipalityid'];
    $barangayId= $loginRow['barangayid'];
}

/*
//for troubleshooting purposes only
echo "you are 
$userIdent, 
$userRealName, 
$dbProvPasswd,
$dbProvPasswdSalt, 
$accessLevelId, 
$govtAgencyId, 
$regionId, 
$provinceId, 
$distdivId, 
$cityMunicipalityId, 
$barangayId
<br/>";
die();
*/

if(validate_hash($password, $dbProvPasswd, $dbProvPasswdSalt))
{
    $isLoggedIn=TRUE;

    session_start();
    $_SESSION['userId']= $userIdent;
    $_SESSION['realName']= $userRealName;
    $_SESSION['accessLevelId']= $accessLevelId;

    if($govtAgencyId !== '')
    {
        //
        $_SESSION['govAgencyId']= $govtAgencyId;
    }
    
    if($regionId !== '')
    {
        //
        $_SESSION['regionId']= $regionId;
    }
    
    if($provinceId !== '')
    {
        //
        $_SESSION['provinceId']= $provinceId;
    }
    
    if($cityMunicipalityId !== '')
    {
        //
        $_SESSION['cityMunicipalityId']= $cityMunicipalityId;
    }

    if($barangayId !== '')
    {
        //
        $_SESSION['barangayId']= $barangayId;
    }
    
    $_SESSION['isLoggedIn']=$isLoggedIn;
    
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = 'home.php';

    //redirect to secured home page (home.php)
    header("Location:http://$host$uri/$extra");
}
else
{
    //redirect to index.php
    header("Location:$_SERVER[HTTP_REFERER]");
}