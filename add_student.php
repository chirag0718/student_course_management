<?php

include 'model/Database.php';
include_once "controller/Students.php";

$student = new Students();
if (isset($_POST['student_register'])) {
    // Senitize the external user data to avoid the SQL injection.
    $first_name = htmlspecialchars($_POST['first_name'], ENT_QUOTES);
    $last_name = htmlspecialchars($_POST['last_name'], ENT_QUOTES);
    $dob = htmlspecialchars($_POST['dob'], ENT_QUOTES);
    $contact_no = htmlspecialchars($_POST['contact_no'], ENT_QUOTES);

    $reg_msg = "";
    if (!$student->addStudent($first_name, $last_name, $dob, $contact_no)) {
        $reg_msg .= "<div class='alert alert-danger'>Something went wrong!</div>";
    } else {
        $reg_msg .= "<div class='alert alert-success'>Registered successfully!</div>";
        header("Location: index.php");
    }
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Registration</title>
    <link rel="stylesheet" href="css/bootstrap.css"/>
    <link rel="stylesheet" href="css/font-awesome.min.css"/>
    <link rel="stylesheet" href="css/style.css"/>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"/>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
<div class="row mt-5 main">
    <div class="col-md-7">
        <h3>Student Registration</h3>
        <?php
        if (isset($reg_msg)) {
            echo $reg_msg;
        }
        ?>
        <form action="" method="post" autocomplete="off">
            <div class="form-group">
                <input type="text" name="first_name" placeholder="First Name" class="form-control"/>
            </div>
            <div class="form-group">
                <input type="text" name="last_name" placeholder="Last Name" class="form-control"/>
            </div>
            <div class="form-group">
                <input type="text" name="dob" placeholder="DOB" class="form-control"/>
            </div>
            <div class="form-group">
                <input type="text" name="contact_no" placeholder="Contact No" class="form-control"/>
            </div>
            <div class="form-group">
                <input type="submit" name="student_register" value="Submit" class="btn btn-primary btn-block"/>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $('.datepicker').datepicker({
        format: 'mm/dd/yyyy',
        startDate: '-3d'
    });
</script>
</body>
</html>


