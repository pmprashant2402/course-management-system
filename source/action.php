<?php
require('http://localhost/sage/source/DbConfig.php');
include('student/StudentClass.php');
$student = new StudentClass();

if(!empty($_POST['action']) && $_POST['action'] == 'listStudent') {
	$student->List();
}
if(!empty($_POST['action']) && $_POST['action'] == 'addStudent') {
	$student->add();
}
if(!empty($_POST['action']) && $_POST['action'] == 'getStudent') {
	$student->getStudent();
}
if(!empty($_POST['action']) && $_POST['action'] == 'updateStudent') {
	$student->update();
}
if(!empty($_POST['action']) && $_POST['action'] == 'studentDelete') {
	$student->delete();
}
?>