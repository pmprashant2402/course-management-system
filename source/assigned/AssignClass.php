<?php
/*
	auther : Prashant Mishra
	Date: 21/03/2021
	Project : Course Management system

*/
$configs = include('http://localhost/sage/source/config.php');
require( $configs['source_base_url'].'DbConfig.php');
require('interface/AssignInterface.php');
class AssignClass implements AssignInterface
{
	
	private $dbConnect = null;
	private $dbConfig;
	private $AssignTable = 'assigned_courses';
	
    public function __construct(){
    	$this->dbConfig = new DbConfig();
    	$this->dbConnect = $this->dbConfig->connect();    }

	public function list() {
		$sqlQuery = "SELECT assigned_courses.id, student_id, course_id, CONCAT(std.first_name, ' ', std.last_name) as student_name, crc.name as course FROM ".$this->AssignTable." ";
		$sqlQuery .= "left JOIN students std ON std.id =  ".$this->AssignTable.".student_id ";
		$sqlQuery .= "left JOIN course crc ON crc.id =  ".$this->AssignTable.".course_id ";

		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= 'where( assigned_courses.id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR student_id LIKE "%'.$_POST["search"]["value"].'%" ';			
			$sqlQuery .= ' OR course_id LIKE "%'.$_POST["search"]["value"].'%") ';		
		}
		if(!empty($_POST["order"])){
			$sqlQuery .= 'ORDER BY ".$this->AssignTable."'.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		} else {
			$sqlQuery .= 'ORDER BY assigned_courses.id DESC ';
		}
		if($_POST["length"] != -1){
			$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}	
		
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$totalQuery = "SELECT student_id, course_id FROM ".$this->AssignTable."";

		$totalRecords = mysqli_query($this->dbConnect, $totalQuery);
		$numRows = mysqli_num_rows($totalRecords);
		$AssignData = array();	
		$i = 1;
		while( $Assign = mysqli_fetch_assoc($result) ) {	
		
			$AssignRows = array();			
			$AssignRows[] = $i;
			$AssignRows[] = ucfirst($Assign['student_id']);
			$AssignRows[] = $Assign['course_id'];							
			$AssignRows[] = $Assign['student_name'];							
			$AssignRows[] = $Assign['course'];							
			$AssignRows[] = '<button type="button" student_id="update" id="'.$Assign["id"].'" class="btn btn-warning btn-xs update">Update</button>';
			$AssignRows[] = '<button type="button" student_id="delete" id="'.$Assign["id"].'" class="btn btn-danger btn-xs delete" >Delete</button>';
			$AssignData[] = $AssignRows;
			$i++;
		}
		//echo "<pre>"; print_r($AssignRows); exit;
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"  	=>  $numRows,
			"recordsFiltered" 	=> 	$numRows,
			"data"    			=> 	$AssignData
		);
		echo json_encode($output);
	}

	public function add() {
		$response = array('sussess' => false, 'error_code' => 0, 'message' => 'Something went wrong');
		$AssignsColumn = implode(',',array('student_id','course_id'));
		$tableName = $this->AssignTable;
		if(isset($_POST['course_id']) || isset($_POST['student_id'])) {
			foreach ($_POST['course_id'] as $key => $insert_val) {
				$values = "'" . implode ( "', '", array($_POST['student_id'][$key],$_POST['course_id'][$key]) ) . "'";
				$this->dbConfig->createData($this->AssignTable, $AssignsColumn, $values);
			}
		}
		
		$response = array('sussess' => true, 'error_code' => 0, 'message' => 'Couse created');
		echo json_encode($response);
	}

	public function fetchStudentCourse() {
		$response = array();
		$studentTbl = 'students';
		$courseTbl = 'course';
		$students = $this->dbConfig->getData($studentTbl);
		$course = $this->dbConfig->getData($courseTbl);
		$response['students_list'] = $students;
		$response['course_list'] = $course;
		$response = array('sussess' => true, 'error_code' => 0, 'data' => $response);
		echo json_encode($response);
	}

	public function getById(){
		if($_POST["assignedId"]) {
			$where = " id = '".$_POST["assignedId"]."'";
			$row = $this->dbConfig->getData($this->AssignTable, $where);
			echo json_encode($row[0]);

		}
	}

	public function delete(){
		if($_POST["assignedId"]) {
			$filter = "WHERE id = '".$_POST["assignedId"]."'";
			$this->dbConfig->deleteData($this->AssignTable, $filter);	
		}
	}

	public function update() {
		if($_POST['assignedId']) {
			$course_id = $_POST["course_id"];
			$student_id = $_POST["student_id"];
			$id = $_POST["assignedId"];

			//it will delete the old record
			$filter = "WHERE id = '".$_POST["assignedId"]."'";
			$this->dbConfig->deleteData($this->AssignTable, $filter);	
			$AssignsColumn = implode(',',array('student_id','course_id'));
			//Will insert new records
			if(isset($_POST['course_id']) || isset($_POST['student_id'])) {
				//echo 'innn'; exit;
			foreach ($_POST['course_id'] as $key => $insert_val) {
				$values = "'" . implode ( "', '", array($_POST['student_id'][$key],$_POST['course_id'][$key]) ) . "'";
				$this->dbConfig->createData($this->AssignTable, $AssignsColumn, $values);
			}
		}

		}	
	}


}



?>