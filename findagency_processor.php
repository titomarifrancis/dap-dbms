<?php
//find agency processor
include 'templates/header.php';
include 'dbconn.php';
?>
<h3>Agency Search Result</h3>
<?php
if(isset($_REQUEST['partfullagencyname']))
{
  $inputString= ucwords($_REQUEST['partfullagencyname']);
  echo "Input string is $inputString";
}
include 'templates/footer.php';