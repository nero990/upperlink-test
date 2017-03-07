<?php include_once "../../includes/initialize.php"; ?>
<?php if(!$session->is_logged_in()) {redirect_to("login.php"); } ?>
<?php
  include_layout_template("admin_header.php","Dashboard");
  include_layout_template("admin_sidebar.php");
?>
  <div class="main">

    <h1>Welcome to Adio Consultancy Group</h1>

    <div class="col-sm-9">
      <table class="table">
        <tr>
          <th>S/N</th>
          <th>Name</th>
          <th>Phone Number</th>
          <th>Email</th>
        </tr>
        <?php
          $applicants = Applicant::find_all();
          $count = 1;

          foreach($applicants AS $applicant) {
            echo "<tr>
                  <td>$count</td>
                  <td>{$applicant->surname} {$applicant->first_name}</td>
                  <td>{$applicant->phone}</td>
                  <td>{$applicant->email}</td>
                </tr>";
            $count++;
          }
        ?>
      </table>
    </div>
    <div class="clearfix"></div>

  </div>

<?php include_layout_template("footer.php"); ?>