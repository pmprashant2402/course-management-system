<?php
include('assigned/AssignClass.php');
$assign = new AssignClass();
if(!empty($_POST['action']) && $_POST['action'] == 'listAssignedCourse') {
	$assign->List();
}
if(!empty($_POST['action']) && $_POST['action'] == 'assignCourse') {
	$assign->add();
}
if(!empty($_POST['action']) && $_POST['action'] == 'listStudentCourse') {
	$assign->fetchStudentCourse();
}
if(!empty($_POST['action']) && $_POST['action'] == 'getAssignedCourse') {
	$assign->getById();
}
if(!empty($_POST['action']) && $_POST['action'] == 'updateAssignedCourse') {
	$assign->update();
}
if(!empty($_POST['action']) && $_POST['action'] == 'assignDelete') {
	$assign->delete();
}


?>