<?php
//find agency processor
include 'templates/header.php';
include 'dbconn.php';

if(isset($_REQUEST['partfullagencyname']))
{
  $inputString= $_REQUEST['partfullagencyname'];
  echo "Input string is $inputString";
}
include 'templates/footer.php';