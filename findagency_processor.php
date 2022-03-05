<?php
//find agency processor
include 'templates/header.php';
include 'dbconn.php';

if(isset($_REQUEST['partfullagencyname']))
{
?>
<h3>Agency Search Result</h3>
<?php
 echo "Input string is $_REQUEST['partfullagencyname']";
}
include 'templates/footer.php';