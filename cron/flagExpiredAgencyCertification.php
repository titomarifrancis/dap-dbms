#! /usr/local/bin/php
<?php
include '../dbconn.php';

//the shell script header is OpenBSD-specific, may have to be tweaked for other platforms and environments

$sqlQuery = "update agencycertifications set isexpired=true where certvalidenddate < NOW()";
$flagAgencyCertExpiredStmt = $dbh->query($sqlQuery);
$numrecords = $dbh->query($sqlQuery)->rowCount();

//to be implemented:
//notify thru log or messaging like chat or email of flagged expired agency certification#! 