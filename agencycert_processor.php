<?php
include 'templates/magic.php';
include 'lib/secProc.php';
include 'dbconn.php';

//handle file upload, fileToUpload
$message = ''; 
  if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK)
  {
    // get details of the uploaded file
    $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
    $fileName = $_FILES['uploadedFile']['name'];
    $fileSize = $_FILES['uploadedFile']['size'];
    $fileType = $_FILES['uploadedFile']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));
    echo $fileExtension;
    die();
    // sanitize file-name
    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
    // check if file has one of the following extensions
    $allowedfileExtensions = array('pdf');
    if (in_array($fileExtension, $allowedfileExtensions))
    {
      // directory in which the uploaded file will be moved
      $uploadFileDir = '/home/titomarifrancis/stash/';
      $dest_path = $uploadFileDir . $newFileName;
      if(move_uploaded_file($fileTmpPath, $dest_path)) 
      {
        $message ='File is successfully uploaded.';
      }
      else 
      {
        $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
      }
    }
    else
    {
      $message = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
    }
  }
  else
  {
    $message = 'There is some error in the file upload. Please check the following error.<br>';
    $message .= 'Error:' . $_FILES['uploadedFile']['error'];
  }


//build the query based on the submitted parameters
$queryArray = [];
$paramList = '';
$valueList = '';
if(isset($_REQUEST['govtagencyid']) && ($_REQUEST['govtagencyid'] > 0))
{
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
        $valueList = "'". $queryArray['govtagencyid']."'";
    }
    else
    {
        $valueList = "".$valueList.", '".$queryArray['govtagencyid']."'";
    }    
}

/*if(isset($_REQUEST['region']) && ($_REQUEST['region'] > 0))
{
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
        $valueList = "'". $queryArray['regionid']."'";
    }
    else
    {
        $valueList = "".$valueList.", '".$queryArray['regionid']."'";
    }     
}*/

if(isset($_REQUEST['province']) && ($_REQUEST['province'] > 0))
{
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
        $valueList = "'". $queryArray['provinceid']."'";
    }
    else
    {
        $valueList = "".$valueList.", '".$queryArray['provinceid']."'";
    }     
}

if(isset($_REQUEST['citymunicipality']) && ($_REQUEST['citymunicipality'] > 0))
{
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
        $valueList = "'". $queryArray['citymunicipalityid']."'";
    }
    else
    {
        $valueList = "".$valueList.", '".$queryArray['citymunicipalityid']."'";
    }     
}

if(isset($_REQUEST['barangay']) && ($_REQUEST['barangay'] > 0))
{
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
        $valueList = "'". $queryArray['barangayid']."'";
    }
    else
    {
        $valueList = "".$valueList.", '".$queryArray['barangayid']."'";
    }     
}

if(isset($_REQUEST['certificationid']) && ($_REQUEST['certificationid'] > 0))
{
    $certificationid = $_REQUEST['certificationid'];
    $queryArray['certificationid'] = $certificationid;
    if(strlen($paramList) < 1)
    {
        $paramList .= 'certificationid';
    }
    else
    {
        $paramList .= ', certificationid';
    }
    if(strlen($valueList) < 1)
    {
        $valueList = "'". $queryArray['certificationid']."'";
    }
    else
    {
        $valueList = "".$valueList.", '".$queryArray['certificationid']."'";
    }     
}

if(isset($_REQUEST['certifyingbodyid']) && ($_REQUEST['certifyingbodyid'] > 0))
{
    $certifyingbodyid = $_REQUEST['certifyingbodyid'];
    $queryArray['certifyingbodyid'] = $certifyingbodyid;
    if(strlen($paramList) < 1)
    {
        $paramList .= 'certifyingbodyid';
    }
    else
    {
        $paramList .= ', certifyingbodyid';
    }
    if(strlen($valueList) < 1)
    {
        $valueList = "'". $queryArray['certifyingbodyid']."'";
    }
    else
    {
        $valueList = "".$valueList.", '".$queryArray['certifyingbodyid']."'";
    }     
}

if(isset($_REQUEST['certvalidstartdate']) && ($_REQUEST['certvalidstartdate'] !== ''))
{
    $certvalidstartdate = $_REQUEST['certvalidstartdate'];
    $queryArray['certvalidstartdate'] = $certvalidstartdate;
    if(strlen($paramList) < 1)
    {
        $paramList .= 'certvalidstartdate';
    }
    else
    {
        $paramList .= ', certvalidstartdate';
    }
    if(strlen($valueList) < 1)
    {
        $valueList = "'". $queryArray['certvalidstartdate']."'";
    }
    else
    {
        $valueList = "".$valueList.", '".$queryArray['certvalidstartdate']."'";
    }     
}

if(isset($_REQUEST['certvalidenddate']) && ($_REQUEST['certvalidenddate'] !== ''))
{
    $certvalidenddate = $_REQUEST['certvalidenddate'];
    $queryArray['certvalidenddate'] = $certvalidenddate;
    if(strlen($paramList) < 1)
    {
        $paramList .= 'certvalidenddate';
    }
    else
    {
        $paramList .= ', certvalidenddate';
    }
    if(strlen($valueList) < 1)
    {
        $valueList = "'". $queryArray['certvalidenddate']."'";
    }
    else
    {
        $valueList = "".$valueList.", '".$queryArray['certvalidenddate']."'";
    }     
}

if(isset($_REQUEST['certificationregnumber']) && ($_REQUEST['certificationregnumber'] !== ''))
{
    $certificationregnumber = $_REQUEST['certificationregnumber'];
    $queryArray['certificationregnumber'] = $certificationregnumber;
    if(strlen($paramList) < 1)
    {
        $paramList .= 'certificationregnumber';
    }
    else
    {
        $paramList .= ', certificationregnumber';
    }
    if(strlen($valueList) < 1)
    {
        $valueList = "'". $queryArray['certificationregnumber']."'";
    }
    else
    {
        $valueList = "".$valueList.", '".$queryArray['certificationregnumber']."'";
    }     
}

if(isset($_REQUEST['certificationscope']) && ($_REQUEST['certificationscope'] !== ''))
{
    $certificationscope = $_REQUEST['certificationscope'];
    $queryArray['certificationscope'] = $certificationscope;
    if(strlen($paramList) < 1)
    {
        $paramList .= 'certificationscope';
    }
    else
    {
        $paramList .= ', certificationscope';
    }
    if(strlen($valueList) < 1)
    {
        $valueList = "'". $queryArray['certificationscope']."'";
    }
    else
    {
        $valueList = "".$valueList.", '".$queryArray['certificationscope']."'";
    }     
}

if(isset($_REQUEST['headofagency']) && ($_REQUEST['headofagency'] !== ''))
{
    $headofagency = $_REQUEST['headofagency'];
    $queryArray['headofagency'] = $headofagency;
    if(strlen($paramList) < 1)
    {
        $paramList .= 'headofagency';
    }
    else
    {
        $paramList .= ', headofagency';
    }
    if(strlen($valueList) < 1)
    {
        $valueList = "'". $queryArray['headofagency']."'";
    }
    else
    {
        $valueList = "".$valueList.", '".$queryArray['headofagency']."'";
    }     
}

if(isset($_REQUEST['scope_ispartial']) && ($_REQUEST['scope_ispartial'] !== ''))
{
    $scope_ispartial = 'FALSE';
    if($_REQUEST['scope_ispartial'] == 'on')
    {
        $scope_ispartial = 'TRUE';
    }
    
    $queryArray['scope_ispartial'] = $scope_ispartial;
    if(strlen($paramList) < 1)
    {
        $paramList .= 'scope_ispartial';
    }
    else
    {
        $paramList .= ', scope_ispartial';
    }
    if(strlen($valueList) < 1)
    {
        $valueList = "'". $queryArray['scope_ispartial']."'";
    }
    else
    {
        $valueList = "".$valueList.", '".$queryArray['scope_ispartial']."'";
    }     
}

if(isset($_REQUEST['isapproved']) && ($_REQUEST['isapproved'] !== ''))
{
    $isapproved = 'FALSE';
    if($_REQUEST['isapproved'] == 'true')
    {
        $isapproved = $_REQUEST['isapproved'];
    }
    $queryArray['isapproved'] = $isapproved;
    if(strlen($paramList) < 1)
    {
        if($isapproved == 'true')
        {
            $paramList .= 'isapproved, approvedby';
        }
        else
        {
            $paramList .= 'isapproved';
        }
    }
    else
    {
        if($isapproved == 'true')
        {
            $paramList .= ', isapproved, approvedby';
        }
        else
        {
            $paramList .= ', isapproved';
        }
        
    }
    if(strlen($valueList) < 1)
    {
        if($isapproved == 'true')
        {
            $valueList = "'". $queryArray['isapproved']."', '".$loggedInUserId."'";
        }
        else
        {
            $valueList = "'". $queryArray['isapproved']."'";
        }      
        
    }
    else
    {
        if($isapproved == 'true')
        {
            $valueList = "".$valueList.", '".$queryArray['isapproved']."', '".$loggedInUserId."'";
        }
        else
        {
            $valueList = "".$valueList.", '".$queryArray['isapproved']."'";
        }      
        
    }     
}



//for troubleshooting purposes only
//echo "the submitted values are $govtagencyid, $provinceid, $citymunicipalityid, $barangayid, $certificationid, $certifyingbodyid, $certificationregnumber, $certificationscope, $headofagency, $scope_ispartial, $certvalidstartdate and $certvalidenddate, $isapproved<br/>";
$sqlQuery = "INSERT INTO agencycertifications($paramList, creationdate) VALUES($valueList, 'NOW()')";
echo $sqlQuery;
die();

//constraint to insert/update
//certpdfurl, certificationregnumber, certvalidstartdate, certvalidenddate

/*
govtagencyid integer references govtagency(id) on delete restrict,
certifyingbodyid integer references certifyingbody(id) on delete restrict,
certificationid integer references certifications(id) on delete restrict,
certificationregnumber varchar(16) not null,
certificationscope text not null,
scope_ispartial boolean default null,
certpdfurl text not null,
headofagency varchar(128) default null,
provinceid integer default null references provinces(id) on delete restrict,
citymunicipalityid integer default null references citymunicipality(id) on delete restrict,
barangayid integer default null references barangays(id) on delete restrict,
certvalidstartdate date not null,
certvalidenddate

govtagencyid integer references govtagency(id) on delete restrict,
certifyingbodyid integer references certifyingbody(id) on delete restrict,
certificationid integer references certifications(id) on delete restrict,
certificationregnumber varchar(16) not null,
certificationscope text not null,
scope_ispartial boolean default null,
certpdfurl text not null,
headofagency varchar(128) default null,
provinceid integer default null references provinces(id) on delete restrict,
citymunicipalityid integer default null references citymunicipality(id) on delete restrict,
barangayid integer default null references barangays(id) on delete restrict,
certvalidstartdate date not null,
certvalidenddate*/