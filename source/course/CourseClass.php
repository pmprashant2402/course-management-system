<?php
/*
	auther : Prashant Mishra
	Date: 21/03/2021
	Project : Course Management system

*/
$configs = include('http://localhost/sage/source/config.php');
require( $configs['source_base_url'].'DbConfig.php');
require('interface/CourseInterface.php');
class CourseClass implements CourseInterface
{
	
	private $dbConnect = null;
	private $dbConfig;
	private $courseTable = 'course';
	
    public function __construct(){
    	$this->dbConfig = new DbConfig();
    	$this->dbConnect = $this->dbConfig->connect();    }

	public function list() {
		$sqlQuery = "SELECT id, name, details FROM ".$this->courseTable." ";

		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= 'where(id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR name LIKE "%'.$_POST["search"]["value"].'%" ';			
			$sqlQuery .= ' OR details LIKE "%'.$_POST["search"]["value"].'%") ';	
		}
		if(!empty($_POST["order"])){
			$sqlQuery .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		} else {
			$sqlQuery .= 'ORDER BY id DESC ';
		}
		if($_POST["length"] != -1){
			$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}	
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		//echo $sqlQuery;exit;
		$totalQuery = "SELECT name, details FROM ".$this->courseTable."";
		
		$totalRecords = mysqli_query($this->dbConnect, $totalQuery);
		$numRows = mysqli_num_rows($totalRecords);
		$courseData = array();	
		$i = 1;
		while( $course = mysqli_fetch_assoc($result) ) {	
		
			$courseRows = array();			
			$courseRows[] = $i;
			$courseRows[] = ucfirst($course['name']);
			$courseRows[] = $course['details'];							
			$courseRows[] = '<button type="button" name="update" id="'.$course["id"].'" class="btn btn-warning btn-xs update">Update</button>';
			$courseRows[] = '<button type="button" name="delete" id="'.$course["id"].'" class="btn btn-danger btn-xs delete" >Delete</button>';
			$courseData[] = $courseRows;
			$i++;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"  	=>  $numRows,
			"recordsFiltered" 	=> 	$numRows,
			"data"    			=> 	$courseData
		);
		echo json_encode($output);
	}

	public function add() {
		$response = array('sussess' => false, 'error_code' => 0, 'message' => 'Something went wrong');

		$coursesColumn = implode(',',array('name','details'));
		$tableName = $this->courseTable;
		$values = "'" . implode ( "', '", array($_POST["name"],$_POST["details"]) ) . "'";
		$course_id = $this->dbConfig->createData($tableName, $coursesColumn, $values);
		
		try {
				$response = array('sussess' => true, 'error_code' => 0, 'message' => 'Couse created');
				echo json_encode($response);
			    if(!$response) {
		    		 throw new Exception();
			    }
			} catch ( Exception $e) {
				echo $this->errorMessage();
		}
	}

	public function getCourse(){
		if($_POST["courseId"]) {
			$where = " id = '".$_POST["courseId"]."'";
			try {
				$row = $this->dbConfig->getByid($this->courseTable, $where);
				echo json_encode($row);
			    if(!$row) {
		    		 throw new Exception();
			    }
			} catch ( Exception $e) {
				echo $this->errorMessage();
			}
		}
	}

	public function update() {
		if($_POST['courseId']) {	
			$name = $_POST["name"];
			$details = $_POST["details"];
			$id = $_POST["courseId"];
			$updateData = "name = '".$name."', details = '".$details."'";
			$where = "id =" .$id;
		
			try {
				$response = $this->dbConfig->updateData($this->courseTable, $updateData, $where);
			    if(!$response) {
		    		 throw new Exception();
			    }
			} catch ( Exception $e) {
				echo $this->errorMessage();
			}

		}	
	}

	public function delete(){
		if($_POST["courseId"]) {
			$filter = "WHERE id = '".$_POST["courseId"]."'";
			try {
				$deletedId = $this->dbConfig->deleteData($this->courseTable, $filter);
			    if(!$deletedId) {
		    		 throw new Exception();
			    }
			} catch ( Exception $e) {
				echo $this->errorMessage();
			}
			//delete records from assign table also 
			$delete_assigned_course = "WHERE course_id = '".$_POST["courseId"]."'";
			
			try {
				$deletedId = $this->dbConfig->deleteData('assigned_courses', $delete_assigned_course);
			    if(!$deletedId) {
		    		 throw new Exception();
			    }
			} catch ( Exception $e) {
				echo $this->errorMessage();
			}
		}
	}

	private function errorMessage() {
	    $errorMsg = "Not able to process the data";
	    return $errorMsg;
  	}
}



?>