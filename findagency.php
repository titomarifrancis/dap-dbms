<?php
//find agency
include 'templates/header.php';
include 'dbconn.php';
?>
<h3>Find Agency</h3>
<form id="findAgencyForm" method="post" onSubmit="<?php echo $_SERVER['PHP_SELF'];?>">
  <div class="row">
    <div class="large-12 columns">
      <label>Full or Partial Name of the Agency
        <input type="text" name="partfullagencyname" id="partfullagencyname" placeholder="Type the Full or Partial Name of the Agency Here">
      </label>
    </div>
    <div class="large-12 large-centered columns">
        <input type="button" class="button expand" id="okButton" value="Find" disabled>
    </div>    
	</div>
</form>
<script>
const signUpForm = document.getElementById('findAgencyForm');
const usernameField = document.getElementById('partfullagencyname');

const okButton = document.getElementById('okButton');
  
signUpForm.addEventListener('keyup', function (event) {
    //isValidEmail = emailField.checkValidity();
    isValidUsername = usernameField.checkValidity();

    if ( isValidUsername )
    {
        okButton.disabled = false;
    }
    else
    {
        okButton.disabled = true;
    }
});

 
okButton.addEventListener('click', function (event) {
  signUpForm.submit();
});
</script>
<?php
if(isset($_POST['partfullagencyname']))
{
  $searchString = $_POST['partfullagencyname'];
  $findAgencyName = "select govtagency.agencyname, agencycertifications.id from govtagency, agencycertifications where agencycertifications.govtagencyid=govtagency.id and govtagency.agencyname like '%".$searchString."%'";
  echo $findAgencyName<br/>;
}


include 'templates/footer.php';