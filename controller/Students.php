<?php

class Students
{
    private $first_name;
    private $last_name;
    private $dob;
    private $contact_no;
    private $db;
    public $pageno;
    public $totalPages;

    public function __construct()
    {
        $this->db = new Database();
    }

    /** Handle the student registration.
     * @param $first_name
     * @param $last_name
     * @param $dob
     * @param $contact_no
     * @return bool
     */
    public function addStudent($first_name, $last_name, $dob, $contact_no)
    {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $dt = \DateTime::createFromFormat('m/d/Y', $dob);
        $this->dob = $dt->format('Y-m-d');
        $this->contact_no = $contact_no;

        // Registering the student
        if (!empty($this->first_name) && !empty($this->last_name) && !empty($this->dob) && !empty($this->contact_no)) {
            $this->db->query("INSERT INTO students (first_name,last_name,dob, contact_no) VALUES(?,?,?,?)");
            $this->db->bind(1, $this->first_name);
            $this->db->bind(2, $this->last_name);
            $this->db->bind(3, $this->dob);
            $this->db->bind(4, $this->contact_no);
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /** Showing the all students with pagination
     * @return bool
     */
    public function showStudent()
    {
        $numRecordsPerPage = 2;
        $offset = ($this->pageno - 1) * $numRecordsPerPage;
        $conn = mysqli_connect("localhost", "root", "", "sc_management");
        $total_pages_sql = "SELECT COUNT(*) FROM students";
        $result = mysqli_query($conn, $total_pages_sql);
        $total_rows = mysqli_fetch_array($result)[0];
        $this->totalPages = ceil($total_rows / $numRecordsPerPage);
        $this->db->query("SELECT * FROM students ORDER BY id DESC LIMIT $offset,$numRecordsPerPage");
        $row = $this->db->resultSet();
        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    /** Show all students without pagination
     * @return mixed
     */
    public function showStudentWithoutPagination()
    {
        $this->db->query("SELECT distinct id, CONCAT(first_name , ' ' , last_name) as full_name FROM Students");
        return $this->db->resultSet();
    }

    /** Show report regarding the student and course relation.
     * @return mixed
     */
    public function showReport()
    {
        $this->db->query("SELECT distinct course_name, CONCAT(first_name , ' ' , last_name) as student_name
                                FROM students 
                                INNER JOIN student_courses ON student_courses.student_id=students.id
                                INNER JOIN courses ON student_courses.course_id = courses.id;");
        return $this->db->resultSet();
    }

    /** Show single student details
     * @param $id
     * @return bool
     */
    public function singleStudent($id)
    {
        $this->db->query("SELECT * FROM students WHERE id=? ORDER BY id DESC");
        $this->db->bind(1, $id);
        $row = $this->db->single();
        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    /** Subscribe course by student.
     * @param $course_ids
     * @param $student_ids
     * @return bool
     */
    public function subscribeToCourse($course_ids, $student_ids)
    {
        if (!empty($course_ids) && !empty($student_ids)) {
            $query = "INSERT INTO student_courses (course_id,student_id) VALUES";
            $qPart = array_fill(0, count($course_ids), "(?, ?)");
            $query .= implode(",", $qPart);
            $this->db->query($query);
            $i = 1;
            $k = 0;
            foreach ($course_ids as $course_id) { //bind the values one by one
                $this->db->bind($i++, $student_ids[$k]);
                $this->db->bind($i++, $course_id);
                $k++;
            }
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /** Update the student details
     * @param $id
     * @param $first_name
     * @param $last_name
     * @param $dob
     * @param $contact_no
     * @return bool
     */
    public function updateStudent($id, $first_name, $last_name, $dob, $contact_no)
    {
        $this->db->query("UPDATE students SET first_name=?,last_name=?,dob=?,contact_no=? WHERE id=?");
        $this->db->bind(1, $first_name);
        $this->db->bind(2, $last_name);
        $this->db->bind(3, $dob);
        $this->db->bind(4, $contact_no);
        $this->db->bind(5, $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /** Delete student by pasing specific student id.
     * @param $id
     * @return bool
     */
    public function deleteStudent($id)
    {
        $this->db->query("DELETE FROM students WHERE id=?");
        $this->db->bind(1, $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}