<?php
/*
	auther : Prashant Mishra
	Date: 21/03/2021
	Project : Course Management system

*/

// Note Currently the routing is not implemented. 
// rounting and configuration implement here.
// Please run the project by running http://localhost/sage/source/student/student_details.php
$url = "http://localhost/sage/source/student/student_details.php";
 ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();

?>