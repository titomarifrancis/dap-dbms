<?php
include 'templates/headerin.php';
include 'dbconn.php';
?>
<h3>NGA-Attached Offices and Bureaus Certification</h3>
<?php
$getAgenciesQuery = 'select agencycertifications.id as agencycertificationid, govtagency.agencyname as agencyname, certifyingbody.providerorg as certifyingbody, certifications.certificationstandard as certificationdesc, agencycertifications.certvalidstartdate as certstartdate, agencycertifications.certvalidenddate as certenddate, agencycertifications.scope_ispartial as ispartial from govtagencyclass, govtagency, certifyingbody, certifications, agencycertifications where agencycertifications.isapproved=true and agencycertifications.govtagencyid=govtagency.id and agencycertifications.certifyingbodyid=certifyingbody.id and agencycertifications.certificationid=certifications.id and govtagency.govtagencyclassid=govtagencyclass.id and govtagencyclass.id=6 order by agencyname';
$numrecords = $dbh->query($getAgenciesQuery)->rowCount();
if($numrecords > 0)
{
    //
    include 'templates/tableheader.php';

    $agencyStmt= $dbh->query($getAgenciesQuery);
    foreach($agencyStmt as $row)
    {
        $isPartial="No";
        if($row['ispartial'] == 1)
        {
            $isPartial="Yes";
        }
?>
                        <tr> 
                        <td><a href="agencycert_detailsec.php?id=<?php echo $row['agencycertificationid'];?>"><?php echo $row['agencyname'];?></a></td>
                        <td><?php echo $row['certifyingbody'];?></td>
                        <td><?php echo $row['certificationdesc'];?></td>
                        <td><?php echo $row['certstartdate'];?></td>
                        <td><?php echo $row['certenddate'];?></td>
                        <td><?php echo $isPartial;?></td>
                        </tr>          
<?php
    }
    include 'templates/tablefooter/php';    
}
else
{
    echo "<p>There are no certifications recorded for this section</p>";
}

include 'templates/footer.php';