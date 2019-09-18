<?php
include 'templates/headerin.php';
include 'dbconn.php';

$userId = '';
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
      <label>Last Name
<?php
if(isset($userId) && ($userId !== ''))
{
?>
	<input type="hidden" name="userId" value="<?php echo $userId;?>">
<?php
}

if(isset($lastname))
{
?>
	
	<input type="text" name="lastname" value="<?php echo $lastname;?>" required/>
<?php
}
else
{
?>
	<input type="text" name="lastname" placeholder="Lastname" required/>
<?php
}
?>		

      </label>
    </div>
    <div class="large-12 columns">
      <label>First Name
<?php	  
if(isset($firstname))
{
?>
	<input type="text" name="firstname" value="<?php echo $firstname;?>" required/>	
<?php
}	  
else
{
?>
	<input type="text" name="firstname" placeholder="Firstname" required/>
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
	<input type="text" name="midname" value="<?php echo $midname; ?>" required/>
<?php
}
else
{
?>
	<input type="text" name="midname" placeholder="Middle Initial" required/>
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
	<input type="text" name="contactmobile" value="<?php echo $contactmobile;?>" required/>
<?php
}
else
{
?>
	<input type="text" name="contactmobile" placeholder="Mobile Contact Number" required/>
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
	<input type="text" name="contactlandline" value="<?php echo $contactlandline;?>" required/>
<?php
}
else
{
?>
	<input type="text" name="contactlandline" placeholder="Landline Contact Number" required/>
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
	<input type="email" name="contactemail" value="<?php echo $contactemail;?>" required/>
<?php
}
else
{
?>
	<input type="email" name="contactemail" placeholder="Email Address" required/>
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
	<input type="text" name="position" value="<?php echo $position;?>" required/>
<?php
}
else
{
?>
	<input type="text" name="position" placeholder="Role in Organization" required/>
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
        <select name="govtagencyid" required>
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
		<label>Region
            <select id="region" name="region">
            </select>
		</label>
	</div>
    <div class="large-12 columns">
		<label>Province
			<select id="province" name="province">
                <option>Select region first</option>
            </select>
	</div>    
    <div class="large-12 columns">
		<label>City/Municipality
			<select id="citymunicipality" name="citymunicipality">
                <option>Select province first</option>
            </select>
	</div>
    <div class="large-12 columns">
		<label>Barangay
			<select id="barangay" name="barangay">
                <option>Select city/municipality first</option>
            </select>
	</div>

	  <div class="large-12 columns">
		<label>Username
<?php
if(isset($usrname) && (strlen($usrname) > 0))
{
?>
	<input type="text" name="usrname" value="<?php echo $usrname;?>" required/>
<?php
}
else
{
?>
	<input type="text" name="usrname" placeholder="Enter e-mail as username" required/>
<?php
}
?>		
		  
		</label>
	  </div>
	  <div class="large-12 columns">
		<label>Password
		  <input type="password" name="usrpassword" placeholder="at least 8 alphanumeric characters"/>
		</label>
	  </div>
	  <div class="large-12 columns">
	<?php
	$getLevelsQuery = 'select userlevel, leveldesc from userlevels where userlevel < 3 order by id asc';
	$levelStmt= $dbh->query($getLevelsQuery);
	?>	  
		<label>User Level
			<select name="userlevelid" id="userlevelField" required>	
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
$userListQuery = "select systemusers.id, concat(systemusers.lastname,', ', systemusers.firstname,' ', systemusers.midname) as fullname, systemusers.usrname, userlevels.userlevel, systemusers.isapproved as status, systemusers.createdby, systemusers.creationdate from systemusers, userlevels  where userlevels.userlevel=systemusers.userlevelid and systemusers.userlevelid < 3 order by systemusers.lastname";
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
<script>
$(function(){
    $.getJSON("lib/getRegions.php", function(json){
            console.log(json);
            $('select#region').empty();
            $('select#region').append($('<option>').text("Select"));
            $.each(json, function(i, obj){
                    $('select#region').append($('<option>').text(obj.regionname).attr('value', obj.id));
            });
    });
    $("#region").change(function() {
        $.getJSON("lib/getProvince.php?regionid=" + $(this).val() + "", function(data){
            console.log(data);
            $('select#province').empty();
            $('select#province').append($('<option>').text("Select"));
            $.each(data, function(j, myobj){
                    $('select#province').append($('<option>').text(myobj.provincename).attr('value', myobj.id));
            });            
        });
    });
    $("#province").change(function() {
        $.getJSON("lib/getCityMunicipality.php?provinceid=" + $(this).val() + "", function(provincedata){
            console.log(provincedata);
            $('select#citymunicipality').empty();
            $('select#citymunicipality').append($('<option>').text("Select"));
            $.each(provincedata, function(k, mycitymunobj){
                    $('select#citymunicipality').append($('<option>').text(mycitymunobj.towncitymunicipalityname).attr('value', mycitymunobj.id));
            });            
        });
    });
    $("#citymunicipality").change(function() {
        $.getJSON("lib/getBarangay.php?citymunid=" + $(this).val() + "", function(citymunicipalitydata){
            console.log(citymunicipalitydata);
            $('select#barangay').empty();
            $('select#barangay').append($('<option>').text("Select"));
            $.each(citymunicipalitydata, function(l, barangayobj){
                    $('select#barangay').append($('<option>').text(barangayobj.barangayname).attr('value', barangayobj.id));
            });            
        });
    });    
});
</script>
<?php

include 'templates/footer.php';