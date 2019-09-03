<?php
include '../dbconn.php';

$sqlQuery = "update agencycertifications set isexpired=true where certvalidenddate < NOW()";
$flagAgencyCertExpiredStmt = $dbh->query($sqlQuery);
$numrecords = $dbh->query($sqlQuery)->rowCount();

//to be implemented:
//notify thru log or messaging like chat or email of flagged expired agency certification