<?php
include('CourseClass.php');
$course = new CourseClass();

if(!empty($_POST['action']) && $_POST['action'] == 'listCourse') {
	$course->List();
}
if(!empty($_POST['action']) && $_POST['action'] == 'addCourse') {
	$p = $course->add();
	echo $p; //exit;
}
if(!empty($_POST['action']) && $_POST['action'] == 'getEmployee') {
	$course->getEmployee();
}
if(!empty($_POST['action']) && $_POST['action'] == 'updateEmployee') {
	$course->updateEmployee();
}
if(!empty($_POST['action']) && $_POST['action'] == 'courseDelete') {
	$course->deleteCourse();
}
?>