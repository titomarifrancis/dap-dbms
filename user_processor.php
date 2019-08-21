<?php
$httpReferingURL = parse_url($_SERVER[HTTP_REFERER]);
$refererPath = $httpReferingURL['path'];
$refererPathElements= explode('/', $refererPath);

if($refererPathElements[2] == 'signup.php')
{
    include 'lib/secProc.php';
    include 'dbconn.php';
}
else
{
    include 'templates/magic.php';
    include 'lib/secProc.php';
    include 'dbconn.php';
}

$queryArray= [];
$paramList= '';
$valueList= '';
if(isset($_REQUEST['lastname']) && (($_REQUEST['lastname'] !== 0) || ($_REQUEST['lastname'] !=='')))
{
    //
    $lastname = $_REQUEST['lastname'];
    $queryArray['lastname'] = $lastname;
    if(strlen($paramList) < 1)
    {
        $paramList .= 'lastname';
    }
    else
    {
        $paramList .= ', lastname';
    }
    if(strlen($valueList) < 1)
    {
        $valueList = "'". $queryArray['lastname']."'";
    }
    else
    {
        $valueList = "".$valueList.", '".$queryArray['lastname']."'";
    }
}

if(isset($_REQUEST['firstname']) && (($_REQUEST['firstname'] !== 0) || ($_REQUEST['firstname'] !=='')))
{
    //
    $firstname = $_REQUEST['firstname'];
    $queryArray['firstname'] = $firstname;
    if(strlen($paramList) < 1)
    {
        $paramList .= 'firstname';
    }
    else
    {
        $paramList .= ', firstname';
    }
    if(strlen($valueList) < 1)
    {
        $valueList = "'". $queryArray['firstname']."'";
    }
    else
    {
        $valueList = "".$valueList.", '".$queryArray['firstname']."'";
    }      
}

if(isset($_REQUEST['midname']) && (($_REQUEST['midname'] !== 0) || ($_REQUEST['midname'] !=='')))
{
    //
    $midname = $_REQUEST['midname'];
    $queryArray['midname'] = $midname;
    if(strlen($paramList) < 1)
    {
        $paramList .= 'midname';
    }
    else
    {
        $paramList .= ', midname';
    }
    if(strlen($valueList) < 1)
    {
        $valueList = "'". $queryArray['midname']."'";
    }
    else
    {
        $valueList = "".$valueList.", '".$queryArray['midname']."'";
    }           
}

if(isset($_REQUEST['extname']) && ((strlen($_REQUEST['extname']) > 0) || ($_REQUEST['extname'] !=='')))
{
    //
    $extname = $_REQUEST['extname'];
    $queryArray['extname'] = $extname;
    if(strlen($paramList) < 1)
    {
        $paramList .= 'extname';
    }
    else
    {
        $paramList .= ', extname';
    }   
    if(strlen($valueList) < 1)
    {
        $valueList = "'". $queryArray['extname']."'";
    }
    else
    {
        $valueList = "".$valueList.", '".$queryArray['extname']."'";
    }      
}

if(isset($_REQUEST['contactmobile']) && ((strlen($_REQUEST['contactmobile']) > 0) || ($_REQUEST['contactmobile'] !=='')))
{
    //
    $contactmobile = $_REQUEST['contactmobile'];
    $queryArray['contactmobile'] = $contactmobile;
    if(strlen($paramList) < 1)
    {
        $paramList .= 'contactmobile';
    }
    else
    {
        $paramList .= ', contactmobile';
    }
    if(strlen($valueList) < 1)
    {
        $valueList = "'". $queryArray['contactmobile']."'";
    }
    else
    {
        $valueList = "".$valueList.", '".$queryArray['contactmobile']."'";
    }        
}

if(isset($_REQUEST['contactlandline']) && ((strlen($_REQUEST['contactlandline']) > 0) || ($_REQUEST['contactlandline'] !=='')))
{
    //
    $contactlandline = $_REQUEST['contactlandline'];
    $queryArray['contactlandline'] = $contactlandline;
    if(strlen($paramList) < 1)
    {
        $paramList .= 'contactlandline';
    }
    else
    {
        $paramList .= ', contactlandline';
    } 
    if(strlen($valueList) < 1)
    {
        $valueList = "'". $queryArray['contactlandline']."'";
    }
    else
    {
        $valueList = "".$valueList.", '".$queryArray['contactlandline']."'";
    }     
}

if(isset($_REQUEST['contactemail']) && (($_REQUEST['contactemail'] !== 0) || ($_REQUEST['contactemail'] !=='')))
{
    //
    $contactemail = $_REQUEST['contactemail'];
    $queryArray['contactemail'] = $contactemail;
    if(strlen($paramList) < 1)
    {
        $paramList .= 'contactemail';
    }
    else
    {
        $paramList .= ', contactemail';
    }
    if(strlen($valueList) < 1)
    {
        $valueList = "'". $queryArray['contactemail']."'";
    }
    else
    {
        $valueList = "".$valueList.", '".$queryArray['contactemail']."'";
    }         
}

if(isset($_REQUEST['position']) && ((strlen$_REQUEST['position']) > 0) || ($_REQUEST['position'] !=='')))
{
    //
    $position = $_REQUEST['position'];
    $queryArray['position'] = $position;
    if(strlen($paramList) < 1)
    {
        $paramList .= 'position';
    }
    else
    {
        $paramList .= ', position';
    } 
    if(strlen($valueList) < 1)
    {
        $valueList = "'". $queryArray['position']."'";
    }
    else
    {
        $valueList = "".$valueList.", '".$queryArray['position']."'";
    }      
}

if(isset($_REQUEST['govtagencyid']) && ($_REQUEST['govtagencyid'] >= 1))
{
    //
    $govtagencyid = $_REQUEST['govtagencyid'];
    $queryArray['govtagencyid'] = $govtagencyid;
    if(strlen($paramList) < 1)
    {
        $paramList .= 'govtagencyid';
    }
    else
    {
        $paramList .= ', govtagencyid';
    }
    if(strlen($valueList) < 1)
    {
        $valueList = "". $queryArray['govtagencyid']."";
    }
    else
    {
        $valueList = "".$valueList.", ".$queryArray['govtagencyid']."";
    }           
}

if(isset($_REQUEST['regionid']) && ($_REQUEST['regionid'] >= 1))
{
    //
    $regionid = $_REQUEST['regionid'];
    $queryArray['regionid'] = $regionid;
    if(strlen($paramList) < 1)
    {
        $paramList .= 'regionid';
    }
    else
    {
        $paramList .= ', regionid';
    }
    if(strlen($valueList) < 1)
    {
        $valueList = ''. $queryArray['regionid'].'';
    }
    else
    {
        $valueList = ''.$valueList.', '.$queryArray['regionid'].'';
    }     
}

if(isset($_REQUEST['provinceid']) && ($_REQUEST['provinceid'] >= 1))
{
    //
    $provinceid = $_REQUEST['provinceid'];
    $queryArray['provinceid'] = $provinceid;
    if(strlen($paramList) < 1)
    {
        $paramList .= 'provinceid';
    }
    else
    {
        $paramList .= ', provinceid';
    }
    if(strlen($valueList) < 1)
    {
        $valueList = ''. $queryArray['provinceid'].'';
    }
    else
    {
        $valueList = ''.$valueList.', '.$queryArray['provinceid'].'';
    }     
}

if(isset($_REQUEST['citymunicipalityid']) && ($_REQUEST['citymunicipalityid'] >= 1))
{
    //
    $citymunicipalityid = $_REQUEST['citymunicipalityid'];
    $queryArray['citymunicipalityid'] = $citymunicipalityid;
    if(strlen($paramList) < 1)
    {
        $paramList .= 'citymunicipalityid';
    }
    else
    {
        $paramList .= ', citymunicipalityid';
    }
    if(strlen($valueList) < 1)
    {
        $valueList = ''. $queryArray['citymunicipalityid'].'';
    }
    else
    {
        $valueList = ''.$valueList.', '.$queryArray['citymunicipalityid'].'';
    }        
}

if(isset($_REQUEST['barangayid']) && ($_REQUEST['barangayid'] >= 1))
{
    //
    $barangayid = $_REQUEST['barangayid'];
    $queryArray['barangayid'] = $barangayid;
    if(strlen($paramList) < 1)
    {
        $paramList .= 'barangayid';
    }
    else
    {
        $paramList .= ', barangayid';
    } 
    if(strlen($valueList) < 1)
    {
        $valueList = ''. $queryArray['barangayid'].'';
    }
    else
    {
        $valueList = ''.$valueList.', '.$queryArray['barangayid'].'';
    }     
}

if(isset($_REQUEST['usrname']) && ((strlen($_REQUEST['usrname']) > 0) || ($_REQUEST['usrname'] !=='')))
{
    //
    $usrname = $_REQUEST['usrname'];
    $queryArray['usrname'] = $usrname;
    if(strlen($paramList) < 1)
    {
        $paramList .= 'usrname';
    }
    else
    {
        $paramList .= ', usrname';
    }
    if(strlen($valueList) < 1)
    {
        $valueList = "'". $queryArray['usrname']."'";
    }
    else
    {
        $valueList = "".$valueList.", '".$queryArray['usrname']."'";
    }     
}

if(isset($_REQUEST['usrpassword']) && ((strlen($_REQUEST['usrpassword']) > 0) || ($_REQUEST['usrpassword'] !=='')))
{
    //
    $usrpassword = $_REQUEST['usrpassword'];
    $spices = create_salt();
    $magicWord = create_hash($usrpassword, $spices);
    $queryArray['usrpassword'] = $magicWord;
    $queryArray['usrpasswdsalt'] = $spices;
    if(strlen($paramList) < 1)
    {
        $paramList .= 'usrpassword, usrpasswdsalt';
    }
    else
    {
        $paramList .= ', usrpassword, usrpasswdsalt';
    }
    if(strlen($valueList) < 1)
    {
        $valueList = "'". $queryArray['usrpassword']."', '".$queryArray['usrpasswdsalt']."'";
    }
    else
    {
        $valueList = "".$valueList.", '".$queryArray['usrpassword']."', '".$queryArray['usrpasswdsalt']."'";
    }          
}

//if(isset($_REQUEST['userId']))
//{
//	$userId = $_REQUEST['userId'];
//}

//print_r($queryArray);
//echo "<br/>";
//echo $paramList;
//echo "<br/>";
//echo $valueList;
//echo "<br/>";
//die();

/*
if(isset() && (( !== 0) || ( !=='')))
{
    //
}

if(isset() && (( !== 0) || ( !=='')))
{
    //
}
*/
/*
foreach($queryArray as $key => $value)
{
    //
    echo $key $value;
}
*/

//should create an array of non-empty variables to be fed into the insert query builder

//echo "$lastname $firstname $midname $extname $contactmobile $contactlandline $contactemail $position $govtagencyid $regionid $provinceid $citymunicipalityid $barangayid $usrname $usrpassword";
//die();

//echo "$magicWord $spices";
//die();
/*
if(isset($_REQUEST['userId']))
{
    $userId = $_REQUEST['userId'];
    $sqlQuery = 'UPDATE systemusers set
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
        citymunicipalityid = '$citymunicipalityid',
        barangayid = '$barangayid',
        usrname = '$usrname',
        usrpassword = '$usrpassword',
        where id = '$userId''; 
}
else
{*/
    $sqlQuery = "INSERT INTO systemusers($paramList, creationdate) VALUES($valueList, 'NOW()')";
//}

//for troubleshooting purposes only
//echo $sqlQuery;
//die();


if((strlen($lastname) > 0) && (strlen($firstname) > 0) && (strlen($usrname) > 0) && (strlen($usrpassword) > 0))
{
    try
    {
        $dbh->beginTransaction();
        //$sql= $sqlQuery;
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