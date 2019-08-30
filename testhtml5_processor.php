<?php
include 'templates/magic.php';
include 'lib/secProc.php';
include 'dbconn.php';
include 'config/ssh2param.php';

$webpathlen = strlen($ssh2destpath);
$webpathlastchar = substr($ssh2destpath, ($webpathlen - 1), 1);
if($webpathlastchar == "/")
{
    //webpath
    $webpathArray[] = explode("/", $ssh2destpath);
    
    $webpathArraySize = count($webpathArray[0]);
    $webpathPtr = $webpathArraySize - 2;
    $webpath = $webpathArray[0][$webpathPtr];
}

echo "$webpathlastchar $webpathArraySize $webpath<br/>";
print_r($webpathArray);
die();

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    if (isset($_FILES['uploadedFile']))
    {
        $errors = [];
        $path = $upload_path;
	    $extensions = ['pdf'];
        $file_name = $_FILES['uploadedFile']['name'];
        $enc_filename = md5($_FILES['uploadedFile']['name']);
        $file_tmp = $_FILES['uploadedFile']['tmp_name'];
        $file_type = $_FILES['uploadedFile']['type'];
        $file_size = $_FILES['uploadedFile']['size'];
        $file_ext = strtolower(end(explode('.', $file_name)));
        $file = $path . $enc_filename . "." . $file_ext;
        if (!in_array($file_ext, $extensions))
        {
            $errors[] = 'Extension not allowed: ' . $file_name . ' ' . $file_type;
        }
        if ($file_size > 16777216)
        {
            $errors[] = 'File size exceeds limit: ' . $file_name . ' ' . $file_type;
        }
        if (empty($errors))
        {
            //the uploaded file is stored in stash/ folder
            move_uploaded_file($file_tmp, $file);

            $ssh = ssh2_connect($ssh2host, $ssh2port);
            ssh2_auth_password($ssh, $ssh2username, $ssh2password);

            //this will be the path to be recorded in the DB
            $dst = $ssh2destpath . $enc_filename.'.' .$file_ext;
            ssh2_scp_send($ssh, $file, $dst, 0644);

            //Should delete the file on local stash folder
            unlink($file) or die("Couldn't delete file");

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

            if(isset($_REQUEST['region']) && ($_REQUEST['region'] > 0))
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
            }

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

            //certpdfurl
            $certpdfurl = $dst;
            $queryArray['certpdfurl'] = $certpdfurl;
            if(strlen($paramList) < 1)
            {
                $paramList .= 'certpdfurl';
            }
            else
            {
                $paramList .= ', certpdfurl';
            }
            if(strlen($valueList) < 1)
            {
                $valueList = "'". $queryArray['certpdfurl']."'";
            }
            else
            {
                $valueList = "".$valueList.", '".$queryArray['certpdfurl']."'";
            }

            //for troubleshooting purposes only
            //echo "the submitted values are $govtagencyid, $provinceid, $citymunicipalityid, $barangayid, $certificationid, $certifyingbodyid, $certificationregnumber, $certificationscope, $headofagency, $scope_ispartial, $certvalidstartdate and $certvalidenddate, $isapproved<br/>";

            $sqlQuery = "INSERT INTO agencycertifications($paramList, creationdate) VALUES($valueList, 'NOW()')";

            //for troubleshooting purposes only
            echo $sqlQuery;
            die();

            if((strlen($lastname) > 0) && (strlen($firstname) > 0) && (strlen($usrname) > 0) && (strlen($usrpassword) > 0))
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
            
            //jump back to form page
            header("Location:$_SERVER[HTTP_REFERER]");            

            
        }
        if ($errors)
            print_r($errors);
            die();
    }
}