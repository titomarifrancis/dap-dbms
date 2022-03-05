<?php
//find agency
include 'templates/headerin.php';
include 'dbconn.php';
?>
<h3>Find Agency</h3>
<form id="findAgencyForm" method="post" onSubmit="findagencysec_processor.php">
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
include 'templates/footer.php';