<?php include_once "../includes/initialize.php"; ?>

<?php
	include_layout_template("header.php","Home");
?>
  <div class="main public">
    <script>
      $(document).ready(function(){
        $('#lga_id').change(function(){
          if ($(this).val() != ''){
            $('#form').submit();
          }
        }); // end change
      });
    </script>
    <h1>Welcome to Adio Consultancy Group</h1>
    <?php if(Applicant::count() >= 4){ ?>
      <p style="font-size: 20px;"><em>Application closed</em></p>
    <?php } else { ?>
      <p>We are currently recruiting for the post of Software Quality Assurance Officer. Click on the link below to apply.</p>
      <p><a href="apply.php">Click here to apply</a></p>
    <?php } ?>
    <div class="clearfix"></div>

  </div>
  <p><a href="admin/applicant_list.php" target="_blank">Admin session</a></p>

<?php include_layout_template("footer.php"); ?>