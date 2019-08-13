<?php
session_start();
if(isset($_SESSION['userId']) && isset($_SESSION['realName']))
{
    $loggedInUserId= $_SESSION['userId'];
    $loggedInUserRealname= $_SESSION['realName'];
    $loggedInAccessLevel= $_SESSION['accessLevelId'];
    $isLoggedIn= $_SESSION['isLoggedIn'];
    
    if(isset($_SESSION['govAgencyId']))
    {
        //
        $govtAgencyId= $_SESSION['govAgencyId'];
    }
    
    if(isset($_SESSION['regionId']))
    {
        //
        $regionId= $_SESSION['regionId'];
    }
    
    if(isset($_SESSION['provinceId']))
    {
        //
        $provinceId= $_SESSION['provinceId'];
    }
    
    if(isset($_SESSION['distdivId']))
    {
        //
        $distdivId= $_SESSION['distdivId'];
    }
    
    if(isset($_SESSION['cityMunicipalityId']))
    {
        //
        $cityMunicipalityId= $_SESSION['cityMunicipalityId'];
    }

    if(isset($_SESSION['barangayId']))
    {
        //
        $barangayId= $_SESSION['barangayId'];
    }

}
else
{
    session_unset();  
    session_destroy();

    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location:http://$host$uri/");
}