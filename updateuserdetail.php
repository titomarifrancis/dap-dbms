<?php
include 'templates/headerin.php';
include 'dbconn.php';

if(isset($_REQUEST['userid']))
{
	$userId= $_REQUEST['userid'];

	$getUsrDetails = "select 
			lastname,
			firstname,
			midname,
			extname,
			position,
			contactlandline,
			contactmobile,
			contactemail,
			govtagencyid,
			regionid,
			provinceid,
			citymunicipalityid,
			barangayid,
			usrname,
			userlevelid,
			isapproved
		from systemusers
		where id=$userId";

	$userDetailStmt = $dbh->query($getUsrDetails);
	$usrDetail = $userDetailStmt->fetchAll();

	$lastname = $usrDetail[0]['lastname'];
	$firstname = $usrDetail[0]['firstname'];
	$midname = $usrDetail[0]['midname'];
	$extname = $usrDetail[0]['extname'];
	$position = $usrDetail[0]['position'];
	$contactlandline = $usrDetail[0]['contactlandline'];
	$contactmobile = $usrDetail[0]['contactmobile'];
	$contactemail = $usrDetail[0]['contactemail'];
	$govtagencyid = $usrDetail[0]['govtagencyid'];
	$regionid = $usrDetail[0]['regionid'];
	$provinceid = $usrDetail[0]['provinceid'];
	$citymunicipalityid = $usrDetail[0]['citymunicipalityid'];
	$barangayid = $usrDetail[0]['barangayid'];
	$usrname = $usrDetail[0]['usrname'];
	$userlevelid = $usrDetail[0]['userlevelid'];
	$isapproved =  $usrDetail[0]['isapproved'];
}
?>
<h3>User Access Manager</h3>
<form action="user_processor.php" method="post">
  <div class="row">
    <div class="large-12 columns">
      <label>Lastname
<?php
if(isset($lastname))
{
?>
	<input type="hidden" name="userId" value="<?php echo $userId;?>">
	<input type="text" name="lastname" value="<?php echo $lastname;?>" />
<?php
}
else
{
?>
	<input type="text" name="lastname" placeholder="Lastname" />
<?php
}
?>		

      </label>
    </div>
    <div class="large-12 columns">
      <label>Firstname
<?php	  
if(isset($firstname))
{
?>
	<input type="text" name="firstname" value="<?php echo $firstname;?>" />	
<?php
}	  
else
{
?>
	<input type="text" name="firstname" placeholder="Firstname" />
<?php
}
?>
        
      </label>
    </div>
    <div class="large-12 columns">
      <label>Middle Initial
<?php	  
if(isset($midname))
{
?>
	<input type="text" name="midname" value="<?php echo $midname; ?>" />
<?php
}
else
{
?>
	<input type="text" name="midname" placeholder="Middle Initial" />
<?php
}
?>
        
      </label>
    </div>
    <div class="large-12 columns">
      <label>Name Extension
<?php
if(isset($extname))
{
?>	
	<input type="text" name="extname" value="<?php echo $extname;?>" />
<?php
}
else
{
?>
	<input type="text" name="extname" placeholder="Ext" />
<?php
}
?>
      </label>
	</div>
    <div class="large-12 columns">
      <label>Mobile Contact Number
<?php
if(isset($contactmobile))
{
?>
	<input type="text" name="contactmobile" value="<?php echo $contactmobile;?>" />
<?php
}
else
{
?>
	<input type="text" name="contactmobile" placeholder="Mobile Contact Number" />
<?php
}
?>
      </label>
	</div>
    <div class="large-12 columns">
      <label>Landline Contact Number
<?php
if(isset($contactlandline))
{
?>
	<input type="text" name="contactlandline" value="<?php echo $contactlandline;?>" />
<?php
}
else
{
?>
	<input type="text" name="contactlandline" placeholder="Landline Contact Number" />
<?php
}
?>
        
      </label>
	</div>
    <div class="large-12 columns">
      <label>Email Address
<?php
if(isset($contactemail))
{
?>
	<input type="email" name="contactemail" value="<?php echo $contactemail;?>" />
<?php
}
else
{
?>
	<input type="email" name="contactemail" placeholder="Email Address" />
<?php
}
?>
        
      </label>
	</div>			
    <div class="large-12 columns">
      <label>Position
<?php
if(isset($position) && (strlen($position) > 0))
{
?>
	<input type="text" name="position" value="<?php echo $position;?>" />
<?php
}
else
{
?>
	<input type="text" name="position" placeholder="Role in Organization" />
<?php
}
?>	  
        
      </label>
	</div>
	<div class="large-12 columns">
	<?php
	$getAgenciesQuery = 'select id, agencyname from govtagency order by agencyname asc';
	$agencyStmt= $dbh->query($getAgenciesQuery);
	?>
      <label>Government Agency
        <select name="govtagencyid">
			<option value="0" selected>Please select one</option>
	<?php
	foreach($agencyStmt as $row)
	{
	?>
	      <option value="<?php echo $row['id'];?>" <?php if($row['id'] == $govtagencyid) echo "selected";?>><?php echo rtrim($row['agencyname']);?></option>
	<?php	
	}
	?>
        </select>
      </label>
	</div>

    <div class="large-12 columns">
	<?php
	$getRegionsQuery = 'select id, regionname from regions order by regionname asc';
	$regionStmt= $dbh->query($getRegionsQuery);
	?>
		<label>Region
		  <select name="regionid">
		  	<option value="0" selected>N/A</option>		  
	<?php
	foreach($regionStmt as $regionRow)
	{
	?>
			<option value="<?php echo $regionRow['id'];?>" <?php if($regionRow['id'] == $regionid) echo "selected";?>><?php echo rtrim($regionRow['regionname']);?></option>
	<?php
	}
	?>
		  </select>
		</label>
	  </div>
	  <div class="large-12 columns">
		<label>Province
		  <select name="provinceid">
		  	<option value="0" selected>N/A</option>
		  	<option value="1" selected>Albay</option>		  
			<option value="husker">Ilocos Norte</option>
			<option value="starbuck">Ilocos Sur</option>
			<option value="hotdog">La Union</option>
			<option value="apollo">Pangasinan</option>
		  </select>
		</label>
	  </div>
	  <div class="large-12 columns">
		<label>City/Municiplaity
		  <select name="citymunicipalityid">
		  	<option value="0" selected>N/A</option>
			<option value="1">Ligao</option>
			<option value="starbuck">Adams</option>
			<option value="hotdog">Bacarra</option>
			<option value="apollo">Bangui</option>
			<option value="starbuck">Carasi</option>
			<option value="hotdog">Dumalneg</option>
			<option value="apollo">Pasuquin</option>
			<option value="starbuck">Piddig</option>
			<option value="hotdog">Sarrat (San Miguel)</option>
			<option value="apollo">Vintar</option>
			<option value="starbuck">Burgos (Nagparitan)</option>
			<option value="hotdog">Pagudpud</option>
		
		  </select>
		</label>
	  </div>
	  <div class="large-12 columns">
		<label>Barangay
		  <select name="barangayid">
		  	<option value="NULL" selected>N/A</option>
			<option value="1">Tuburan</option>
			<option value="starbuck">Barangay No. 2, Santa Joaquina</option>
			<option value="hotdog">Barangay No. 3, Nuestra Señora del Rosario</option>
			<option value="apollo">Barangay No. 4, San Guillermo</option>
		  </select>
		</label>
	  </div>
	  <div class="large-12 columns">
		<label>Username
<?php
if(isset($usrname) && (strlen($usrname) > 0))
{
?>
	<input type="text" name="usrname" value="<?php echo $usrname;?>" />
<?php
}
else
{
?>
	<input type="text" name="usrname" placeholder="Enter e-mail as username" />
<?php
}
?>		
		  
		</label>
	  </div>
	  <div class="large-12 columns">
		<label>Password
		  <input type="password" name="usrpassword" placeholder="at least 8 alphanumeric characters" />
		</label>
	  </div>
	  <div class="large-12 columns">
	<?php
	$getLevelsQuery = 'select userlevel, leveldesc from userlevels where userlevel < 3 order by id asc';
	$levelStmt= $dbh->query($getLevelsQuery);
	?>	  
		<label>User Level
			<select name="userlevelid">	
		<?php
	foreach($levelStmt as $levelRow)
	{
	?>
			<option value="<?php echo $levelRow['userlevel'];?>" <?php if($levelRow['userlevel'] == $userlevelid) echo "selected";?>><?php echo rtrim($levelRow['leveldesc']);?></option>
	<?php
	}
	?>
			</select>		
		</label>
	  </div>
	  <div class="large-12 columns">
		<label>User Access Approval
			<p>
<?php
if(isset($isapproved) && ($isapproved == 1))
{
?>
	<input type="radio" name="isapproved" value="true" checked> True<br>
	<input type="radio" name="isapproved" value="false"> False<br>
<?php
}
else
{
?>
	<input type="radio" name="isapproved" value="true"> True<br>
	<input type="radio" name="isapproved" value="false" checked> False<br>

<?php
}
?>			
			
			
			</p>
		</label>
	  </div>	  	  
      <div class="large-12 large-centered columns">
        <input type="submit" class="button expand" value="Save"/>
      </div>
	</div>  	  	  	  	  	  	
</form>
<br/>
<div class="large-12 large-centered columns">
                    <table class="scroll hover" style="table-layout:fixed">
                        <thead>
                            <tr>
                                <th style="width: 30%">Name</th>
                                <th style="width: 15%">System Username</th>
                                <th style="width: 5%">User Level</th>
                                <th style="width: 10%">Status</th>
                                <th style="width: 23%">Created By</th>
                                <th style="width: 27%">Date Created</th>
                            </tr>
                        </thead>
                        <tbody>
<?php

//list of users: name, username, org, userlevel, status
$userListQuery = "select systemusers.id, concat(systemusers.lastname,', ', systemusers.firstname,' ', systemusers.midname) as fullname, systemusers.usrname, userlevels.userlevel, systemusers.isapproved as status, systemusers.createdby, systemusers.creationdate from systemusers, userlevels  where systemusers.userlevelid=userlevels.id and systemusers.userlevelid < 3 order by systemusers.lastname";
$userListStmt= $dbh->query($userListQuery);

foreach($userListStmt as $userListRow)
{
	$creatorName = '';
	if($userListRow['createdby'] > 0)
	{
		$creatorId= $userListRow['createdby'];
		$getCreatorById = "select concat(systemusers.lastname,', ', systemusers.firstname) as creatorname from systemusers where id=$creatorId";
		$creatorStmt= $dbh->query($getCreatorById);
		$creatorInfo = $creatorStmt->fetchAll();
		$creatorName = $creatorInfo[0]['creatorname'];
	}

	$status="Disabled";
	if($userListRow['status'] == 1)
	{
		$status="Enabled";
	}
	
	$dateCreated = date("j F Y", strtotime($userListRow['creationdate']));
?>

                            <tr>
                                <td><a href="updateuserdetail.php?userid=<?php echo $userListRow['id'];?>"><?php echo $userListRow['fullname'];?></td>
                                <td><?php echo $userListRow['usrname'];?></td>
                                <td><?php echo $userListRow['userlevel'];?></td>
                                <td><?php echo $status;?></td>
                                <td><?php echo $creatorName;?></th>
                                <td><?php echo $dateCreated;?></td>
                            </tr>
<?php
}
?>
                        </tbody>
                    </table>
</div>
<?php

include 'templates/footer.php';