<?php
include "incl/header.php";
include "model/Database.php";
include "controller/Course.php";
$course = new Course();

if (isset($_GET['page']) && $_GET['page'] != "") {
    $course->pageno = $_GET['page'];
} else {
    $course->pageno = 1;
}

if (isset($_GET['d_id'])) {
    $d_id = $_GET['d_id'];
    if ($course->deletecourse($d_id)) {
        header("Location: course.php");
    }
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-7">
            <?php
            if (!empty($course->showCourses())):
            ?>

            <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped">
                    <thead>
                    <tr>
                        <th class="text-center">Edit</th>
                        <th>Course</th>
                        <th class="text-center">Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($course->showCourses() as $data):
                        ?>
                        <tr>
                            <td><a href="edit_course.php?e_id=<?php echo $data['id']; ?>"
                                   class="btn btn-primary">Edit</a></td>
                            <td><?php echo $data['course_name']; ?></td>
                            <td><a href="course.php?d_id=<?php echo $data['id']; ?>" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach;
                    ?>
                    <ul class="pagination">
                        <li><a href="?page=1">First</a></li>
                        <li class="<?php if ($course->pageno <= 1) {
                            echo 'disabled';
                        } ?>">
                            <a href="<?php if ($course->pageno <= 1) {
                                echo '#';
                            } else {
                                echo '?page=' . ($course->pageno - 1);
                            } ?>"><<</a>
                        </li>
                        <li class="<?php if ($course->pageno >= $course->totalPages) {
                            echo 'disabled';
                        } ?>">
                            <a href="<?php if ($course->pageno >= $course->totalPages) {
                                echo '#';
                            } else {
                                echo '?page=' . ($course->pageno + 1);
                            } ?>">>></a>
                        </li>
                        <li><a href="?page=<?php echo $course->totalPages; ?>">Last</a></li>
                    </ul>
                    <?php
                    else:
                        ?>
                        <h4 class="text-center">No course record added yet!</h4>
                    <?php
                    endif;
                    ?>


                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>