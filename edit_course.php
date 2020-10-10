<?php
include "incl/header.php";
include "model/Database.php";
include "controller/Course.php";
$course = new Course();


if(isset($_GET['e_id']) && $_GET['e_id'] !== "") {
    $e_id = $_GET['e_id'];
    $list = $course->singlecourse($e_id);
    if(!empty($list)) {
        $course_name = $list['course_name'];
    } else {
        header("Location: course.php");
    }
}

if(isset($_GET['e_id'])) {
    $edit_id = $_GET['e_id'];
    if(isset($_POST['updatecourse'])) {
        $course_name = $_POST['course_name'];
        if(!$course->updatecourse($edit_id,$course_name)) {
            die("Failed");
        } else{
            header("Location: course.php");
        }
    }
}

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-5">
            <h3 class="text-center">Edit courses</h3>
            <form action="edit_course.php?e_id=<?php echo $_GET['e_id']; ?>" method="post" autocomplete="off">
                <div class="form-group">
                    <input value="<?php echo !empty($course_name) ? $course_name : "" ?>" type="text" name="course_name" placeholder="Course Name" class="form-control"/>
                </div>
                <div class="form-group">
                    <input type="submit" name="updatecourse" class="btn btn-success btn-block" value="Update course"/>
                </div>
            </form>
        </div>


    </div>
</div>






