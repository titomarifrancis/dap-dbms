<?php
include '../dbconn.php';

$getRegionQuery = 'select id, regionname from regions order by id asc';
$getRegionStmt= $dbh->query($getRegionQuery);
$regions= $getRegionStmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($regions);