<?php
include 'templates/headerin.php';
include 'dbconn.php';

$agencycategoryId = $_REQUEST['catid'];
$getCategoryLabel = "select agencyclassdesc from govtagencyclass where id=$agencycategoryId";
//echo "$getCategoryLabel<br/>";
$getCategoryStmt = $dbh->query($getCategoryLabel)->fetchAll();
$agencyCategoryLabel = $getCategoryStmt[0]['agencyclassdesc'];
?>
<h3>Uncertified <?php echo $agencyCategoryLabel;?></h3>
<br/>
<?php
//$getAgenciesQuery = "select distinct govtagency.id as agencyid, govtagency.agencyname from govtagencyclass, govtagency, agencycertifications where agencycertifications.isapproved=true and agencycertifications.govtagencyid!=govtagency.id and govtagency.govtagencyclassid=govtagencyclass.id and govtagencyclass.id=$agencycategoryId order by govtagency.agencyname";
$getAgenciesQuery = "select govtagency.id as agencyid, govtagency.agencyname from govtagencyclass, govtagency where govtagency.govtagencyclassid=govtagencyclass.id and govtagencyclass.id=$agencycategoryId except select govtagency.id as agencyid, govtagency.agencyname from govtagency, agencycertifications where agencycertifications.govtagencyid = govtagency.id order by agencyname";

//echo "$getAgenciesQuery<br/>";
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

        //show only those not certified
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
?>
    <br/>
    <a href="reports/listuncertified_excel.php?catid=<?php echo $agencycategoryId; ?>" target="_tab"><input type="button" class="button expand" id="okButton" name="uploadBtn" value="Export as Excel"></a>&nbsp;&nbsp;<a href="reports/listuncertified_pdf.php?catid=<?php echo $agencycategoryId; ?>" target="_tab"><input type="button" class="button expand" id="okButton" name="uploadBtn" value="Export as PDF"></a>
<?php    
}
else
{
    echo "<p>There are no certifications recorded for this section</p>";
}

include 'templates/footer.php';