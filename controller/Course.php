<?php

class Course
{
    private $db;
    public $pageno;
    public $totalPages;

    public function __construct()
    {
        $this->db = new Database();
    }

    /** Adding the course
     * @param $name
     * @param $details
     * @return bool
     */
    public function addCourse($name, $details)
    {
        if (!empty($name) && !empty($details)) {
            $this->db->query("INSERT INTO Courses(course_name,course_details) VALUES(?,?)");
            $this->db->bind(1, $name);
            $this->db->bind(2, $details);
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }

    /** Show all courses with pagination
     * @return bool
     */
    public function showCourses()
    {
        $numRecordsPerPage = 5;
        $offset = ($this->pageno - 1) * $numRecordsPerPage;
        $conn = mysqli_connect("localhost", "root", "", "sc_management");
        $total_pages_sql = "SELECT COUNT(*) FROM Courses";
        $result = mysqli_query($conn, $total_pages_sql);
        $total_rows = mysqli_fetch_array($result)[0];
        $this->totalPages = ceil($total_rows / $numRecordsPerPage);
        $this->db->query("SELECT * FROM Courses LIMIT $offset,$numRecordsPerPage");
        $row = $this->db->resultSet();
        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    /** Delete course by pasing the id
     * @param $id
     * @return bool
     */
    public function deleteCourse($id)
    {
        $this->db->query("DELETE FROM Courses WHERE id=?");
        $this->db->bind(1, $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /** Display the all courses.
     * @return mixed
     */
    public function showCourseWithoutPagination()
    {
        $this->db->query("SELECT distinct id, course_name FROM Courses");
        return $this->db->resultSet();
    }

    /** Display the single courses.
     * @param $id
     * @return bool
     */
    public function singleCourse($id)
    {
        $this->db->query("SELECT * FROM Courses WHERE id=? ORDER BY id DESC");
        $this->db->bind(1, $id);
        $row = $this->db->single();
        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    /** Update the course details
     * @param $id
     * @param $name
     * @return bool
     */
    public function updateCourse($id, $name)
    {
        $this->db->query("UPDATE Courses SET course_name=? WHERE id=?");
        $this->db->bind(1, $name);
        $this->db->bind(2, $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}