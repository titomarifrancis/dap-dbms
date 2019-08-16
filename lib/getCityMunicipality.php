<?php
//Utility library file to get the list of 
//provinces per region and return as list of options in dropdown
include '../dbconn.php';

if(!isset($_REQUEST['provinceid']))
{
    //
    echo 'Usage: getCityMunicipality.php?provinceid=integer_number';
}
else
{
    //
    $id = $_REQUEST['provinceid'];
    $getCityMunicipalityQuery = 'select id, towncitymunicipalityname from citymunicipality where provinceid='.$id.' order by towncitymunicipalityname asc';
    $getCityMunicipalityStmt= $dbh->query($getCityMunicipalityQuery);
    $citymunicipalities= $getCityMunicipalityStmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($citymunicipalities);    
}


/*
foreach($agencyclassStmt as $agencyclassRow)
{
    echo "<option value=".rtrim($agencyclassRow['id']).">".rtrim($agencyclassRow['agencyclassdesc'])."</option>";
}
