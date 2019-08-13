<?php
include 'templates/header.php';
?>
<form action="login_processor.php" method="post">
  <div class="row">
    <div class="large-12 columns">
      <label>Username
        <input type="text" name="usernameField" method="post" placeholder="Username" />
      </label>
    </div>
    <div class="large-12 columns">
      <label>Password
        <input type="password" name="passwordField" method="post" placeholder="Password" />
      </label>
    </div>
    </div>
    <div class="row">
        <div class="large-12 large-centered columns">
          <input type="submit" class="button expand" value="Log In"/>
        </div>
      </div>      
</form>
<?php
include 'templates/footer.php';