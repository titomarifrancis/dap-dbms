<?php
include 'templates/header.php';
?>
<h3>Login</h3>
<?php
if(isset($_REQUEST['msg']) && ($_REQUEST['msg'] == 1))
{
?>
<div data-alert class="alert-box" tabindex="0" aria-live="assertive" role="alertdialog">
    Sorry the password or username you entered does not match in any of our system<br/>
</div>
<?php
}
?>
<form id="signUpForm" action="login_processor.php" method="post">
<div class="row">
    <div class="large-12 columns">
        <label>Log in to update Agency certification details. No account yet? Click <a href="http://192.168.253.157/dap-dbms/signup.php">Create Account</a>.</label>
    </div>
    <div class="large-12 columns">
        <label>Username
            <input type="text" name="usernameField" id="usernameField" placeholder="Username" required/>
        </label>
    </div>
    <div class="large-12 columns">
        <label>Password
            <input type="password" name="passwordField" id="passwordField" placeholder="Password" required/>
        </label>
    </div>    
    <div class="large-12 large-centered columns">
        <input type="button" class="button expand" id="okButton" value="Log In" disabled>
    </div>
</form>
<script>
const signUpForm = document.getElementById('signUpForm');
const usernameField = document.getElementById('usernameField');
const passwordField = document.getElementById('passwordField');
const okButton = document.getElementById('okButton');
  
signUpForm.addEventListener('keyup', function (event) {
    //isValidEmail = emailField.checkValidity();
    isValidUsername = usernameField.checkValidity();
    isValidPassword = passwordField.checkValidity();

    if ( isValidUsername && isValidPassword )
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