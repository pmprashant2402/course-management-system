<?php  
 include '../dbconfig.php';
 $connect = $this->connect();
 $query ="SELECT * FROM students ORDER BY ID DESC";  
 $result = mysqli_query($connect, $query);  
 $configs = include('../config.php');
 include HTML_BASE_URL.'header.html';
 include HTML_BASE_URL.'student/list_student.html';
 include HTML_BASE_URL.'student/create_student_modal.html';
 ?>  
  
