<?php


include 'model/Database.php';
include_once "controller/Course.php";


$course = new Course();
if (isset($_POST['course_register'])) {

    // Senitize the external user data to avoid the SQL injection.
    $name = htmlspecialchars($_POST['course_name'], ENT_QUOTES);
    $details = htmlspecialchars($_POST['course_details'], ENT_QUOTES);

    $reg_msg = "";
    if (!$course->addCourse($name, $details)) {
        $reg_msg .= "<div class='alert alert-danger'>Something went wrong!</div>";
    } else {
        $reg_msg .= "<div class='alert alert-success'>Registered course successfully!</div>";
        header("Location: course.php");
    }
}

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Course Details</title>
    <link rel="stylesheet" href="css/bootstrap.css"/>
    <link rel="stylesheet" href="css/font-awesome.min.css"/>
    <link rel="stylesheet" href="css/style.css"/>
</head>
<body>
<div class="row mt-5 main">
    <div class="col-md-7">
        <h3>Course Details</h3>
        <?php
        if (isset($reg_msg)) {
            echo $reg_msg;
        }
        ?>
        <form action="" method="post" autocomplete="off">
            <div class="form-group">
                <input type="text" name="course_name" placeholder="Course Name" class="form-control"/>
            </div>
            <div class="form-group">
                <input type="text" name="course_details" placeholder="Course Details" class="form-control"/>
            </div>
            <div class="form-group">
                <input type="submit" name="course_register" value="Submit" class="btn btn-primary btn-block"/>
            </div>
        </form>
    </div>
</div>
</body>
</html>
