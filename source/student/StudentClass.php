<?php
/**
 * 
 */
/*
	auther : Prashant Mishra
	Date: 21/03/2021
	Project : Course Management system

*/
$configs = include('http://localhost/sage/source/config.php');
require( $configs['source_base_url'].'DbConfig.php');
require('interface/StudentInterface.php');
class StudentClass implements StudentInterface
{
	
	private $dbConnect = null;
	private $dbConfig;
	private $studentTable = 'students';
	private $studentDetailsTable = 'students_details';
	
    public function __construct(){
    	$this->dbConfig = new DbConfig();
    	$this->dbConnect = $this->dbConfig->connect();
    }

	public function list() {
		$sqlQuery = "SELECT students.id,first_name, last_name, email, contact_number, date_of_birth FROM ".$this->studentTable."  Join students_details ON students.id = students_details.student_id ";
		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= 'where(students.id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR first_name LIKE "%'.$_POST["search"]["value"].'%" ';			
			$sqlQuery .= ' OR last_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR email LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR contact_number LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR date_of_birth LIKE "%'.$_POST["search"]["value"].'%") ';			
		}
		if(!empty($_POST["order"])){
			$sqlQuery .= 'ORDER BY '.'students.'.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		} else {
			$sqlQuery .= 'ORDER BY students.id DESC ';
		}
		if($_POST["length"] != -1){
			$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}	
		//echo $sqlQuery; exit;
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		
		$totalQuery = "SELECT students.id,first_name, last_name, email, contact_number, date_of_birth FROM ".$this->studentTable." Join students_details ON students.id = students_details.student_id  ";
		
		$totalRecords = mysqli_query($this->dbConnect, $totalQuery);
		$numRows = mysqli_num_rows($totalRecords);
		$i = 1;
		$employeeData = array();	
		while( $employee = mysqli_fetch_assoc($result) ) {	
		
			$empRows = array();			
			$empRows[] = $i;
			$empRows[] = ucfirst($employee['first_name']);
			$empRows[] = $employee['last_name'];		
			$empRows[] = $employee['email'];	
			$empRows[] = $employee['contact_number'];
			$empRows[] = $employee['date_of_birth'];					
			$empRows[] = '<button type="button" name="update" id="'.$employee["id"].'" class="btn btn-warning btn-xs update">Update</button>';
			$empRows[] = '<button type="button" name="delete" id="'.$employee["id"].'" class="btn btn-danger btn-xs delete" >Delete</button>';
			$employeeData[] = $empRows;
			$i++;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"  	=>  $numRows,
			"recordsFiltered" 	=> 	$numRows,
			"data"    			=> 	$employeeData
		);
		echo json_encode($output);
	}

	public function add() {
		$response = array('sussess' => false, 'error_code' => 0, 'message' => 'Something went wrong');
		$studentsColumn = implode(',',array('first_name','last_name'));
		$tableName = $this->studentTable;
		$values = "'" . implode ( "', '", array($_POST["first_name"],$_POST["last_name"]) ) . "'";
		try {
		    $student_id = $this->dbConfig->createData($tableName, $studentsColumn, $values);
		    if(!$student_id) {
	    		 throw new Exception();
		    }
		} catch ( Exception $e) {
			echo $this->errorMessage();
		}
		if ($student_id) {
			$studentsColumn = implode(',',array('student_id', 'email', 'date_of_birth', 'contact_number'));
			$tableName = $this->studentDetailsTable;
			$values = "'" . implode ( "', '", array($student_id, $_POST["email"], $_POST["date_of_birth"], $_POST["contact_number"]) ) . "'";
			try {
		    $student_id = $this->dbConfig->createData($tableName, $studentsColumn, $values);
		    if(!$student_id) {
	    		 throw new Exception();
		    }
		} catch ( Exception $e) {
			echo $this->errorMessage();
		}
			$response = array('sussess' => true, 'error_code' => 0, 'message' => 'Registration Done');

			echo json_encode($response);
		}
	}

	public function delete(){
		if($_POST["studentId"]) {
			$filter = "WHERE id = '".$_POST["studentId"]."'";
			try {
				$response = $this->dbConfig->deleteData($this->studentTable, $filter);	
			    if(!$response) {
		    		 throw new Exception();
			    }
			} catch ( Exception $e) {
				echo $this->errorMessage();
			}	
		}
	}

	public function getStudent(){
		if($_POST["studentId"]) {
			$filter = " id = '".$_POST["studentId"]."'";
			$sql =  "SELECT students.id,first_name, last_name, email, contact_number, date_of_birth FROM ".$this->studentTable." Join students_details ON students.id = students_details.student_id where students.id = '".$_POST["studentId"]."'";
			$data = mysqli_query($this->dbConnect, $sql);
			
			try {
				$row = mysqli_fetch_assoc($data);
			    if(!$row) {
		    		 throw new Exception();
			    }
			} catch ( Exception $e) {
				echo $this->errorMessage();
			}
			echo json_encode($row);
		}
	}

	public function update(){
		if($_POST['studentId']) {	
			$updateQuery = "UPDATE ".$this->studentTable." 
			SET first_name = '".$_POST["first_name"]."', last_name = '".$_POST["last_name"]."'
				WHERE id ='".$_POST["studentId"]."'";
			$isUpdated = mysqli_query($this->dbConnect, $updateQuery);	

			$updateQuery = "UPDATE ".$this->studentDetailsTable." 
			SET email = '".$_POST["email"]."', contact_number = '".$_POST["contact_number"]."' , date_of_birth = '".$_POST["date_of_birth"]."'
			WHERE student_id ='".$_POST["studentId"]."'";
			$isUpdated = mysqli_query($this->dbConnect, $updateQuery);	


		}	
	}

	public function errorMessage() {
	    $errorMsg = "Not able to process the data";
	    return $errorMsg;
  	}




}



?>