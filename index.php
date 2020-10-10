<?php
include "incl/header.php";
include "model/Database.php";
include "controller/Students.php";
$student = new Students();

if (isset($_GET['page']) && $_GET['page'] != "") {
    $student->pageno = $_GET['page'];
} else {
    $student->pageno = 1;
}

if (isset($_GET['d_id'])) {
    $d_id = $_GET['d_id'];
    if ($student->deleteStudent($d_id)) {
        header("Location: index.php");
    }
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-7">
            <?php
            if (!empty($student->showStudent())):
            ?>

            <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped">
                    <thead>
                    <tr>
                        <th class="text-center">Edit</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th class="text-center">Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($student->showStudent() as $data):
                        ?>
                        <tr>
                            <td><a href="edit_student.php?e_id=<?php echo $data['id']; ?>"
                                   class="btn btn-primary">Edit</a></td>
                            <td><?php echo $data['first_name']; ?></td>
                            <td><?php echo $data['last_name']; ?></td>
                            <td><a href="index.php?d_id=<?php echo $data['id']; ?>" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach;
                    ?>
                    <ul class="pagination">
                        <li><a href="?page=1">First</a></li>
                        <li class="<?php if ($student->pageno <= 1) {
                            echo 'disabled';
                        } ?>">
                            <a href="<?php if ($student->pageno <= 1) {
                                echo '#';
                            } else {
                                echo '?page=' . ($student->pageno - 1);
                            } ?>"><<</a>
                        </li>
                        <li class="<?php if ($student->pageno >= $student->totalPages) {
                            echo 'disabled';
                        } ?>">
                            <a href="<?php if ($student->pageno >= $student->totalPages) {
                                echo '#';
                            } else {
                                echo '?page=' . ($student->pageno + 1);
                            } ?>">>></a>
                        </li>
                        <li><a href="?page=<?php echo $student->totalPages; ?>">Last</a></li>
                    </ul>
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






