<?php  
 include '../dbconfig.php';
 $connect = $this->connect();   
 $query ="SELECT * FROM course ORDER BY ID DESC";  
 $result = mysqli_query($connect, $query);  
 $configs = include('../config.php');
 include HTML_BASE_URL.'header.html';
 include HTML_BASE_URL.'course/list_course.html';
 include HTML_BASE_URL.'course/create_course_modal.html';
 ?>  
  
