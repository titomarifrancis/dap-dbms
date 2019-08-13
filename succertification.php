<?php
include 'templates/header.php';
include 'dbconn.php';

$getAgenciesQuery = 'select id, agencyname from govtagency where govtagencyclassid=8 order by agencyname';
$agencyStmt= $dbh->query($getAgenciesQuery);
//$agencyResult = $agencyStmt->fetchAll();
//print_r($agencyResult);
?>
                    <table class="scroll hover">
                        <thead>
                            <tr>
                                <th>Agency</th>
                                <th>Certifying Body</th>
                                <th>Certification</th>
                                <th>Valid From</th>
                                <th>Valid Until</th>
                                <th>Partial</th>
                            </tr>
                        </thead>
                        <tbody>
<?php
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
?>
                        </tbody>
                    </table>
<?php
include 'templates/footer.php';