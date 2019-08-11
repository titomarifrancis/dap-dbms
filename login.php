<?php
include 'templates/header.php';
?>
<form action="login_processor.php">
  <div class="row">
    <div class="large-12 columns">
      <label>Username
        <input type="text" placeholder="Username" />
      </label>
    </div>
    <div class="large-12 columns">
      <label>Password
        <input type="password" placeholder="Password" />
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