<?php
include 'templates/header.php';
include 'dbconn.php';

$getAgenciesQuery = 'select id, agencyname from govtagency where govtagencyclassid=6 order by agencyname';
$agencyStmt= $dbh->query($getAgenciesQuery);

include 'templates/tableheader.php';

foreach($agencyStmt as $row)
{
?>
                    <tr> 
                    <td><?php echo $row['agencyname'];?></td>
                    <td>TUV Rhineland</td>
                    <td>ISO 9001:2018</td>
                    <td>1 January 2018</td>
                    <td>1 january 2021</td>
                    <td>No</td>
                    </tr>                    
<?php	
}

include 'templates/tablefooter/php';

include 'templates/footer.php';