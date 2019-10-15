<?php
include 'templates/headerin.php';
include 'dbconn.php';

$providerorgid = '';
if(isset($_REQUEST['providerorgid']))
{
    $providerorgid = $_REQUEST['providerorgid'];

    $getCertBodyDetails = "select * from certifyingbody where id=$providerorgid";
    $certbodyStmt = $dbh->query($getCertBodyDetails);
    $certbodyDetail = $certbodyStmt->fetchAll();

	$ispabaccredited = $certbodyDetail[0]['ispabaccredited'];
	$providerorg = $certbodyDetail[0]['providerorg'];
    $isapproved = $certbodyDetail[0]['isapproved'];
    
    //echo "$ispabaccredited, $providerorg, $isapproved";
    //die();
}
?>
<h3>Certifying Body Details</h3>
<form action="certbody_processor.php" method="post">
    <div class="row">
        <div class="large-12 columns">
            <label>Certifying Body
<?php
if(isset($providerorgid) && $providerorgid !== '')
{
?>
                <input type="hidden" name="providerorgid" value="<?php echo $providerorgid;?>">
                <input type="text" name="providerorg" value="<?php echo $providerorg;?>" />
<?php
}
else
{
?>
                <input type="text" name="providerorg" placeholder="Type certifying body name" />
<?php
}
?>            
            </label>
        </div>
<?php
//this only appears to DAP user
if(isset($loggedInAccessLevel) && $loggedInAccessLevel > 1)
{
?>
        <div class="large-12 columns">
            <label>PAB Accredited?
                <p>
<?php
if($ispabaccredited == 1)
{
?>
                    <input type="radio" name="ispabaccredited" value="true" checked> Yes<br>
                    <input type="radio" name="ispabaccredited" value="false"> No<br>

<?php
}
else
{
?>
                    <input type="radio" name="ispabaccredited" value="true"> Yes<br>
                    <input type="radio" name="ispabaccredited" value="false" checked> No<br>

<?php
}
?>

                </p>
        </div>
        <div class="large-12 columns">
            <label>Enable/Approve Certifying Body
                <p>
<?php
if($isapproved == 1)
{
?>
                    <input type="radio" name="isapproved" value="true" checked> Approve<br>
                    <input type="radio" name="isapproved" value="false"> Disapprove<br>
<?php
}
else
{
?>
                    <input type="radio" name="isapproved" value="true"> Approve<br>
                    <input type="radio" name="isapproved" value="false" checked> Disapprove<br>
<?php
}
?>                

                </p>
        </div>         
<?php
}
?>
        
        <div class="large-12 large-centered columns">
            <input type="submit" class="button expand" value="Save"/>
        </div>
    </div>
</form>

<br/>
<table class="scroll hover" style="table-layout:fixed">
    <thead>
        <tr>
            <th style="width: 35%">Certifying Body</th>
            <th style="width: 10%">PAB Accredited?</th>
            <th style="width: 5%">Status</th>
            <th style="width: 15%">Approved By</th>
            <th style="width: 15%">Created By</th>
            <th style="width: 20%">Date Created</th>
        </tr>
    </thead>
    <tbody>

<?php
//list certifying body
$getCertBody = "select * from certifyingbody";
$certBodyStmt = $dbh->query($getCertBody);

foreach($certBodyStmt as $certBodyRow)
{
    $isPAB = 'No';
    if($certBodyRow['ispabaccredited'] == 1)
    {
        $isPAB = "Yes";
    }

    $isApproved = 'Disabled';
    $approverName = '';
    if($certBodyRow['isapproved'] == 1)
    {
        $isApproved = "Enabled";

        if($certBodyRow['approvedby'] > 0)
        {
            $approverId = $certBodyRow['approvedby'];
            $getApproverById = "select concat(systemusers.lastname,', ', systemusers.firstname) as approvername from systemusers where id=$approverId";
            $approverStmt= $dbh->query($getApproverById);
            $approverInfo = $approverStmt->fetchAll();
            $approverName = $approverInfo[0]['approvername'];
        }
    }

	$creatorName = '';
	if($certBodyRow['createdby'] > 0)
	{
		$creatorId= $certBodyRow['createdby'];
		$getCreatorById = "select concat(systemusers.lastname,', ', systemusers.firstname) as creatorname from systemusers where id=$creatorId";
		$creatorStmt= $dbh->query($getCreatorById);
		$creatorInfo = $creatorStmt->fetchAll();
        $creatorName = $creatorInfo[0]['creatorname'];
    }

    $creationDate = date("j F Y", strtotime($certBodyRow['creationdate']));
?>
        <tr>
<?php
if(isset($loggedInAccessLevel) && $loggedInAccessLevel > 1)
{
?>
            <td><a href="certifyingbodymanager.php?providerorgid=<?php echo $certBodyRow['id'];?>"><?php echo $certBodyRow['providerorg'];?></a></td>
<?php
}
else
{
?>
            <td><?php echo $certBodyRow['providerorg'];?></td>
<?php
}
?>


            <td><?php echo $isPAB;?></td>
            <td><?php echo $isApproved;?></td>
            <td><?php echo $approverName;?></td>
            <td><?php echo $creatorName;?></td>
            <td><?php echo $creationDate;?></td>
        </tr>
<?php
}
?>
                        </tbody>
                    </table>
<?php
//certifying body name, is PAB, isapproved, created by, date created
?>



<?php
include 'templates/footer.php';