<?php
//find agency
include 'templates/header.php';
include 'dbconn.php';
?>
<h3>Find Agency</h3>
<form id="certForm" method="post" action="agencycert_processor.php" enctype="multipart/form-data">
  <div class="row">
    <div class="large-12 columns">
      <label>Full or Partial Name of the Agency
        <input type="text" name="certificationsite" id="certificationsite" placeholder="Type the Full or Partial Name of the Agency Here">
      </label>
    </div>
	</div>
</form>

<?php
include 'templates/footer.php';