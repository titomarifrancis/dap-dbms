<?php
include 'templates/headerin.php';
include 'dbconn.php';

$agencycategoryId = $_REQUEST['catid'];
$getCategoryLabel = "select agencyclassdesc from govtagencyclass where id=$agencycategoryId";
$getCategoryStmt = $dbh->query($getCategoryLabel)->fetchAll();
$agencyCategoryLabel = $getCategoryStmt[0]['agencyclassdesc'];
?>
<h3>Uncertified <?php echo $agencyCategoryLabel;?></h3>
<br/>
<?php
//$getAgenciesQuery = "select agencycertifications.id as agencycertificationid, govtagency.agencyname as agencyname, certifyingbody.providerorg as certifyingbody, certifications.certificationstandard as certificationdesc, agencycertifications.certvalidstartdate as certstartdate, agencycertifications.certvalidenddate as certenddate, agencycertifications.scope_ispartial as ispartial from govtagencyclass, govtagency, certifyingbody, certifications, agencycertifications where agencycertifications.isapproved=true and agencycertifications.govtagencyid=govtagency.id and agencycertifications.certifyingbodyid=certifyingbody.id and agencycertifications.certificationid=certifications.id and govtagency.govtagencyclassid=govtagencyclass.id and agencycertifications.isexpired=false and govtagencyclass.id=$agencycategoryId order by agencyname";
//$getAgenciesQuery = "select govtagency.agencyname as agencyname from govtagencyclass, govtagency, certifyingbody, certifications, agencycertifications where agencycertifications.isapproved=true and agencycertifications.govtagencyid<>govtagency.id and agencycertifications.certifyingbodyid=certifyingbody.id and agencycertifications.certificationid=certifications.id and govtagency.govtagencyclassid=govtagencyclass.id and agencycertifications.isexpired=false and govtagencyclass.id=$agencycategoryId order by agencyname";
$getAgenciesQuery = "select distinct govtagency.id as agencyid, govtagency.agencyname from govtagencyclass, govtagency, agencycertifications where agencycertifications.isapproved=true and agencycertifications.govtagencyid!=govtagency.id and govtagency.govtagencyclassid=govtagencyclass.id and agencycertifications.isexpired=true and govtagencyclass.id=$agencycategoryId order by govtagency.agencyname";
$numrecords = $dbh->query($getAgenciesQuery)->rowCount();
if($numrecords > 0)
{
    include 'templates/agencylistheader.php';

    $agencyStmt= $dbh->query($getAgenciesQuery);

    foreach($agencyStmt as $row)
    {
        $isPartial="Not Full Scope";
        if($row['ispartial'] == 1)
        {
            $isPartial="Full Scope";
        }

        $govtAgencyId = $row['agencyid'];

        //check that this agency has no certification record
        $checkIfUncertified = "select govtagency.id, govtagency.agencyname as numActiveCertified from govtagency, agencycertifications where agencycertifications.govtagencyid=govtagency.id  and agencycertifications.isexpired=false and agencycertifications.isapproved=true and govtagency.id=$govtAgencyId";
        //echo "$checkIfUncertified<br/>";
        $checkUncertifiedCount = $dbh->query($checkIfUncertified)->rowCount();

        if($checkUncertifiedCount <= 0)
        {
            //
        ?>
            <tr> 
                <td><?php echo $row['agencyname'];?></td>
            </tr>          
        <?php            
        }


    }
    include 'templates/tablefooter.php';    
}
else
{
    echo "<p>There are no certifications recorded for this section</p>";
}

include 'templates/footer.php';