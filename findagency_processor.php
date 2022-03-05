<?php
//find agency processor
include 'templates/header.php';
include 'dbconn.php';

if(isset($_REQUEST['partfullagencyname']))
{
  echo "Input string is $_REQUEST['partfullagencyname']";
}
include 'templates/footer.php';