<?php  
error_reporting(E_ALL); ini_set('display_errors', 1);
 include '../dbconfig.php';
 $connect = $this->connect();
 $query ="SELECT * FROM assigned_courses ORDER BY ID DESC";  
 $result = mysqli_query($connect, $query);  
 $configs = include('../config.php');
 include HTML_BASE_URL.'header.html';
 include HTML_BASE_URL.'assign/assign_course.html';
 include HTML_BASE_URL.'assign/assign_course_modal.html';
 ?>  
  
