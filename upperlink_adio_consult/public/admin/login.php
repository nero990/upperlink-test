<?php
  require_once("../../includes/initialize.php");

  if($session->is_logged_in()){
    redirect_to("applicant_list.php");
  }

  // Remember to give your form's submit a name="submite" attriburte!
  if(isset($_POST["submit"])){ // Form has been submitted.
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // Check database to see if username/password exist.
    $found_user = User::authenticate($username, $password);

    if($found_user) {
      $session->login($found_user);
      redirect_to("applicant_list.php");
    } else {
      // username/password combo was not found in the database
      $message = "Username/password combination incorrect.";
    }
  } else { // Form has not been submitted.
    $username = "";
    $password = "";
    $message = "";
  }
?>
<?php include_layout_template("admin_header.php"); ?>
  <div class="main public">
    <h2>Staff Login</h2>
    <?php echo output_message($message, 4); ?>
    <form action="login.php" method="POST" class="form-horizontal col-lg-6">
      <div class="form-group">
        <label class="control-label col-lg-5 input-sm">Username</label>
        <div class="col-lg-7">
          <input type="text" name="username" placeholder="Username" value="<?php echo htmlentities($username); ?>" class="form-control input-sm">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-lg-5 input-sm">Password</label>
        <div class="col-lg-7">
          <input type="password" name="password" placeholder="Password" value="" class="form-control input-sm">
        </div>
      </div>
      <div class="form-group">
        <div class="col-lg-5"></div>
        <div class="col-lg-7">
          <input type="submit" value="Sign in" name="submit" class="btn btn-primary submit">
        </div>
      </div>
    </form>
  </div>
<?php include_layout_template("footer.php"); ?>