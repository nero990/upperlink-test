<?php include_once "../includes/initialize.php"; ?>
<?php
  if(Applicant::count() >= 4){
    redirect_to("index.php");
  }
  $message = "";
  $alert_type = 0;
  $max_file_size = 1048576; // expressed in bytes

  if(isset($_POST["submit"])) {
    $first_name = $_POST["first_name"];
    $surname = $_POST["surname"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];

    $applicant = new Applicant();
    $applicant->first_name = $first_name;
    $applicant->surname = $surname;
    $applicant->phone = $phone;
    $applicant->email = $email;

    $applicant->attach_file($_FILES['file_upload']);

    if($applicant->save()) {
      $message = "<b>{$first_name}</b>, your application has been received.";
      $alert_type = 1;
      $first_name = $surname = $phone = $email = "";
    } else {
      $message = "There was a problem preventing your application been saved.<br>";
      $message .= join("<br>", $applicant->errors);
      $alert_type = 4;
    }
  } else{
    $first_name = $surname = $phone = $email = "";
  }
?>
<?php
  include_layout_template("header.php","Home");
?>
  <div class="main public">
    <?php echo output_message($message, $alert_type); ?>

    <p>Fill the form to apply.</p>

    <form action="" method="POST" enctype="multipart/form-data" class="form-horizontal" role="form">
      <div class="form-group">
        <label class="control-label col-sm-2">First Name</label>
        <div class="col-sm-4">
          <input type="text" name="first_name" value="" placeholder="Type-in first name" class="form-control" required>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2">Surname</label>
        <div class="col-sm-4">
          <input type="text" name="surname" value="" placeholder="Type-in surname" class="form-control" required>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2">Phone Number</label>
        <div class="col-sm-4">
          <input type="text" name="phone" value="" placeholder="Type-in your mobile phone number" class="form-control" required>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2">Email Address</label>
        <div class="col-sm-4">
          <input type="text" name="email" value="" placeholder="Type-in email address" class="form-control" required>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2">Passport Photograph</label>
        <input type="hidden" name="MAX_FILE_SIZE" value="<?php $max_file_size; ?>">
        <input type="file" name="file_upload" required>
      </div>
      <div class="form-group">
        <div class="col-sm-2"></div>
        <div class="col-sm-4">
          <input type="submit" name="submit" value="Submit Form" class="btn btn-primary" required>
        </div>
      </div>

    </form>

  </div>

<?php include_layout_template("footer.php"); ?>