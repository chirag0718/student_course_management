<?php

include "model/Database.php";
include "controller/Students.php";
$student = new Students();

if (isset($_GET['page']) && $_GET['page'] != "") {
    $student->pageno = $_GET['page'];
} else {
    $student->pageno = 1;
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Report</title>
    <link rel="stylesheet" href="css/bootstrap.css"/>
    <link rel="stylesheet" href="css/font-awesome.min.css"/>
    <link rel="stylesheet" href="css/style.css"/>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-7">
            <h3>Reports</h3>
            <?php
            if (!empty($student->showReport())):
            ?>

            <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Course Name</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($student->showReport() as $data):
                        ?>
                        <tr>
                            <td><?php echo $data['student_name']; ?></td>
                            <td><?php echo $data['course_name']; ?></td>

                            </td>
                        </tr>
                    <?php endforeach;
                    ?>
                    <?php
                    else:
                        ?>
                        <h4 class="text-center">No Student record added yet!</h4>
                    <?php
                    endif;
                    ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
</body>
</html>





