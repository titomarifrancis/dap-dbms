<?php
//Utility library file to get the list of 
//provinces per region and return as list of options in dropdown
include '../dbconn.php';

if(!isset($_REQUEST['regionid']))
{
    //
    echo 'Usage: getProvince.php?regionid=integer_number';
}
else
{
    //
    $id = $_REQUEST['regionid'];
    $getProvinceQuery = 'select id, provincename from provinces where regionid='.$id.' order by provincename asc';
    $getProvinceStmt= $dbh->query($getProvinceQuery);
    $provinces= $getProvinceStmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($provinces);    
}


/*
foreach($agencyclassStmt as $agencyclassRow)
{
    echo "<option value=".rtrim($agencyclassRow['id']).">".rtrim($agencyclassRow['agencyclassdesc'])."</option>";
}
