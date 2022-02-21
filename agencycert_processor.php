<?php
//echo "Line 2";
//die();
include 'templates/magic.php';
include 'lib/secProc.php';
include 'dbconn.php';
include 'config/ssh2param.php';

//echo "Hello line 10<br/>";
//die();

//check that all required fields are properly filled in
if((isset($_REQUEST['govtagencyid']) && ($_REQUEST['govtagencyid'] > 0)) && (isset($_REQUEST['certificationid']) && ($_REQUEST['certificationid'] > 0)) && (isset($_REQUEST['certvalidstartdate']) && ($_REQUEST['certvalidstartdate'] !== '')) && (isset($_REQUEST['certvalidenddate']) && ($_REQUEST['certvalidenddate'] !== '')) && (isset($_REQUEST['certificationregnumber']) && ($_REQUEST['certificationregnumber'] !== '')) && (isset($_REQUEST['certificationscope']) && ($_REQUEST['certificationscope'] !== '')) && (isset($_REQUEST['headofagency']) && ($_REQUEST['headofagency'] !== '')) && (isset($_FILES['uploadedFile'])) && ((isset($_REQUEST['certifyingbodyid']) && ($_REQUEST['certifyingbodyid'] != '')) ^((isset($_REQUEST['newcertifyingbody']) && ($_REQUEST['newcertifyingbody'] != '')))))
{
    //if all ok
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        if (isset($_FILES['uploadedFile']))
        {
            $errors = [];
            $path = $upload_path;
            $extensions = ['pdf', 'png', 'jpg'];
            $file_name = $_FILES['uploadedFile']['name'];
            $enc_filename = md5($_FILES['uploadedFile']['name']);
            $file_tmp = $_FILES['uploadedFile']['tmp_name'];
            $file_type = $_FILES['uploadedFile']['type'];
            $file_size = $_FILES['uploadedFile']['size'];
            $file_ext = strtolower(end(explode('.', $file_name)));
	        $file = $path . $enc_filename . "." . $file_ext;

            //echo "Hi line 32<br/>";
            //die();

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

				if(move_uploaded_file($file_tmp, $file))
				{
					//this will be the path to be recorded in the DB
					$dst = $ssh2destpath . $enc_filename.'.' .$file_ext;

					//close file handle
					fclose(realpath($file));
					
					//change to path of file (stash)
					chdir($path);
	
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
                    
                    $certpdfurlAutogenerated = $ssh2host . "/". $webpath . "/" . $enc_filename.'.' .$file_ext;
					if(strlen($ssh2hostalias) > 0)
					{
						$certpdfurlAutogenerated = $ssh2hostalias . "/". $webpath . "/" . $enc_filename.'.' .$file_ext;
					}
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
				
                if(isset($_REQUEST['certificationsite']) && ($_REQUEST['certificationsite'] != ""))
                {
                    $certificationsite = $_REQUEST['certificationsite'];
                    $queryArray['certificationsite'] = $certificationsite;
                    if(strlen($paramList) < 1)
                    {
                        $paramList .= 'certificationsite';
                    }
                    else
                    {
                        $paramList .= ', certificationsite';
                    }
                    if(strlen($valueList) < 1)
                    {
                        $valueList = "'". $queryArray['certificationsite']."'";
                    }
                    else
                    {
                        $valueList = "".$valueList.", '".$queryArray['certificationsite']."'";
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
				
                if(isset($_REQUEST['governancelevel']) && ($_REQUEST['governancelevel'] > 0))
                {
                    $governancelevel = $_REQUEST['governancelevel'];
                    $queryArray['governancelevel'] = $governancelevel;
                    if(strlen($paramList) < 1)
                    {
                        $paramList .= 'governancelevel';
                    }
                    else
                    {
                        $paramList .= ', governancelevel';
                    }
                    if(strlen($valueList) < 1)
                    {
                        $valueList = "'". $queryArray['governancelevel']."'";
                    }
                    else
                    {
                        $valueList = "".$valueList.", '".$queryArray['governancelevel']."'";
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
    
                if(isset($_REQUEST['certifyingbodyid']) && ($_REQUEST['certifyingbodyid'] > 0) && !(isset($_REQUEST['newcertifyingbody']) && ($_REQUEST['newcertifyingbody'] !== '')))
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
                else
                {
                    $certifyingBodyName = $_REQUEST['newcertifyingbody'];

                    //get neext ID value for new certifying body
                    $sqlSeq= "select last_value, is_called from certifyingbody_id_seq";
                    $stmtSeq= $dbh->query($sqlSeq);
                    $resultSeq= $stmtSeq->fetch();
                    $lastValue = $resultSeq['last_value'];
                    $isCalled = $resultSeq['is_called'];
                    if($isCalled != TRUE)
                    {
                        $nextId= $lastValue;
                    }
                    if($isCalled == TRUE)
                    {
                        $nextId= $lastValue + 1;
                    }

                    //store new certifying body to DB
                    $ispabaccredited = '0';
                    $isapproved = '0';
                    $providerorg = $_REQUEST['newcertifyingbody'];
                    $certifyingBodyInsertQuery = "INSERT INTO certifyingbody(ispabaccredited, providerorg, isapproved, createdby, creationdate) values('FALSE', '$providerorg', 'FALSE', $loggedInUserId, 'NOW()')";
                    try
                    {
                        //
                        $dbh->beginTransaction();
                        $dbh->exec($certifyingBodyInsertQuery);
                        $dbh->commit();
                    }
                    catch(PDOException $e)
                    {
                        //
                        $dbh->rollback();
                        echo "Failed to complete transaction: " . $e->getMessage() . "\n";
                        exit;
                    }

                    $certifyingbodyid = $nextId;
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
                    if($_REQUEST['scope_ispartial'] == 'true')
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
                            $paramList .= 'isapproved, approvedby, approveddate';
                        }
                    }
                    else
                    {
                        if($isapproved == 'true')
                        {
                            $paramList .= ', isapproved, approvedby, approveddate';
                        }
                    }
                    if(strlen($valueList) < 1)
                    {
                        if($isapproved == 'true')
                        {
                            $valueList = "'". $queryArray['isapproved']."', '".$loggedInUserId."', 'NOW()'";
                        }
                    }
                    else
                    {
                        if($isapproved == 'true')
                        {
                            $valueList = "".$valueList.", '".$queryArray['isapproved']."', '".$loggedInUserId."', 'NOW()'";
                        }
                    }     
                }
    
                //certpdfurl
                //$certpdfurlAutogenerated
                //$certpdfurl = $certpdfurlAutogenerated;
                $queryArray['certpdfurl'] = $certpdfurlAutogenerated;
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
    
                //createdby
                $queryArray['createdby'] = $loggedInUserId;
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
                    $valueList = "'". $queryArray['createdby']."'";
                }
                else
                {
                    $valueList = "".$valueList.", '".$queryArray['createdby']."'";
                }
    
                //for troubleshooting purposes only
                //echo "the submitted values are $govtagencyid, $provinceid, $citymunicipalityid, $barangayid, $certificationid, $certifyingbodyid, $certificationregnumber, $certificationscope, $headofagency, $scope_ispartial, $certvalidstartdate and $certvalidenddate, $isapproved<br/>";
    
                $sqlQuery = "INSERT INTO agencycertifications($paramList, creationdate) VALUES($valueList, 'NOW()')";
                
                //for troubleshooting purposes only
                echo $sqlQuery;
                die();
    
                //if((strlen($certpdfurlAutogenerated) > 0) && (strlen($paramList) > 0) && (strlen($valueList) > 0) && (strlen($sqlQuery) > 0))
				//if((strlen($certpdfurlAutogenerated) > 0) && (strlen($sqlQuery) > 0))
				if(strlen($sqlQuery) > 0)
                {
					//for troubleshooting purposes only
					echo "$certpdfurlAutogenerated</br>";
					echo "$paramList</br>";
					echo "$valueList</br>";
					echo $sqlQuery;
					die();
					
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
                //breakdown URL first
                $urlComponents = explode("?", $_SERVER[HTTP_REFERER]);
                //print_r($urlComponents);
                //die();
                header("Location:$urlComponents[0]?msg=1");

            }
            if ($errors)
                print_r($errors);
                die();
        }
    }    
}
else
{
    //else jump back with notification
    $urlComponents = explode("?", $_SERVER[HTTP_REFERER]);
    header("Location:$urlComponents[0]?msg=2");
}

