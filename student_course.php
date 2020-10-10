<?php
include 'model/Database.php';
include_once "controller/Course.php";
include_once "controller/Students.php";

$course = new Course();
$courses = $course->showCourseWithoutPagination();

$student = new Students();
$students = $student->showStudentWithoutPagination();
if (isset($_POST['student_course'])) {
    // Senitize the external user data to avoid the SQL injection.
    $post_students = $_POST['student'];
    $post_courses = $_POST['course'];
    $reg_msg = "";
    if (!empty($post_students) && !empty($post_courses)) {
        if (!$student->subscribeToCourse($post_students, $post_courses)) {
            $reg_msg .= "<div class='alert alert-danger'>Something went wrong!</div>";
        } else {
            header("Location: report.php");
        }
    } else {
        $reg_msg .= "<div class='alert alert-danger'>Something went wrong!</div>";
    }
}

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student subscribe to course</title>
    <link rel="stylesheet" href="css/bootstrap.css"/>
    <link rel="stylesheet" href="css/font-awesome.min.css"/>
    <link rel="stylesheet" href="css/style.css"/>
</head>
<body>
<div class="row mt-5 main">
    <div class="col-md-7">
        <h3>Student subscribe to course</h3>
        <?php
        if (isset($reg_msg)) {
            echo $reg_msg;
        }
        ?>

        <form action="student_course.php" method="post" autocomplete="off">
            <div id="select_wrap" class="row mt-5 main_student_course main">
                <div class="col-md-3">
                    <select class="form-control" name="student[]" class="form-control">
                        <option>Select Student</option>
                        <?php if (!empty($students)) {
                            foreach ($students as $student) {
                                ?>
                                <option value="<?php echo $student['id'] ?>"><?php echo $student['full_name'] ?></option>
                                <?php
                            }
                        } ?>

                    </select>
                </div>

                <div class="col-md-3">
                    <select class="form-control" name="course[]" class="form-control">
                        <option>Select Course</option>
                        <?php if (!empty($courses)) {
                            foreach ($courses as $course) {
                                ?>
                                <option value="<?php echo $course['id'] ?>"><?php echo $course['course_name'] ?></option>
                                <?php
                            }
                        } ?>
                    </select>
                </div>

            </div>
            <div id="additionalselects">
            </div>
            <a class="add" href="#">
                <span class="glyphicon glyphicon-plus"></span>
            </a>
            <br>
            <div class="form-group">
                <input type="submit" name="student_course" value="Submit" class="btn btn-primary btn-block"/>
            </div>

        </form>
    </div>
</div>
<script type="text/javascript">
    jQuery(function ($) {
        $(".add").click(function () {
            $("#select_wrap").clone()
                .removeAttr("id")
                .append($('<a class="delete" href="#"><span class="glyphicon glyphicon-minus"></span></a>'))
                .appendTo("#additionalselects");
        });
        $("body").on('click', ".delete", function () {
            $(this).closest(".main_student_course").remove();
        });
    });
</script>
</body>
</html>
