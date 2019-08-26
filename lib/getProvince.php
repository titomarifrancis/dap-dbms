<?php
include '../dbconn.php';

if(!isset($_REQUEST['regionid']))
{
    echo 'Usage: getProvince.php?regionid=integer_number';
}
else
{
    $id = $_REQUEST['regionid'];
    $getProvinceQuery = 'select id, provincename from provinces where regionid='.$id.' order by provincename asc';
    $getProvinceStmt= $dbh->query($getProvinceQuery);
    $provinces= $getProvinceStmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($provinces);    
}