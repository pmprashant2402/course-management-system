<?php  
 include 'http://localhost/sage/source/DbConfig.php';
 include 'http://localhost/sage/source/config.php';
 include 'http://localhost/sage/public_html/html/header.html';
 include 'http://localhost/sage/public_html/html/student/list_student.html';
 include 'http://localhost/sage/public_html/html/student/create_student_modal.html';
//include 'http://localhost/sage/source/student/StudentClass.php';
include('student/StudentClass.php');


$response = array('status' => 'failed', 'error_code' => 1 );
/*if(!isset($_POST['api']) && empty($_POST['api'])) {
	$student = new StudentClass();
	$student->list();	
}*/


//echo "<pre>"; print_r($_POST); exit;
if(isset($_POST['action']) && !empty($_POST['action'])) {
	$class = ucfirst($_POST['api']);
	$classObj = new $class;
	switch ($_POST['action']) {
		case 'value':
			case 'create':
				echo "innn"; exit;
			break;

			case 'list':
				$classObj->list(); 
			break;

			case 'get':
				
			break;

			case 'update':
				
			break;

			case 'delete':
				
			break;
		
		default:
			//$class = ucfirst($_POST['api']);
			$classObj = new StudentClass();
			$classObj->list(); 
			//echo "innn default"; exit;
			# code...
			break;
	}
}
 ?>  
  
