<?php
include('course/CourseClass.php');
$course = new CourseClass();
if(!empty($_POST['action']) && $_POST['action'] == 'listCourse') {
	$course->List();
}
if(!empty($_POST['action']) && $_POST['action'] == 'addCourse') {
	$course->add();
}
if(!empty($_POST['action']) && $_POST['action'] == 'getCoursee') {
	$course->getCourse();
}
if(!empty($_POST['action']) && $_POST['action'] == 'updateCourse') {
	$course->update();
}
if(!empty($_POST['action']) && $_POST['action'] == 'deleteCourse') {
	$course->delete();
}
?>