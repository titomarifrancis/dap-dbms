<?php
$httpReferingURL = parse_url($_SERVER['HTTP_REFERER']);
$refererPath = $httpReferingURL['path'];
$refererPathElements= explode('/', $refererPath);

include 'templates/magic.php';
include 'lib/secProc.php';
include 'dbconn.php';

$queryArray = [];
$paramList = '';
$valueList = '';
if(isset($_REQUEST['lastname']) && (($_REQUEST['lastname'] !== 0) || ($_REQUEST['lastname'] !=='')))
{
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
    $midname = substr($_REQUEST['midname'], 0, 5);
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
    $extname = substr($_REQUEST['extname'], 0, 5);
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

if(isset($_REQUEST['contactemail']) && (strlen($_REQUEST['contactemail']) > 0))
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

if(isset($_REQUEST['position']) && (strlen($_REQUEST['position']) > 0) || ($_REQUEST['position'] !==''))
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

if(isset($_REQUEST['region']) && ($_REQUEST['region'] >= 1))
{
    //
    $regionid = $_REQUEST['region'];
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

if(isset($_REQUEST['province']) && ($_REQUEST['province'] >= 1))
{
    //
    $provinceid = $_REQUEST['province'];
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

if(isset($_REQUEST['citymunicipality']) && ($_REQUEST['citymunicipality'] >= 1))
{
    //
    $citymunicipalityid = $_REQUEST['citymunicipality'];
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

if(isset($_REQUEST['barangay']) && ($_REQUEST['barangay'] >= 1))
{
    //
    $barangayid = $_REQUEST['barangay'];
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

#userlevelid
if(isset($_REQUEST['userlevelid']))
{
    $userlevelid = $_REQUEST['userlevelid'];
    $queryArray['userlevelid'] = $userlevelid;
    if(strlen($paramList) < 1)
    {
        $paramList .= 'userlevelid';
    }
    else
    {
        $paramList .= ', userlevelid';
    }
    if(strlen($valueList) < 1)
    {
        $valueList = "". $queryArray['userlevelid']."";
    }
    else
    {
        $valueList = "".$valueList.", ".$queryArray['userlevelid']."";
    }
}

#isapproved
if(isset($_REQUEST['isapproved']) && isset($loggedInUserId))
{
    $isapproved = $_REQUEST['isapproved'];
    $queryArray['isapproved'] = $isapproved;
    if(strlen($paramList) < 1)
    {
        $paramList .= 'isapproved, approvedby, approveddate';
    }
    else
    {
        $paramList .= ', isapproved, approvedby, approveddate';
    }
    if(strlen($valueList) < 1)
    {
        $valueList = "'". $queryArray['isapproved']."', '".$loggedInUserId."', 'NOW()'";
    }
    else
    {
        $valueList = "".$valueList.", '".$queryArray['isapproved']."', '".$loggedInUserId."', 'NOW()'";
    }
}

if(isset($loggedInUserId) && (!isset($_REQUEST['userId'])))
{
    //this is a user creation process while logged in as a user
    $createdby = $loggedInUserId;
    $queryArray['createdby'] = $createdby;
    if(strlen($paramList) < 1)
    {
        $paramList .= 'createdby';
    }
    else
    {
        $paramList .= ', createdby';
    }
    if(strlen($valueList) < 1)
    {
        $valueList = "'".$queryArray['createdby']."'";
    }
    else
    {
        $valueList = "".$valueList.", '".$queryArray['createdby']."'";
    }       
}

if(isset($_REQUEST['userId']))
{
    //update
    $userId = $_REQUEST['userId'];
    $paramArray = explode(",", $paramList);
    $valueArray = explode(",", $valueList);
    $paramCount = count($paramArray);
    $valueCount = count($valueArray);

    $updateList = '';
    if($paramCount == $valueCount)
    {
        //list per location
        for($ctr= 0; $ctr < $paramCount; $ctr++)
        {
            if(strlen($updateList) < 1)
            {
                $updateList .= "$paramArray[$ctr]=$valueArray[$ctr]";
            }
            else
            {
                $updateList .= ", $paramArray[$ctr]=$valueArray[$ctr]";
            }
        }
    }

    $sqlQuery = "UPDATE systemusers SET $updateList WHERE id= $userId";
    $actionId= 2;
}
else
{
    //insert
    $sqlQuery = "INSERT INTO systemusers($paramList, creationdate) VALUES($valueList, 'NOW()')";
    $actionId= 1;
}

if((strlen($lastname) > 0) && (strlen($firstname) > 0) && (strlen($usrname) > 0))
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

$urlComponents = explode("?", $_SERVER[HTTP_REFERER]);
if($actionId==1)
{
    //
    header("Location:$urlComponents[0]?msg=$actionId");
}
elseif($actionId==2)
{
    //
    header("Location:$urlComponents[0]?userid=$userId&msg=$actionId");
}