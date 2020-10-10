<?php
include "incl/header.php";
include "model/Database.php";
include "controller/Students.php";
$task = new Students();


if(isset($_GET['e_id']) && $_GET['e_id'] !== "") {
    $e_id = $_GET['e_id'];
    $list = $task->singleStudent($e_id);
    $first_name = $list['first_name'];
    $last_name = $list['last_name'];
    $dob = $list['dob'];
    $contact_no = $list['contact_no'];
}

if(isset($_GET['e_id'])) {
    $edit_id = $_GET['e_id'];
    if(isset($_POST['updateStudent'])) {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $dob = $_POST['dob'];
        $contact_no = $_POST['contact_no'];
        if(!$task->updateStudent($edit_id,$first_name,$last_name, $dob, $contact_no)) {
            die("Failed");
        } else{
            header("Location: index.php");
        }
    }
}


?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-5">
            <h3 class="text-center">Edit Students</h3>
            <form action="edit_student.php?e_id=<?php echo $_GET['e_id']; ?>" method="post" autocomplete="off">
                <div class="form-group">
                    <input value="<?php echo !empty($first_name) ? $first_name : ""; ?>" type="text" name="first_name" placeholder="First Name" class="form-control"/>
                </div>
                <div class="form-group">
                    <input value="<?php echo !empty($last_name) ? $last_name : ""; ?>" type="text" name="last_name" placeholder="Last Name" class="form-control"/>
                </div>
                <div class="form-group">
                    <input value="<?php echo !empty($dob) ? $dob : ""; ?>" type="text" name="dob" placeholder="DOB" class="form-control"/>
                </div>
                <div class="form-group">
                    <input value="<?php echo !empty($contact_no) ? $contact_no : "" ?>" type="text" name="contact_no" placeholder="Contact No" class="form-control"/>
                </div>
                <div class="form-group">
                    <input type="submit" name="updateStudent" class="btn btn-success btn-block" value="Update Student"/>
                </div>
            </form>
        </div>


    </div>
</div>






