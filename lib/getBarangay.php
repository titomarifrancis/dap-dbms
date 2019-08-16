<?php
//Utility library file to get the list of 
//provinces per region and return as list of options in dropdown
include '../dbconn.php';

if(!isset($_REQUEST['citymunid']))
{
    //
    echo 'Usage: getBarangay.php?citymunid=integer_number';
}
else
{
    //
    $id = $_REQUEST['citymunid'];
    $getBarangayQuery = 'select id, barangayname from barangays where citymunicipalityid='.$id.' order by barangayname';
    $getBarangayQueryStmt= $dbh->query($getBarangayQuery);
    $barangays= $getBarangayQueryStmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($barangays);    
}


/*
foreach($agencyclassStmt as $agencyclassRow)
{
    echo "<option value=".rtrim($agencyclassRow['id']).">".rtrim($agencyclassRow['agencyclassdesc'])."</option>";
}
